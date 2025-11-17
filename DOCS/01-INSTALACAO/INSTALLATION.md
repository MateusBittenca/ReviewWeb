# 🚀 Guia de Instalação - Plataforma de Avaliações

## 📋 Pré-requisitos
- PHP 8.2 ou superior
- Composer
- MySQL 8.0+
- Node.js e NPM (para assets)
- Extensões PHP: GD, PDO, Mbstring, OpenSSL, Tokenizer, XML

## 🛠️ Instalação Passo a Passo

### 1. Clonar/Criar Projeto Laravel
```bash
# Criar novo projeto Laravel
composer create-project laravel/laravel reviews-platform

cd reviews-platform
```

### 2. Instalar Dependências
```bash
# Dependências PHP
composer require intervention/image maatwebsite/excel laravel/breeze spatie/laravel-sluggable

# Instalar Breeze (autenticação)
php artisan breeze:install blade
npm install && npm run build
```

### 3. Configurar Ambiente
```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4. Configurar Banco de Dados
Editar `.env`:
```env
APP_NAME="Reviews Platform"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=

# Configuração de E-mail (exemplo com Mailtrap)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_username
MAIL_PASSWORD=sua_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@reviewsplatform.com
MAIL_FROM_NAME="${APP_NAME}"

# Para produção, use um serviço real como:
# - Gmail SMTP
# - SendGrid
# - Mailgun
# - Amazon SES

# Configuração de Fila (opcional, mas recomendado)
QUEUE_CONNECTION=database
# Para produção, use Redis:
# QUEUE_CONNECTION=redis
```

### 5. Criar Banco de Dados
```bash
# Criar database no MySQL
mysql -u root -p
CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 6. Executar Migrations
```bash
# Rodar migrations
php artisan migrate

# Criar link para storage público
php artisan storage:link
```

### 7. Criar Usuário Admin
```bash
# Criar seeder para admin
php artisan make:seeder AdminUserSeeder
```

Editar `database/seeders/AdminUserSeeder.php`:
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@reviewsplatform.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
```

Executar o seeder:
```bash
php artisan db:seed --class=AdminUserSeeder
```

### 8. Configurar Migration de Users
Adicionar campo role na migration de users:
```php
// database/migrations/2014_10_12_000000_create_users_table.php

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->enum('role', ['admin', 'owner'])->default('owner');
    $table->rememberToken();
    $table->timestamps();
});
```

### 9. Configurar Rotas
Adicionar no `bootstrap/app.php` (Laravel 11):
```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

### 10. Configurar Fila (Recomendado)
```bash
# Criar tabela de jobs
php artisan queue:table
php artisan migrate

# Iniciar worker (em outro terminal)
php artisan queue:work
```

Para produção, use Supervisor para gerenciar o worker.

### 11. Iniciar Servidor
```bash
# Desenvolvimento
php artisan serve

# Acesse: http://localhost:8000
```

## 📧 Configuração de E-mail

### Opção 1: Mailtrap (Desenvolvimento)
1. Criar conta em Mailtrap.io
2. Copiar credenciais SMTP
3. Configurar no `.env`

### Opção 2: Gmail (Produção)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
```

**Importante**: Use "Senhas de App" do Gmail, não sua senha normal.

### Opção 3: SendGrid (Produção)
```bash
composer require symfony/sendgrid-mailer
```

```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=seu_api_key_aqui
```

## 🎨 Personalização do Layout

### Configurar Logo e Cores
Editar `resources/views/layouts/app.blade.php`:
```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')
    
    <main>
        {{ $slot }}
    </main>
</body>
</html>
```

## 🔒 Segurança

### 1. Proteção CSRF
Já incluído automaticamente no Laravel. Certifique-se de usar `@csrf` em todos os formulários.

### 2. Validação de Uploads
```php
// config/filesystems.php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### 3. Rate Limiting
Adicionar em `app/Providers/RouteServiceProvider.php`:
```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('reviews', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});
```

Aplicar nas rotas públicas:
```php
Route::middleware('throttle:reviews')->group(function () {
    Route::post('/r/{token}', [ReviewPageController::class, 'store']);
});
```

## 📦 Pacotes Instalados

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "laravel/breeze": "^2.0",
        "intervention/image": "^3.0",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-sluggable": "^3.0"
    }
}
```

## 🧪 Testar o Sistema

### 1. Login Admin
- **URL**: http://localhost:8000/login
- **Email**: admin@reviewsplatform.com
- **Senha**: password123

### 2. Criar Empresa de Teste
1. Acesse: `/admin/companies/create`
2. Preencha os dados
3. Copie a URL pública gerada

### 3. Testar Avaliação
1. Acesse a URL pública (ex: `/r/{token}`)
2. Preencha o formulário
3. Verifique:
   - Se rating ≥ 4: deve redirecionar ao Google
   - Se rating < 4: deve exibir formulário de feedback

### 4. Verificar E-mails
1. Cheque o Mailtrap/Gmail
2. Deve receber notificação da avaliação

## 🚀 Deploy em Produção

### Preparar para Deploy
```bash
# Otimizar autoload
composer install --optimize-autoloader --no-dev

# Cachear configurações
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Executar migrations
php artisan migrate --force
```

### Variáveis de Ambiente (Produção)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com

# Configurar SSL
FORCE_HTTPS=true

# E-mail real
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
# ...

# Queue com Redis
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Supervisor (Queue Worker)
Criar `/etc/supervisor/conf.d/reviews-worker.conf`:
```ini
[program:reviews-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/reviews-platform/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/reviews-platform/storage/logs/worker.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start reviews-worker:*
```

## 📊 Monitoramento

### Logs
```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log

# Limpar logs antigos
php artisan log:clear
```

### Performance
```bash
# Instalar Laravel Telescope (desenvolvimento)
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

## 🔧 Comandos Úteis

```bash
# Limpar caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reprocessar falhas na fila
php artisan queue:retry all

# Ver estatísticas da fila
php artisan queue:monitor

# Backup do banco
mysqldump -u root -p reviews_platform > backup.sql
```

## 📱 Próximos Passos

- ✅ Sistema básico funcionando
- 🔄 Implementar export CSV/Excel
- 📊 Dashboard com gráficos
- 🎨 Melhorar design
- 🏢 Sistema multi-tenant (Fase 2)
- 💳 Integração de pagamentos (Fase 2)
- 📱 App mobile (Fase 3)

## 🐛 Troubleshooting

### Erro: "Class not found"
```bash
composer dump-autoload
```

### Erro: "Storage link not found"
```bash
php artisan storage:link
```

### E-mails não estão sendo enviados
```bash
# Verificar configuração
php artisan config:clear
php artisan queue:restart
```

### Imagens não aparecem
```bash
# Verificar permissões
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 📞 Suporte

Para dúvidas ou problemas:

1. Verificar logs: `storage/logs/laravel.log`
2. Verificar queue: `php artisan queue:failed`
3. Documentação Laravel: https://laravel.com/docs





