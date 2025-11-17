# 🔧 Guia de Troubleshooting - Plataforma de Reviews

## 🚨 Problemas Mais Comuns

### 1. Script .bat não Funciona

#### Sintomas
- Script abre e fecha rapidamente
- Erro "Diretório não encontrado"
- Janela fecha sem mostrar erro

#### Soluções
```bash
# Opção 1: Executar como Administrador
# Clique direito no arquivo .bat → "Executar como administrador"

# Opção 2: Executar manualmente
cd "C:\Users\[SEU_USUARIO]\Documents\PROJETOS"
.\INICIAR_APLICACAO.bat

# Opção 3: Usar PowerShell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
cd "C:\Users\[SEU_USUARIO]\Documents\PROJETOS"
.\INICIAR_APLICACAO.bat
```

### 2. Erro de Conexão com Banco de Dados

#### Sintomas
```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it
SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'
```

#### Soluções

##### Verificar se MySQL está rodando
```bash
# Windows
net start mysql
# ou
services.msc # Procurar por MySQL

# Linux
sudo systemctl start mysql
sudo systemctl status mysql

# macOS
brew services start mysql
```

##### Verificar configurações no .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=sua_senha_correta
```

##### Testar conexão
```bash
# Testar conexão MySQL
mysql -u root -p -h 127.0.0.1

# Testar conexão Laravel
php artisan tinker
>>> DB::connection()->getPdo();
```

### 3. Erro de Permissões (Linux/Mac)

#### Sintomas
```
The stream or file "/path/to/storage/logs/laravel.log" could not be opened
```

#### Soluções
```bash
# Corrigir permissões
sudo chown -R $USER:$USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Ou usar permissões mais amplas (desenvolvimento)
chmod -R 777 storage bootstrap/cache
```

### 4. Porta já em Uso

#### Sintomas
```
Address already in use
Port 8000 is already in use
```

#### Soluções
```bash
# Encontrar processo usando a porta
# Windows
netstat -ano | findstr :8000
taskkill /PID [PID_NUMBER] /F

# Linux/Mac
lsof -ti:8000 | xargs kill -9

# Usar porta diferente
php artisan serve --port=8001
npm run dev -- --port 5174
```

### 5. Dependências não Instaladas

#### Sintomas
```
Class 'App\Http\Controllers\Controller' not found
Module not found: Can't resolve 'react'
```

#### Soluções

##### PHP/Composer
```bash
# Limpar cache do Composer
composer clear-cache

# Reinstalar dependências
rm -rf vendor
composer install

# Atualizar autoload
composer dump-autoload
```

##### Node.js/npm
```bash
# Limpar cache do npm
npm cache clean --force

# Reinstalar dependências
rm -rf node_modules package-lock.json
npm install

# Ou usar yarn
yarn install
```

### 6. Erro de Chave da Aplicação

#### Sintomas
```
No application encryption key has been specified
```

#### Soluções
```bash
# Gerar nova chave
php artisan key:generate

# Ou definir manualmente no .env
APP_KEY=base64:sua_chave_aqui
```

### 7. Erro de Migração

#### Sintomas
```
Table 'companies' already exists
Migration table not found
```

#### Soluções
```bash
# Resetar migrações (CUIDADO: apaga dados)
php artisan migrate:reset
php artisan migrate

# Ou fazer rollback específico
php artisan migrate:rollback --step=1

# Verificar status das migrações
php artisan migrate:status
```

## 🔍 Diagnósticos Avançados

### 1. Verificar Ambiente Laravel
```bash
php artisan about
php artisan env
php artisan config:show
```

### 2. Verificar Logs
```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log

# Ver últimos erros
tail -n 50 storage/logs/laravel.log
```

### 3. Testar Componentes Individualmente

#### Testar PHP
```bash
php -v
php -m | grep mysql
php -m | grep pdo
```

#### Testar Composer
```bash
composer --version
composer diagnose
```

#### Testar Node.js
```bash
node --version
npm --version
npm list
```

#### Testar MySQL
```bash
mysql --version
mysql -u root -p -e "SHOW DATABASES;"
```

## 🛠️ Comandos de Recuperação

### Reset Completo (CUIDADO: apaga dados)
```bash
# Parar servidores
# Ctrl+C nos terminais

# Limpar tudo
rm -rf vendor node_modules storage/logs/* bootstrap/cache/*
rm .env

# Reinstalar
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
```

### Backup e Restore
```bash
# Backup do banco
mysqldump -u root -p reviews_platform > backup.sql

# Restore do banco
mysql -u root -p reviews_platform < backup.sql
```

## 📞 Quando Pedir Ajuda

### Informações para Incluir
1. **Sistema Operacional:** Windows/Linux/Mac
2. **Versões:** PHP, Composer, Node.js, MySQL
3. **Erro completo:** Mensagem de erro completa
4. **Logs:** Conteúdo de `storage/logs/laravel.log`
5. **Passos:** O que você estava fazendo quando o erro ocorreu

### Comandos de Diagnóstico
```bash
# Informações do sistema
php artisan about
composer diagnose
npm doctor
mysql --version

# Status dos serviços
# Windows
net start | findstr MySQL
# Linux
systemctl status mysql
```

## 🎯 Prevenção de Problemas

### 1. Manter Atualizado
```bash
# Atualizar dependências PHP
composer update

# Atualizar dependências Node.js
npm update

# Atualizar sistema
# Windows: Windows Update
# Linux: sudo apt update && sudo apt upgrade
# Mac: brew update && brew upgrade
```

### 2. Backup Regular
```bash
# Backup do banco (automático)
# Criar script de backup diário

# Backup do código
git add .
git commit -m "Backup automático"
git push
```

### 3. Monitoramento
```bash
# Verificar logs regularmente
tail -f storage/logs/laravel.log

# Verificar espaço em disco
df -h

# Verificar processos
ps aux | grep php
ps aux | grep node
```

---

**💡 Dica:** Sempre mantenha backups e documente suas configurações!
