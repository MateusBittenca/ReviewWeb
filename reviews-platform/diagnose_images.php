<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Company;
use Illuminate\Support\Facades\Storage;

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   DIAGNÓSTICO DE IMAGENS - Reviews Platform            ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

// 1. Verificar storage link
echo "[1/6] Verificando storage link...\n";
$storageLink = public_path('storage');
$targetPath = storage_path('app/public');

if (is_dir($storageLink) || is_link($storageLink)) {
    // Verificar se o link aponta para o lugar certo
    if (is_link($storageLink)) {
        $target = readlink($storageLink);
        echo "   ✅ Link simbólico existe: $storageLink -> $target\n";
    } else {
        // No Windows, pode ser um junction point
        echo "   ✅ Diretório/link existe: $storageLink\n";
    }
    
    // Verificar se consegue acessar arquivos através do link
    $testFile = 'logos/mW2PgKis5fWEje7vOEdzgHXDFDRTKJAplWYVOAwZ.png';
    $linkFile = $storageLink . '/' . $testFile;
    if (file_exists($linkFile)) {
        echo "   ✅ Arquivo acessível através do link!\n";
    } else {
        echo "   ⚠️  Arquivo não acessível através do link\n";
    }
} else {
    echo "   ❌ Link não existe! Execute: php artisan storage:link\n";
}
echo "\n";

// 2. Verificar diretórios
echo "[2/6] Verificando diretórios...\n";
$logosDir = storage_path('app/public/logos');
$backgroundsDir = storage_path('app/public/backgrounds');

if (is_dir($logosDir)) {
    echo "   ✅ Diretório logos existe: $logosDir\n";
} else {
    echo "   ❌ Diretório logos NÃO existe: $logosDir\n";
    mkdir($logosDir, 0755, true);
    echo "   ✅ Diretório logos criado!\n";
}

if (is_dir($backgroundsDir)) {
    echo "   ✅ Diretório backgrounds existe: $backgroundsDir\n";
} else {
    echo "   ❌ Diretório backgrounds NÃO existe: $backgroundsDir\n";
    mkdir($backgroundsDir, 0755, true);
    echo "   ✅ Diretório backgrounds criado!\n";
}
echo "\n";

// 3. Listar arquivos salvos
echo "[3/6] Arquivos em storage/app/public/logos:\n";
$logoFiles = Storage::disk('public')->files('logos');
if (count($logoFiles) > 0) {
    foreach ($logoFiles as $file) {
        $size = Storage::disk('public')->size($file);
        echo "   - $file (" . number_format($size / 1024, 2) . " KB)\n";
    }
} else {
    echo "   ⚠️  Nenhum arquivo encontrado\n";
}
echo "\n";

echo "[4/6] Arquivos em storage/app/public/backgrounds:\n";
$bgFiles = Storage::disk('public')->files('backgrounds');
if (count($bgFiles) > 0) {
    foreach ($bgFiles as $file) {
        $size = Storage::disk('public')->size($file);
        echo "   - $file (" . number_format($size / 1024, 2) . " KB)\n";
    }
} else {
    echo "   ⚠️  Nenhum arquivo encontrado\n";
}
echo "\n";

// 4. Verificar empresas no banco
echo "[5/6] Verificando empresas no banco de dados...\n";
$companies = Company::whereNotNull('logo')->orWhereNotNull('background_image')->get();
echo "   Total de empresas com imagens: " . $companies->count() . "\n\n";

foreach ($companies as $company) {
    echo "   Empresa: {$company->name} (ID: {$company->id})\n";
    
    if ($company->logo) {
        echo "      Logo no banco: {$company->logo}\n";
        echo "      Logo URL: {$company->logo_url}\n";
        $exists = Storage::disk('public')->exists($company->logo);
        echo "      Arquivo existe: " . ($exists ? "✅ SIM" : "❌ NÃO") . "\n";
        if ($exists) {
            $fullPath = Storage::disk('public')->path($company->logo);
            echo "      Caminho completo: $fullPath\n";
        }
    } else {
        echo "      Logo: ❌ Não definido\n";
    }
    
    if ($company->background_image) {
        echo "      Background no banco: {$company->background_image}\n";
        echo "      Background URL: {$company->background_image_url}\n";
        $exists = Storage::disk('public')->exists($company->background_image);
        echo "      Arquivo existe: " . ($exists ? "✅ SIM" : "❌ NÃO") . "\n";
    } else {
        echo "      Background: ❌ Não definido\n";
    }
    echo "\n";
}

// 5. Testar acesso
echo "[6/6] Testando acesso às URLs...\n";
if ($companies->count() > 0) {
    $testCompany = $companies->first();
    if ($testCompany->logo) {
        $url = $testCompany->logo_url;
        echo "   URL de teste: $url\n";
        echo "   Acesse esta URL no navegador para verificar se a imagem carrega\n";
    }
} else {
    echo "   ⚠️  Nenhuma empresa com imagens para testar\n";
}

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   DIAGNÓSTICO CONCLUÍDO                                ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

