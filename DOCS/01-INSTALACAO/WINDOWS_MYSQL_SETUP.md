# 🪟 Instalação MySQL no Windows - Guia Completo

## ❌ Problema Identificado
O erro `'mysql' não é reconhecido` indica que:
- MySQL não está instalado, OU
- MySQL está instalado mas não está no PATH do sistema

## 🚀 Soluções Disponíveis

### **Opção 1: XAMPP (Recomendado para Desenvolvimento)**

#### 1.1 Baixar e Instalar XAMPP
1. Acesse: https://www.apachefriends.org/download.html
2. Baixe a versão para Windows (PHP 8.2+)
3. Execute o instalador como administrador
4. Marque: Apache, MySQL, PHP, phpMyAdmin
5. Instale em `C:\xampp`

#### 1.2 Configurar XAMPP
```bash
# Após instalação, inicie o XAMPP Control Panel
# Clique em "Start" ao lado de MySQL
# Clique em "Start" ao lado de Apache
```

#### 1.3 Configurar PATH (Opcional)
```bash
# Adicionar ao PATH do Windows:
# C:\xampp\mysql\bin
# C:\xampp\php

# Para adicionar:
# 1. Win + R → sysdm.cpl
# 2. Avançado → Variáveis de Ambiente
# 3. Editar PATH → Novo
# 4. Adicionar: C:\xampp\mysql\bin
```

#### 1.4 Testar XAMPP
```bash
# Abrir novo CMD e testar:
mysql --version
php --version
```

### **Opção 2: MySQL Server Oficial**

#### 2.1 Baixar MySQL
1. Acesse: https://dev.mysql.com/downloads/mysql/
2. Baixe "MySQL Community Server"
3. Escolha "Windows (x86, 64-bit), MSI Installer"

#### 2.2 Instalar MySQL
1. Execute o instalador como administrador
2. Escolha "Developer Default"
3. Configure senha para root
4. Marque "Add MySQL to PATH"
5. Complete a instalação

#### 2.3 Verificar Instalação
```bash
# Abrir novo CMD:
mysql --version
mysql -u root -p
```

### **Opção 3: Chocolatey (Pacote Manager)**

#### 3.1 Instalar Chocolatey
```powershell
# Abrir PowerShell como administrador:
Set-ExecutionPolicy Bypass -Scope Process -Force
[System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
```

#### 3.2 Instalar MySQL via Chocolatey
```powershell
choco install mysql
```

### **Opção 4: Docker (Avançado)**

#### 4.1 Instalar Docker Desktop
1. Baixe Docker Desktop para Windows
2. Instale e reinicie o computador

#### 4.2 Executar MySQL no Docker
```bash
# Criar container MySQL:
docker run --name reviews-mysql -e MYSQL_ROOT_PASSWORD=password -e MYSQL_DATABASE=reviews_platform -p 3306:3306 -d mysql:8.0

# Verificar se está rodando:
docker ps
```

## 🎯 **Recomendação: XAMPP**

Para desenvolvimento Laravel, recomendo o **XAMPP** porque:
- ✅ Inclui Apache, MySQL, PHP e phpMyAdmin
- ✅ Interface gráfica fácil
- ✅ Configuração automática
- ✅ Ideal para desenvolvimento local

## 📋 **Passo a Passo com XAMPP**

### 1. Instalar XAMPP
```bash
# 1. Baixar de: https://www.apachefriends.org/download.html
# 2. Instalar em C:\xampp
# 3. Iniciar XAMPP Control Panel
# 4. Clicar "Start" em MySQL e Apache
```

### 2. Configurar Banco de Dados
```bash
# Acessar phpMyAdmin:
# http://localhost/phpmyadmin

# Ou via linha de comando (se PATH configurado):
mysql -u root -p
# Senha padrão: (vazio) ou "root"
```

### 3. Criar Banco de Dados
```sql
-- No phpMyAdmin ou MySQL CLI:
CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Configurar .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Testar Conexão
```bash
# Se PATH configurado:
mysql -u root -p reviews_platform

# Ou usar o script de teste:
php test_mysql_connection.php
```

## 🔧 **Configuração Manual do PATH**

Se escolher instalar MySQL separadamente:

### Windows 10/11:
1. **Win + R** → `sysdm.cpl`
2. **Avançado** → **Variáveis de Ambiente**
3. **PATH** → **Editar**
4. **Novo** → Adicionar: `C:\Program Files\MySQL\MySQL Server 8.0\bin`
5. **OK** em todas as janelas
6. **Reiniciar CMD**

### Verificar PATH:
```cmd
echo %PATH%
```

## 🧪 **Script de Teste para Windows**

Crie o arquivo `test_windows_mysql.php`:

```php
<?php
echo "🪟 Testando MySQL no Windows...\n\n";

// Verificar se MySQL está no PATH
$mysqlPath = shell_exec('where mysql 2>nul');
if ($mysqlPath) {
    echo "✅ MySQL encontrado no PATH:\n";
    echo trim($mysqlPath) . "\n\n";
} else {
    echo "❌ MySQL não encontrado no PATH\n";
    echo "💡 Verifique se está instalado e no PATH\n\n";
}

// Verificar extensões PHP
echo "🔍 Verificando extensões PHP:\n";
if (extension_loaded('pdo')) {
    echo "✅ PDO: OK\n";
} else {
    echo "❌ PDO: Não encontrado\n";
}

if (extension_loaded('pdo_mysql')) {
    echo "✅ PDO MySQL: OK\n";
} else {
    echo "❌ PDO MySQL: Não encontrado\n";
}

// Testar conexão
echo "\n🔌 Testando conexão...\n";
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    echo "✅ Conexão bem-sucedida!\n";
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
    echo "💡 Verifique se MySQL está rodando\n";
}

echo "\n📝 Próximos passos:\n";
echo "1. Instalar XAMPP ou MySQL\n";
echo "2. Configurar PATH (se necessário)\n";
echo "3. Criar banco de dados\n";
echo "4. Configurar .env\n";
echo "5. php artisan migrate\n";
?>
```

## 🚨 **Soluções para Problemas Comuns**

### Problema: "MySQL não inicia no XAMPP"
```bash
# Soluções:
# 1. Verificar se porta 3306 está livre:
netstat -an | findstr :3306

# 2. Parar outros serviços MySQL:
net stop mysql

# 3. Verificar logs em:
# C:\xampp\mysql\data\*.err
```

### Problema: "Acesso negado"
```bash
# Resetar senha do root no XAMPP:
# 1. Parar MySQL no XAMPP
# 2. Abrir CMD como administrador
# 3. Executar:
C:\xampp\mysql\bin\mysqld --skip-grant-tables --console

# 4. Em outro CMD:
C:\xampp\mysql\bin\mysql -u root
UPDATE mysql.user SET authentication_string=PASSWORD('') WHERE User='root';
FLUSH PRIVILEGES;
EXIT;
```

### Problema: "Porta 3306 em uso"
```bash
# Verificar o que está usando a porta:
netstat -ano | findstr :3306

# Parar processo (substitua PID):
taskkill /PID 1234 /F
```

## 📊 **Verificação Final**

Após instalação, execute:

```cmd
# 1. Verificar MySQL
mysql --version

# 2. Conectar
mysql -u root -p

# 3. Criar banco
CREATE DATABASE reviews_platform;

# 4. Testar no Laravel
php artisan migrate:status
```

## 🎯 **Recomendação Final**

Para seu caso, recomendo:

1. **Instalar XAMPP** (mais fácil)
2. **Iniciar MySQL e Apache**
3. **Acessar phpMyAdmin** para criar o banco
4. **Configurar .env** com as credenciais
5. **Executar migrations**

---

**Qual opção você prefere?** Posso te guiar passo a passo na instalação! 🚀





