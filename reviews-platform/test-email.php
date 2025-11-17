<?php

// Script de teste de email para Reviews Platform
// Execute: php test-email.php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Mail;
use App\Mail\NewReviewNotification;
use App\Models\Company;
use App\Models\Review;

// Carregar configuração Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "📧 TESTE DE CONFIGURAÇÃO DE EMAIL\n";
echo "==================================\n\n";

// Verificar configuração atual
echo "🔧 Configuração atual:\n";
echo "MAIL_MAILER: " . config('mail.default') . "\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "MAIL_FROM_NAME: " . config('mail.from.name') . "\n\n";

// Solicitar email de teste
echo "📮 Digite o email para teste: ";
$testEmail = trim(fgets(STDIN));

if (empty($testEmail)) {
    echo "❌ Email não informado!\n";
    exit(1);
}

echo "\n🧪 Testando envio de email...\n";

try {
    // Teste 1: Email simples
    echo "1️⃣ Enviando email simples...\n";
    Mail::raw('Este é um teste de configuração de email do Reviews Platform!', function ($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('✅ Teste de Email - Reviews Platform');
    });
    echo "✅ Email simples enviado com sucesso!\n\n";

    // Teste 2: Email com template (se existir dados)
    echo "2️⃣ Testando template de notificação...\n";
    
    $company = Company::first();
    $review = Review::first();
    
    if ($company && $review) {
        Mail::to($testEmail)->send(new NewReviewNotification($company, $review));
        echo "✅ Template de notificação enviado com sucesso!\n\n";
    } else {
        echo "⚠️ Não há dados de empresa/avaliação para testar o template\n\n";
    }

    echo "🎉 TESTE CONCLUÍDO COM SUCESSO!\n";
    echo "📧 Verifique sua caixa de entrada: $testEmail\n";
    echo "📁 Verifique também a pasta de spam/lixo eletrônico\n\n";

} catch (Exception $e) {
    echo "❌ ERRO NO ENVIO:\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . "\n";
    echo "Linha: " . $e->getLine() . "\n\n";
    
    echo "🔧 SOLUÇÕES POSSÍVEIS:\n";
    echo "1. Verifique as credenciais no arquivo .env\n";
    echo "2. Para Gmail, use senha de app (não senha normal)\n";
    echo "3. Verifique se a verificação em duas etapas está ativa\n";
    echo "4. Teste com Mailtrap primeiro (mais fácil)\n";
    echo "5. Verifique se a porta 587 não está bloqueada\n\n";
    
    echo "📖 Consulte o arquivo EMAIL_SETUP_GUIDE.md para mais detalhes\n";
}

echo "\n📝 Para testar manualmente:\n";
echo "php artisan tinker\n";
echo "Mail::raw('Teste', function(\$m) { \$m->to('$testEmail')->subject('Teste'); });\n";
