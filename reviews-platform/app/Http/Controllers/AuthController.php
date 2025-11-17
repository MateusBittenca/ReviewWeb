<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
}