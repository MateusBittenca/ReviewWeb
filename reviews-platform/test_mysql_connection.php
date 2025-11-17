<?php
/**
 * Script de Teste de Conexão MySQL
 * 
 * Use este script para verificar se a conexão com o MySQL está funcionando
 * antes de iniciar a aplicação.
 * 
 * Uso: php test_mysql_connection.php
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   TESTE DE CONEXÃO MYSQL - Reviews Platform            ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

// Carregar variáveis do .env
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    echo "❌ ERRO: Arquivo .env não encontrado!\n";
    echo "   Caminho esperado: $envFile\n";
    echo "\n";
    exit(1);
}

// Ler configurações do .env
$env = parse_ini_file($envFile);
$dbHost = $env['DB_HOST'] ?? '127.0.0.1';
$dbPort = $env['DB_PORT'] ?? '3306';
$dbDatabase = $env['DB_DATABASE'] ?? 'reviews_platform';
$dbUsername = $env['DB_USERNAME'] ?? 'root';
$dbPassword = $env['DB_PASSWORD'] ?? '';

echo "[1/4] Verificando arquivo .env...\n";
echo "   ✅ Arquivo .env encontrado\n";
echo "\n";

echo "[2/4] Configurações do banco:\n";
echo "   Host: $dbHost\n";
echo "   Porta: $dbPort\n";
echo "   Banco: $dbDatabase\n";
echo "   Usuário: $dbUsername\n";
echo "   Senha: " . (empty($dbPassword) ? "(vazia)" : "***") . "\n";
echo "\n";

echo "[3/4] Testando conexão com MySQL...\n";
try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✅ Conexão com MySQL estabelecida com sucesso!\n";
} catch (PDOException $e) {
    echo "   ❌ ERRO ao conectar com MySQL:\n";
    echo "      " . $e->getMessage() . "\n";
    echo "\n";
    echo "   💡 SOLUÇÕES:\n";
    echo "      1. Verifique se o MySQL está rodando (XAMPP Control Panel)\n";
    echo "      2. Verifique se a porta 3306 está livre\n";
    echo "      3. Verifique as credenciais no arquivo .env\n";
    echo "\n";
    exit(1);
}

echo "\n";

echo "[4/4] Verificando se o banco de dados existe...\n";
try {
    $result = $pdo->query("SHOW DATABASES LIKE '$dbDatabase'");
    if ($result->rowCount() > 0) {
        echo "   ✅ Banco de dados '$dbDatabase' existe\n";
        
        // Verificar tabelas
        $pdo->exec("USE $dbDatabase");
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "   ✅ Encontradas " . count($tables) . " tabelas no banco\n";
        
        if (count($tables) > 0) {
            echo "\n   Tabelas encontradas:\n";
            foreach ($tables as $table) {
                echo "      - $table\n";
            }
        }
    } else {
        echo "   ⚠️  Banco de dados '$dbDatabase' NÃO existe!\n";
        echo "\n";
        echo "   💡 SOLUÇÃO:\n";
        echo "      Execute: php artisan migrate\n";
        echo "      Ou crie manualmente: CREATE DATABASE $dbDatabase;\n";
    }
} catch (PDOException $e) {
    echo "   ❌ ERRO ao verificar banco de dados:\n";
    echo "      " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   ✅ TESTE CONCLUÍDO COM SUCESSO!                      ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";
echo "O sistema está pronto para iniciar!\n";
echo "\n";





