# 🚀 Guia de Deploy em Produção

## 📋 Visão Geral

Este guia mostra como fazer deploy da Plataforma de Reviews em um servidor de produção.

## 🎯 Pré-requisitos do Servidor

### Requisitos Mínimos
- **CPU:** 2 cores
- **RAM:** 4GB
- **Disco:** 20GB SSD
- **Sistema:** Ubuntu 20.04+ / CentOS 8+ / Windows Server 2019+

### Software Necessário
- **PHP 8.0+** com extensões: mysql, mbstring, xml, curl, zip
- **Composer 2.0+**
- **Node.js 18+** e npm
- **MySQL 8.0+** ou **PostgreSQL 13+**
- **Nginx** ou **Apache**
- **SSL Certificate** (Let's Encrypt recomendado)

## 🐧 Deploy em Linux (Ubuntu)

### 1. Preparar Servidor

```bash
# Atualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar dependências
sudo apt install -y software-properties-common curl wget git unzip

# Adicionar repositório PHP
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Instalar PHP 8.1
sudo apt install -y php8.1 php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip php8.1-gd php8.1-bcmath

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Instalar MySQL
sudo apt install -y mysql-server
sudo mysql_secure_installation
```

### 2. Configurar Banco de Dados

```bash
# Conectar ao MySQL
sudo mysql

# Criar banco e usuário
CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'reviews_user'@'localhost' IDENTIFIED BY 'senha_super_segura';
GRANT ALL PRIVILEGES ON reviews_platform.* TO 'reviews_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Deploy da Aplicação

```bash
# Criar usuário para aplicação
sudo adduser --system --group --home /var/www/reviews-platform reviews

# Clonar repositório
cd /var/www
sudo git clone https://github.com/seu-usuario/reviews-platform.git
sudo chown -R reviews:reviews reviews-platform
cd reviews-platform

# Instalar dependências PHP
sudo -u reviews composer install --optimize-autoloader --no-dev

# Instalar dependências Node.js
cd frontend
sudo -u reviews npm install
sudo -u reviews npm run build
cd ..

# Configurar ambiente
sudo -u reviews cp .env.example .env
sudo nano .env
```

### 4. Configurar .env para Produção

```env
APP_NAME="Reviews Platform"
APP_ENV=production
APP_KEY=base64:sua_chave_aqui
APP_DEBUG=false
APP_URL=https://seudominio.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=reviews_user
DB_PASSWORD=senha_super_segura

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 5. Configurar Aplicação

```bash
# Gerar chave
sudo -u reviews php artisan key:generate

# Executar migrações
sudo -u reviews php artisan migrate --force

# Executar seeders
sudo -u reviews php artisan db:seed --force

# Configurar permissões
sudo chown -R reviews:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Otimizar aplicação
sudo -u reviews php artisan config:cache
sudo -u reviews php artisan route:cache
sudo -u reviews php artisan view:cache
```

### 6. Configurar Nginx

```bash
# Instalar Nginx
sudo apt install -y nginx

# Criar configuração do site
sudo nano /etc/nginx/sites-available/reviews-platform
```

**Conteúdo do arquivo de configuração:**

```nginx
server {
    listen 80;
    server_name seudominio.com www.seudominio.com;
    root /var/www/reviews-platform/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Ativar site
sudo ln -s /etc/nginx/sites-available/reviews-platform /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 7. Configurar SSL (Let's Encrypt)

```bash
# Instalar Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obter certificado
sudo certbot --nginx -d seudominio.com -d www.seudominio.com

# Configurar renovação automática
sudo crontab -e
# Adicionar linha:
# 0 12 * * * /usr/bin/certbot renew --quiet
```

## 🪟 Deploy em Windows Server

### 1. Preparar Servidor

```powershell
# Instalar Chocolatey
Set-ExecutionPolicy Bypass -Scope Process -Force
[System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))

# Instalar dependências
choco install php composer nodejs mysql -y
```

### 2. Configurar IIS

```powershell
# Instalar IIS e módulos necessários
Enable-WindowsOptionalFeature -Online -FeatureName IIS-WebServerRole
Enable-WindowsOptionalFeature -Online -FeatureName IIS-WebServer
Enable-WindowsOptionalFeature -Online -FeatureName IIS-CommonHttpFeatures
Enable-WindowsOptionalFeature -Online -FeatureName IIS-HttpErrors
Enable-WindowsOptionalFeature -Online -FeatureName IIS-HttpLogging
Enable-WindowsOptionalFeature -Online -FeatureName IIS-RequestFiltering
Enable-WindowsOptionalFeature -Online -FeatureName IIS-StaticContent
Enable-WindowsOptionalFeature -Online -FeatureName IIS-DefaultDocument
Enable-WindowsOptionalFeature -Online -FeatureName IIS-DirectoryBrowsing
```

### 3. Configurar PHP-FPM

```powershell
# Baixar e configurar PHP Manager
# Configurar FastCGI para PHP
```

## 🔧 Configurações de Produção

### 1. Otimizações PHP

```ini
# php.ini
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 10M
post_max_size = 10M
opcache.enable = 1
opcache.memory_consumption = 128
opcache.max_accelerated_files = 4000
```

### 2. Otimizações MySQL

```sql
-- my.cnf
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
max_connections = 200
query_cache_size = 64M
```

### 3. Configurar Queue (Opcional)

```bash
# Instalar Redis
sudo apt install -y redis-server

# Configurar supervisor
sudo apt install -y supervisor

# Criar configuração
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
```

**Conteúdo:**

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/reviews-platform/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=reviews
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/reviews-platform/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

## 📊 Monitoramento

### 1. Logs

```bash
# Configurar rotação de logs
sudo nano /etc/logrotate.d/laravel
```

**Conteúdo:**

```
/var/www/reviews-platform/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    create 644 reviews www-data
}
```

### 2. Backup Automático

```bash
# Criar script de backup
sudo nano /usr/local/bin/backup-reviews.sh
```

**Conteúdo:**

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/reviews-platform"
DB_NAME="reviews_platform"
DB_USER="reviews_user"
DB_PASS="senha_super_segura"

# Criar diretório se não existir
mkdir -p $BACKUP_DIR

# Backup do banco
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup dos arquivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/reviews-platform

# Manter apenas últimos 7 backups
find $BACKUP_DIR -name "*.gz" -mtime +7 -delete
```

```bash
# Tornar executável
sudo chmod +x /usr/local/bin/backup-reviews.sh

# Configurar cron
sudo crontab -e
# Adicionar linha:
# 0 2 * * * /usr/local/bin/backup-reviews.sh
```

## 🔒 Segurança

### 1. Firewall

```bash
# Configurar UFW
sudo ufw enable
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw deny 3306
```

### 2. Configurações de Segurança

```bash
# Desabilitar login root
sudo passwd -l root

# Configurar SSH
sudo nano /etc/ssh/sshd_config
# PermitRootLogin no
# PasswordAuthentication no
sudo systemctl restart ssh
```

## 🚀 Deploy Automatizado

### 1. Script de Deploy

```bash
# Criar script
sudo nano /usr/local/bin/deploy-reviews.sh
```

**Conteúdo:**

```bash
#!/bin/bash
cd /var/www/reviews-platform

# Pull latest changes
git pull origin main

# Install/update dependencies
composer install --optimize-autoloader --no-dev
cd frontend && npm install && npm run build && cd ..

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo systemctl reload nginx
sudo systemctl restart php8.1-fpm
```

### 2. Webhook GitHub

```bash
# Criar endpoint para webhook
sudo nano /var/www/reviews-platform/deploy.php
```

**Conteúdo:**

```php
<?php
if ($_POST['payload']) {
    $payload = json_decode($_POST['payload'], true);
    if ($payload['ref'] === 'refs/heads/main') {
        exec('/usr/local/bin/deploy-reviews.sh');
    }
}
?>
```

---

**💡 Dica:** Sempre teste o deploy em um ambiente de staging antes de ir para produção!
