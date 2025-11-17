<?php
/**
 * Script de Teste de Conexão MySQL
 * Execute: php test_mysql_connection.php
 */

echo "🔍 Testando Conexão MySQL...\n\n";

// Carregar configurações do Laravel
require_once 'vendor/autoload.php';

// Carregar .env
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Configurações do banco
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? '3306';
$database = $_ENV['DB_DATABASE'] ?? 'reviews_platform';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

echo "📋 Configurações:\n";
echo "   Host: $host\n";
echo "   Port: $port\n";
echo "   Database: $database\n";
echo "   Username: $username\n";
echo "   Password: " . (empty($password) ? '(vazio)' : '***') . "\n\n";

// Teste 1: Verificar extensão PDO
echo "1️⃣ Verificando extensão PDO...\n";
if (extension_loaded('pdo')) {
    echo "   ✅ PDO está carregado\n";
} else {
    echo "   ❌ PDO não está carregado\n";
    exit(1);
}

if (extension_loaded('pdo_mysql')) {
    echo "   ✅ PDO MySQL está carregado\n";
} else {
    echo "   ❌ PDO MySQL não está carregado\n";
    echo "   💡 Instale: sudo apt-get install php-mysql (Ubuntu)\n";
    exit(1);
}

// Teste 2: Conectar ao MySQL
echo "\n2️⃣ Testando conexão com MySQL...\n";
try {
    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "   ✅ Conexão com MySQL bem-sucedida\n";
} catch (PDOException $e) {
    echo "   ❌ Erro na conexão: " . $e->getMessage() . "\n";
    echo "   💡 Verifique se MySQL está rodando e as credenciais estão corretas\n";
    exit(1);
}

// Teste 3: Verificar se o banco existe
echo "\n3️⃣ Verificando banco de dados...\n";
try {
    $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
    $result = $stmt->fetch();
    
    if ($result) {
        echo "   ✅ Banco '$database' existe\n";
    } else {
        echo "   ❌ Banco '$database' não existe\n";
        echo "   💡 Criando banco de dados...\n";
        
        $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "   ✅ Banco '$database' criado com sucesso\n";
    }
} catch (PDOException $e) {
    echo "   ❌ Erro ao verificar/criar banco: " . $e->getMessage() . "\n";
    exit(1);
}

// Teste 4: Conectar ao banco específico
echo "\n4️⃣ Conectando ao banco específico...\n";
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "   ✅ Conexão com banco '$database' bem-sucedida\n";
} catch (PDOException $e) {
    echo "   ❌ Erro ao conectar ao banco: " . $e->getMessage() . "\n";
    exit(1);
}

// Teste 5: Verificar tabelas existentes
echo "\n5️⃣ Verificando tabelas existentes...\n";
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "   ⚠️  Nenhuma tabela encontrada\n";
        echo "   💡 Execute: php artisan migrate\n";
    } else {
        echo "   ✅ Tabelas encontradas:\n";
        foreach ($tables as $table) {
            echo "      - $table\n";
        }
    }
} catch (PDOException $e) {
    echo "   ❌ Erro ao verificar tabelas: " . $e->getMessage() . "\n";
}

// Teste 6: Teste de query simples
echo "\n6️⃣ Testando query simples...\n";
try {
    $stmt = $pdo->query("SELECT 1 as test, NOW() as current_time");
    $result = $stmt->fetch();
    echo "   ✅ Query executada com sucesso\n";
    echo "   📊 Resultado: " . json_encode($result) . "\n";
} catch (PDOException $e) {
    echo "   ❌ Erro na query: " . $e->getMessage() . "\n";
}

// Teste 7: Verificar versão do MySQL
echo "\n7️⃣ Informações do MySQL...\n";
try {
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch();
    echo "   📊 Versão: " . $result['version'] . "\n";
    
    $stmt = $pdo->query("SELECT @@character_set_database as charset");
    $result = $stmt->fetch();
    echo "   📊 Charset: " . $result['charset'] . "\n";
} catch (PDOException $e) {
    echo "   ❌ Erro ao obter informações: " . $e->getMessage() . "\n";
}

echo "\n🎉 Teste de conexão concluído!\n";
echo "\n📝 Próximos passos:\n";
echo "   1. php artisan migrate\n";
echo "   2. php artisan db:seed --class=AdminUserSeeder\n";
echo "   3. php artisan serve\n";
echo "   4. Acesse: http://localhost:8000/login\n";





