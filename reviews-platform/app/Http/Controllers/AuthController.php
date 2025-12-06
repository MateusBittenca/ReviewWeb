<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordResetCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetCodeMail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            Log::info('Login realizado com sucesso', [
                'user_id' => Auth::id(),
                'email' => $request->email
            ]);

            return redirect()->intended('/dashboard');
        }

        Log::warning('Tentativa de login falhada', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não coincidem com nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Create admin user (for initial setup)
     */
    public function createAdmin()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@reviewsplatform.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Usuário admin criado com sucesso!',
            'credentials' => [
                'email' => 'admin@reviewsplatform.com',
                'password' => 'admin123'
            ]
        ]);
    }

    /**
     * Mostrar formulário de solicitação de recuperação de senha
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Enviar código de recuperação por email
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Sempre retornar sucesso (por segurança, não revelar se email existe)
        if (!$user) {
            return back()->with('success', 'Se o email existir em nosso sistema, você receberá um código de recuperação.');
        }

        // Limpar códigos expirados
        PasswordResetCode::cleanExpired();

        // Invalidar códigos anteriores não usados do mesmo email
        PasswordResetCode::where('email', $request->email)
            ->where('used', false)
            ->delete();

        // Gerar código de 6 dígitos
        $code = str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Salvar código no banco (válido por 15 minutos)
        PasswordResetCode::create([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => now()->addMinutes(15),
            'used' => false,
        ]);

        // Enviar email com código usando Mailable (igual aos emails de avaliação)
        try {
            $mailer = config('mail.default');
            
            Mail::to($user->email, $user->name)->send(new PasswordResetCodeMail($user, $code, 15));

            Log::info('Código de recuperação enviado', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'mailer' => $mailer,
                'code' => $code
            ]);
            
            // Se estiver em modo log (desenvolvimento), mostrar código na tela
            if ($mailer === 'log' || config('app.debug')) {
                // Salvar código na sessão para mostrar na próxima tela
                session(['password_reset_code_display' => $code]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar email de recuperação', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Não falhar silenciosamente - informar ao usuário
            return back()->withErrors(['email' => 'Erro ao enviar email. Verifique as configurações de email do sistema.']);
        }

        // Salvar email na sessão para próxima etapa
        session(['password_reset_email' => $request->email]);

        $message = 'Código de recuperação enviado para seu email!';
        if ($mailer === 'log' || config('app.debug')) {
            $message .= ' (Modo desenvolvimento: verifique o código abaixo)';
        }

        return redirect()->route('password.reset.code')->with('success', $message);
    }

    /**
     * Mostrar formulário para inserir código
     */
    public function showResetCodeForm()
    {
        if (!session('password_reset_email')) {
            return redirect()->route('password.forgot')->with('error', 'Por favor, solicite um novo código de recuperação.');
        }

        return view('auth.reset-password-code');
    }

    /**
     * Verificar código e mostrar formulário de redefinição
     */
    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.forgot')->with('error', 'Sessão expirada. Por favor, solicite um novo código.');
        }

        // Buscar código válido
        $resetCode = PasswordResetCode::where('email', $email)
            ->where('code', $request->code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$resetCode) {
            return back()->withErrors(['code' => 'Código inválido ou expirado.'])->withInput();
        }

        // Marcar código como usado
        $resetCode->markAsUsed();

        // Salvar token na sessão para redefinição
        session(['password_reset_verified' => true]);

        return redirect()->route('password.reset')->with('success', 'Código verificado com sucesso! Agora você pode definir uma nova senha.');
    }

    /**
     * Mostrar formulário de redefinição de senha
     */
    public function showResetPasswordForm()
    {
        if (!session('password_reset_verified') || !session('password_reset_email')) {
            return redirect()->route('password.forgot')->with('error', 'Por favor, verifique o código primeiro.');
        }

        return view('auth.reset-password');
    }

    /**
     * Redefinir senha
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        if (!session('password_reset_verified') || !session('password_reset_email')) {
            return redirect()->route('password.forgot')->with('error', 'Sessão expirada. Por favor, solicite um novo código.');
        }

        $email = session('password_reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.forgot')->with('error', 'Usuário não encontrado.');
        }

        // Atualizar senha
        $user->password = Hash::make($request->password);
        $user->save();

        // Limpar sessão
        session()->forget(['password_reset_email', 'password_reset_verified']);

        Log::info('Senha redefinida com sucesso', [
            'email' => $email,
            'user_id' => $user->id
        ]);

        return redirect()->route('login')->with('success', 'Senha redefinida com sucesso! Faça login com sua nova senha.');
    }
}