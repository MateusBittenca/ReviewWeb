# Configurações MySQL para Diferentes Ambientes

## 🏠 Desenvolvimento Local

### .env (Desenvolvimento)
```env
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=

# Para XAMPP/WAMP
# DB_HOST=localhost
# DB_PORT=3306
# DB_USERNAME=root
# DB_PASSWORD=

# Para Docker
# DB_HOST=mysql
# DB_PORT=3306
# DB_USERNAME=root
# DB_PASSWORD=password
```

## 🐳 Docker Setup

### docker-compose.yml
```yaml
version: '3.8'

services:
  mysql:
    image: mysql:8.0
    container_name: reviews_mysql
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: reviews_platform
      MYSQL_USER: reviews_user
      MYSQL_PASSWORD: reviews_pass
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
    command: --default-authentication-plugin=mysql_native_password

  app:
    build: .
    container_name: reviews_app
    ports:
      - "8000:8000"
    depends_on:
      - mysql
    environment:
      DB_HOST: mysql
      DB_PORT: 3306
      DB_DATABASE: reviews_platform
      DB_USERNAME: reviews_user
      DB_PASSWORD: reviews_pass

volumes:
  mysql_data:
```

### Dockerfile
```dockerfile
FROM php:8.2-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Instalar dependências
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

## 🚀 Produção

### .env (Produção)
```env
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=reviews_platform_prod
DB_USERNAME=reviews_prod_user
DB_PASSWORD=senha_muito_segura_aqui

# Configurações de produção
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

# Pool de conexões
DB_POOL_SIZE=10
DB_TIMEOUT=30
```

### Configurações MySQL para Produção

#### my.cnf
```ini
[mysqld]
# Configurações básicas
port = 3306
bind-address = 127.0.0.1

# Charset
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci

# InnoDB
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT

# Conexões
max_connections = 200
max_connect_errors = 1000

# Query Cache
query_cache_size = 64M
query_cache_type = 1
query_cache_limit = 2M

# Timeouts
wait_timeout = 28800
interactive_timeout = 28800

# Logs
log-error = /var/log/mysql/error.log
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2

# Segurança
local_infile = 0
```

## 🔧 Scripts de Configuração

### setup_mysql.sh (Linux/Mac)
```bash
#!/bin/bash

echo "🔧 Configurando MySQL para Plataforma de Avaliações..."

# Verificar se MySQL está instalado
if ! command -v mysql &> /dev/null; then
    echo "❌ MySQL não está instalado"
    echo "💡 Instale com: sudo apt-get install mysql-server"
    exit 1
fi

# Verificar se MySQL está rodando
if ! systemctl is-active --quiet mysql; then
    echo "🔄 Iniciando MySQL..."
    sudo systemctl start mysql
fi

# Criar banco de dados
echo "📊 Criando banco de dados..."
mysql -u root -p << EOF
CREATE DATABASE IF NOT EXISTS reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'reviews_user'@'localhost' IDENTIFIED BY 'reviews_pass_123';
GRANT ALL PRIVILEGES ON reviews_platform.* TO 'reviews_user'@'localhost';
FLUSH PRIVILEGES;
EOF

echo "✅ Configuração concluída!"
echo "📝 Use estas credenciais no .env:"
echo "   DB_DATABASE=reviews_platform"
echo "   DB_USERNAME=reviews_user"
echo "   DB_PASSWORD=reviews_pass_123"
```

### setup_mysql.bat (Windows)
```batch
@echo off
echo 🔧 Configurando MySQL para Plataforma de Avaliações...

REM Verificar se MySQL está instalado
mysql --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ MySQL não está instalado ou não está no PATH
    echo 💡 Instale MySQL e adicione ao PATH
    pause
    exit /b 1
)

REM Verificar se MySQL está rodando
sc query mysql >nul 2>&1
if %errorlevel% neq 0 (
    echo 🔄 Iniciando MySQL...
    net start mysql
)

REM Criar banco de dados
echo 📊 Criando banco de dados...
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE USER IF NOT EXISTS 'reviews_user'@'localhost' IDENTIFIED BY 'reviews_pass_123'; GRANT ALL PRIVILEGES ON reviews_platform.* TO 'reviews_user'@'localhost'; FLUSH PRIVILEGES;"

echo ✅ Configuração concluída!
echo 📝 Use estas credenciais no .env:
echo    DB_DATABASE=reviews_platform
echo    DB_USERNAME=reviews_user
echo    DB_PASSWORD=reviews_pass_123

pause
```

## 🧪 Testes de Conexão

### test_connection.php
```php
<?php
// Teste rápido de conexão
$configs = [
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'reviews_platform',
    'username' => 'root',
    'password' => ''
];

try {
    $dsn = "mysql:host={$configs['host']};port={$configs['port']};dbname={$configs['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $configs['username'], $configs['password']);
    echo "✅ Conexão bem-sucedida!\n";
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}
?>
```

## 📊 Monitoramento

### check_mysql_status.php
```php
<?php
// Verificar status do MySQL
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');

echo "📊 Status do MySQL:\n";

// Versão
$stmt = $pdo->query("SELECT VERSION() as version");
echo "Versão: " . $stmt->fetch()['version'] . "\n";

// Status
$stmt = $pdo->query("SHOW STATUS LIKE 'Uptime'");
echo "Uptime: " . $stmt->fetch()['Value'] . " segundos\n";

// Conexões
$stmt = $pdo->query("SHOW STATUS LIKE 'Connections'");
echo "Conexões: " . $stmt->fetch()['Value'] . "\n";

// Queries
$stmt = $pdo->query("SHOW STATUS LIKE 'Queries'");
echo "Queries: " . $stmt->fetch()['Value'] . "\n";
?>
```

## 🔒 Segurança

### Configurações de Segurança
```sql
-- Remover usuários anônimos
DELETE FROM mysql.user WHERE User='';

-- Remover acesso root remoto
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');

-- Aplicar mudanças
FLUSH PRIVILEGES;

-- Verificar usuários
SELECT User, Host FROM mysql.user;
```

### Backup Automático
```bash
#!/bin/bash
# backup_mysql.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/mysql"
DB_NAME="reviews_platform"

mkdir -p $BACKUP_DIR

mysqldump -u root -p $DB_NAME > $BACKUP_DIR/${DB_NAME}_${DATE}.sql

# Manter apenas os últimos 7 backups
ls -t $BACKUP_DIR/${DB_NAME}_*.sql | tail -n +8 | xargs rm -f

echo "✅ Backup criado: ${DB_NAME}_${DATE}.sql"
```

## 📝 Checklist de Configuração

### Desenvolvimento
- [ ] MySQL instalado e rodando
- [ ] Banco de dados criado
- [ ] Arquivo .env configurado
- [ ] Teste de conexão executado
- [ ] Migrations rodadas
- [ ] Seeders executados

### Produção
- [ ] MySQL otimizado para produção
- [ ] Usuário específico criado
- [ ] Senhas seguras configuradas
- [ ] Backup automático configurado
- [ ] Monitoramento ativo
- [ ] Logs configurados
- [ ] SSL/TLS configurado (se necessário)

---

**Dica**: Execute `php test_mysql_connection.php` para verificar se tudo está funcionando! 🚀





