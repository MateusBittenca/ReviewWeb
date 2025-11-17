# 🔧 Troubleshooting - Reviews Platform

Soluções para problemas comuns

---

## 🔍 Índice de Problemas

### Instalação
- [Erro de Conexão com Banco de Dados](#erro-de-conexão-com-banco-de-dados)
- [Erro de Permissão de Storage](#erro-de-permissão-de-storage)
- [Composer Install Falha](#composer-install-falha)

### Autenticação
- [Erro ao Fazer Login](#erro-ao-fazer-login)
- [Sessão Expira Rapidamente](#sessão-expira-rapidamente)

### Email
- [Emails Não Estão Sendo Enviados](#emails-não-estão-sendo-enviados)
- [Logo Não Aparece no Email](#logo-não-aparece-no-email)

### Uploads
- [Erro ao Fazer Upload de Imagem](#erro-ao-fazer-upload-de-imagem)
- [Imagem Não Aparece na Página](#imagem-não-aparece-na-página)

### Performance
- [Dashboard Lento](#dashboard-lento)
- [Página Pública Demorando](#página-pública-demorando)

---

## 🔴 Problemas de Instalação

### Erro de Conexão com Banco de Dados

**Erro:**
```
SQLSTATE[HY000] [2002] Connection refused
```

**Soluções:**

1. **Verificar se o MySQL está rodando:**
```bash
# Windows
net start MySQL80

# Linux/Mac
sudo systemctl start mysql
```

2. **Verificar credenciais no `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # ou localhost
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

3. **Criar o banco manualmente:**
```bash
mysql -u root -p
CREATE DATABASE reviews_platform;
EXIT;
```

4. **Limpar cache de configuração:**
```bash
php artisan config:clear
```

---

### Erro de Permissão de Storage

**Erro:**
```
The stream or file "storage/logs/laravel.log" could not be opened
```

**Soluções:**

1. **Windows:**
```bash
icacls storage /grant "Everyone:(OI)(CI)F" /T
icacls bootstrap\cache /grant "Everyone:(OI)(CI)F" /T
```

2. **Linux/Mac:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

3. **Criar link simbólico:**
```bash
php artisan storage:link
```

---

### Composer Install Falha

**Erro:**
```
Your requirements could not be resolved
```

**Soluções:**

1. **Atualizar Composer:**
```bash
composer self-update
```

2. **Limpar cache:**
```bash
composer clear-cache
```

3. **Tentar instalar novamente:**
```bash
composer install --no-cache
```

4. **Verificar versão do PHP:**
```bash
php -v  # Deve ser 8.1 ou superior
```

---

## 🔐 Problemas de Autenticação

### Erro ao Fazer Login

**Erro:**
```
These credentials do not match our records
```

**Soluções:**

1. **Verificar se o seeder foi executado:**
```bash
php artisan db:seed --class=AdminUserSeeder
```

2. **Credenciais padrão:**
```
Email: admin@reviewsplatform.com
Senha: password123
```

3. **Criar usuário manualmente:**
```bash
php artisan tinker

User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'admin'
]);
```

4. **Limpar cache de sessão:**
```bash
php artisan session:clear
php artisan cache:clear
```

---

### Sessão Expira Rapidamente

**Solução:**

Edite o `.env`:
```env
SESSION_LIFETIME=120  # minutos
SESSION_DRIVER=file
```

Limpe o cache:
```bash
php artisan config:clear
```

---

## 📧 Problemas de Email

### Emails Não Estão Sendo Enviados

**Soluções:**

1. **Verificar configuração SMTP no `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app  # Não a senha normal!
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@reviewsplatform.com
MAIL_FROM_NAME="${APP_NAME}"
```

2. **Para Gmail, criar senha de app:**
   - Acesse: https://myaccount.google.com/apppasswords
   - Crie uma senha de app
   - Use esta senha no `.env`

3. **Testar envio:**
```bash
php artisan tinker

Mail::raw('Teste', function($message) {
    $message->to('seu-email@gmail.com')->subject('Teste');
});
```

4. **Verificar logs:**
```bash
tail -f storage/logs/laravel.log
```

---

### Logo Não Aparece no Email

**Solução:**

O logo precisa ser acessível via URL pública:

1. **Verificar se o storage está linkado:**
```bash
php artisan storage:link
```

2. **No template de email, usar URL absoluta:**
```php
$logoUrl = asset('storage/' . $company->logo_path);
// ou
$logoUrl = url('storage/' . $company->logo_path);
```

3. **Em produção, usar domínio completo:**
```env
APP_URL=https://seudominio.com
```

---

## 📷 Problemas de Upload

### Erro ao Fazer Upload de Imagem

**Erro:**
```
The file exceeds the upload_max_filesize directive
```

**Soluções:**

1. **Aumentar limite no `php.ini`:**
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

2. **Reiniciar servidor:**
```bash
# Se usar Apache
sudo service apache2 restart

# Se usar nginx
sudo service nginx restart
sudo service php8.1-fpm restart
```

3. **Verificar extensões permitidas:**
```php
// Em CompanyController.php
'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
```

---

### Imagem Não Aparece na Página

**Soluções:**

1. **Criar link simbólico:**
```bash
php artisan storage:link
```

2. **Verificar path no banco:**
```sql
SELECT logo_path FROM companies;
-- Deve ser: companies/logos/filename.jpg
```

3. **No blade, usar asset():**
```php
<img src="{{ asset('storage/' . $company->logo_path) }}">
```

4. **Verificar permissões:**
```bash
# Windows
icacls public\storage /grant "Everyone:(OI)(CI)F" /T

# Linux/Mac
chmod -R 755 public/storage
```

---

## ⚡ Problemas de Performance

### Dashboard Lento

**Soluções:**

1. **Habilitar cache:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Otimizar autoload:**
```bash
composer dump-autoload -o
```

3. **Usar eager loading:**
```php
// Em vez de:
$companies = Company::all();

// Use:
$companies = Company::with('reviews')->get();
```

---

### Página Pública Demorando

**Soluções:**

1. **Adicionar cache:**
```php
$company = Cache::remember('company_' . $url, 60, function() use ($url) {
    return Company::where('url', $url)->firstOrFail();
});
```

2. **Otimizar imagens:**
- Redimensionar logos para max 500x500px
- Comprimir imagens antes do upload

---

## 🐛 Comandos Úteis de Debug

### Limpar Todos os Caches
```bash
php artisan optimize:clear
```

### Ver Logs em Tempo Real
```bash
tail -f storage/logs/laravel.log
```

### Verificar Rotas
```bash
php artisan route:list
```

### Testar Conexão com Banco
```bash
php artisan tinker
DB::connection()->getPdo();
```

### Ver Configurações
```bash
php artisan config:show database
```

---

## 📞 Ainda Precisa de Ajuda?

Se o problema persistir:

1. **Verifique os logs:**
   - `storage/logs/laravel.log`
   
2. **Habilite debug:**
   ```env
   APP_DEBUG=true
   ```

3. **Consulte a documentação:**
   - [Laravel Docs](https://laravel.com/docs)
   - [Troubleshooting Completo](../README.md)

---

**Última Atualização:** 26/10/2025

