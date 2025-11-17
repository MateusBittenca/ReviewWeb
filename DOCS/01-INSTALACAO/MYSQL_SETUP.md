# 🗄️ Configuração do MySQL - Guia Completo

## 📋 Visão Geral

Este guia mostra como configurar o MySQL para a Plataforma de Reviews em diferentes sistemas operacionais.

## 🪟 Windows

### 1. Instalação

#### Opção 1: MySQL Installer (Recomendado)
1. **Baixe:** [MySQL Installer](https://dev.mysql.com/downloads/installer/)
2. **Execute:** `mysql-installer-community-8.0.x.x.msi`
3. **Selecione:** "Developer Default" ou "Server only"
4. **Configure:** Senha do root durante a instalação

#### Opção 2: XAMPP (Mais Simples)
1. **Baixe:** [XAMPP](https://www.apachefriends.org/download.html)
2. **Instale:** Execute o instalador
3. **Inicie:** MySQL pelo painel do XAMPP

### 2. Configuração

#### Verificar Instalação
```cmd
mysql --version
```

#### Iniciar Serviço
```cmd
# Via Services
services.msc
# Procurar por "MySQL" e iniciar

# Via Command Line
net start mysql
```

#### Conectar ao MySQL
```cmd
mysql -u root -p
# Digite a senha configurada na instalação
```

### 3. Criar Banco de Dados

```sql
-- Conectar ao MySQL
mysql -u root -p

-- Criar banco de dados
CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Criar usuário específico (opcional)
CREATE USER 'reviews_user'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT ALL PRIVILEGES ON reviews_platform.* TO 'reviews_user'@'localhost';
FLUSH PRIVILEGES;

-- Verificar criação
SHOW DATABASES;
```

## 🐧 Linux (Ubuntu/Debian)

### 1. Instalação

```bash
# Atualizar sistema
sudo apt update

# Instalar MySQL
sudo apt install mysql-server

# Configurar segurança
sudo mysql_secure_installation
```

### 2. Configuração

#### Configurar Usuário Root
```bash
# Conectar como root
sudo mysql

# Configurar senha para root
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'sua_senha';
FLUSH PRIVILEGES;
EXIT;
```

#### Criar Banco de Dados
```bash
# Conectar com senha
mysql -u root -p

# Criar banco
CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Criar usuário
CREATE USER 'reviews_user'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT ALL PRIVILEGES ON reviews_platform.* TO 'reviews_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Gerenciar Serviço

```bash
# Iniciar MySQL
sudo systemctl start mysql

# Habilitar inicialização automática
sudo systemctl enable mysql

# Verificar status
sudo systemctl status mysql
```

## 🍎 macOS

### 1. Instalação com Homebrew

```bash
# Instalar Homebrew (se não tiver)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Instalar MySQL
brew install mysql

# Iniciar serviço
brew services start mysql
```

### 2. Configuração

```bash
# Configurar segurança
mysql_secure_installation

# Conectar
mysql -u root -p
```

### 3. Criar Banco de Dados

```sql
-- Mesmo processo do Linux
CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'reviews_user'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT ALL PRIVILEGES ON reviews_platform.* TO 'reviews_user'@'localhost';
FLUSH PRIVILEGES;
```

## 🔧 Configuração da Aplicação

### Arquivo .env

```env
# Configurações do Banco de Dados
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
# ou DB_USERNAME=reviews_user
DB_PASSWORD=sua_senha_mysql
```

### Testar Conexão

```bash
# Via Laravel
php artisan tinker
>>> DB::connection()->getPdo();

# Via PHP direto
php -r "
$pdo = new PDO('mysql:host=127.0.0.1;dbname=reviews_platform', 'root', 'sua_senha');
echo 'Conexão OK!';
"
```

## 🚨 Troubleshooting

### Problema: Acesso Negado

```bash
# Verificar usuários
mysql -u root -p
SELECT User, Host FROM mysql.user;

# Recriar usuário se necessário
DROP USER 'reviews_user'@'localhost';
CREATE USER 'reviews_user'@'localhost' IDENTIFIED BY 'nova_senha';
GRANT ALL PRIVILEGES ON reviews_platform.* TO 'reviews_user'@'localhost';
FLUSH PRIVILEGES;
```

### Problema: Serviço não Inicia

#### Windows
```cmd
# Verificar logs
# C:\ProgramData\MySQL\MySQL Server 8.0\Data\*.err

# Reinstalar serviço
mysqld --install
net start mysql
```

#### Linux
```bash
# Verificar logs
sudo tail -f /var/log/mysql/error.log

# Verificar configuração
sudo mysql --help --verbose
```

### Problema: Porta em Uso

```bash
# Verificar processo usando porta 3306
# Windows
netstat -ano | findstr :3306

# Linux/Mac
lsof -i :3306

# Matar processo
# Windows: taskkill /PID [PID] /F
# Linux/Mac: kill -9 [PID]
```

## 🔒 Segurança

### 1. Configurações Recomendadas

```sql
-- Remover usuários anônimos
DELETE FROM mysql.user WHERE User='';

-- Remover bancos de teste
DROP DATABASE IF EXISTS test;

-- Configurar senhas fortes
ALTER USER 'root'@'localhost' IDENTIFIED BY 'senha_muito_forte';

-- Aplicar mudanças
FLUSH PRIVILEGES;
```

### 2. Firewall

#### Windows
```cmd
# Permitir MySQL através do firewall
netsh advfirewall firewall add rule name="MySQL" dir=in action=allow protocol=TCP localport=3306
```

#### Linux
```bash
# Ubuntu/Debian
sudo ufw allow 3306

# CentOS/RHEL
sudo firewall-cmd --permanent --add-port=3306/tcp
sudo firewall-cmd --reload
```

## 📊 Monitoramento

### 1. Verificar Status

```sql
-- Status do servidor
SHOW STATUS;

-- Processos ativos
SHOW PROCESSLIST;

-- Configurações
SHOW VARIABLES;
```

### 2. Logs

#### Windows
```
C:\ProgramData\MySQL\MySQL Server 8.0\Data\*.err
```

#### Linux
```
/var/log/mysql/error.log
/var/log/mysql/mysql.log
```

#### macOS
```
/usr/local/var/mysql/*.err
```

## 🔄 Backup e Restore

### Backup
```bash
# Backup completo
mysqldump -u root -p --all-databases > backup_completo.sql

# Backup específico
mysqldump -u root -p reviews_platform > backup_reviews.sql

# Backup com compressão
mysqldump -u root -p reviews_platform | gzip > backup_reviews.sql.gz
```

### Restore
```bash
# Restore completo
mysql -u root -p < backup_completo.sql

# Restore específico
mysql -u root -p reviews_platform < backup_reviews.sql

# Restore comprimido
gunzip < backup_reviews.sql.gz | mysql -u root -p reviews_platform
```

## 🎯 Configurações de Performance

### my.cnf / my.ini

```ini
[mysqld]
# Configurações básicas
max_connections = 200
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
query_cache_size = 64M

# Para desenvolvimento
innodb_flush_log_at_trx_commit = 2
sync_binlog = 0
```

---

**💡 Dica:** Sempre teste a conexão após configurar o MySQL!
