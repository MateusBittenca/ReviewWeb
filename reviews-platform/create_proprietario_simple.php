<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Verificar argumentos da linha de comando
$name = $argv[1] ?? null;
$email = $argv[2] ?? null;
$password = $argv[3] ?? null;

if (!$name || !$email || !$password) {
    echo "\n";
    echo "╔════════════════════════════════════════════════════════╗\n";
    echo "║   CRIAR USUÁRIO PROPRIETÁRIO                           ║\n";
    echo "╚════════════════════════════════════════════════════════╝\n";
    echo "\n";
    echo "📖 Uso: php create_proprietario_simple.php \"Nome Completo\" \"email@exemplo.com\" \"senha123\"\n";
    echo "\n";
    echo "Exemplo:\n";
    echo "  php create_proprietario_simple.php \"João Silva\" \"joao@exemplo.com\" \"senha123\"\n";
    echo "\n";
    exit(1);
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Email inválido: $email\n";
    exit(1);
}

// Validar senha
if (strlen($password) < 6) {
    echo "❌ Senha deve ter no mínimo 6 caracteres!\n";
    exit(1);
}

// Verificar se email já existe
$existingUser = User::where('email', $email)->first();

if ($existingUser) {
    echo "\n⚠️  Este email já está cadastrado!\n";
    echo "   Atualizando usuário existente para proprietário...\n";
    
    $existingUser->name = $name;
    $existingUser->password = Hash::make($password);
    $existingUser->role = 'proprietario';
    $existingUser->save();
    
    $user = $existingUser;
    $action = "ATUALIZADO";
} else {
    // Criar novo usuário
    try {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'proprietario'
        ]);
        $action = "CRIADO";
    } catch (\Exception $e) {
        echo "\n❌ Erro ao criar usuário: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Exibir resultado
echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   ✅ USUÁRIO PROPRIETÁRIO $action COM SUCESSO!            ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "📧 Email: $email\n";
echo "👤 Nome: $name\n";
echo "👑 Função: Proprietário\n";
echo "🔑 Senha: $password\n";
echo "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "ℹ️  O usuário proprietário tem acesso total ao sistema:\n";
echo "   • Pode gerenciar todos os usuários\n";
echo "   • Pode criar/editar/excluir empresas\n";
echo "   • Pode ver todas as avaliações\n";
echo "   • Acesso completo ao sistema\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "\n";

