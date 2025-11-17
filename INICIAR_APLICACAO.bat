@echo off
chcp 65001 >nul 2>&1
setlocal enabledelayedexpansion

echo.
echo ========================================
echo    INICIAR APLICACAO - Reviews Platform
echo ========================================
echo.

cd /d "%~dp0reviews-platform"

echo [1/7] Verificando estrutura do projeto...

if not exist "app" (
    echo [ERRO] Projeto nao encontrado!
    echo Diretorio atual: %cd%
    pause
    exit /b 1
)

if not exist ".env" (
    echo [ERRO] Arquivo .env nao encontrado!
    pause
    exit /b 1
)

echo [OK] Projeto encontrado!

echo.
echo [2/7] Verificando dependencias...

if not exist "vendor\autoload.php" (
    echo [AVISO] Instalando dependencias do Composer...
    composer install --no-interaction --ignore-platform-reqs
    if errorlevel 1 (
        echo [ERRO] Falha ao instalar dependencias!
        pause
        exit /b 1
    )
)

echo [OK] Dependencias verificadas!

echo.
echo [3/7] Verificando chave da aplicacao...

php check_app_key.php >nul 2>&1
if errorlevel 1 (
    echo [AVISO] Gerando chave da aplicacao...
    php artisan key:generate >nul 2>&1
)

echo [OK] Chave da aplicacao verificada!

echo.
echo [4/7] Verificando conexao com MySQL...

php test_mysql_connection.php >nul 2>&1
if errorlevel 1 (
    echo [ERRO] Falha na conexao com MySQL!
    echo Verifique se o XAMPP esta rodando e o MySQL esta ativo.
    pause
    exit /b 1
)

echo [OK] Conexao com MySQL OK!

echo.
echo [5/7] Configurando banco de dados...

REM Criar banco se nao existir
php setup_database.php >nul 2>&1

REM Executar migrations
php artisan migrate --force >nul 2>&1
if errorlevel 1 (
    echo [AVISO] Verificando migrations...
    php artisan migrate --force
) else (
    echo [OK] Migrations executadas!
)

REM Criar usuario admin se nao existir
php artisan db:seed --class=AdminUserSeeder >nul 2>&1

echo [OK] Banco de dados configurado!

echo.
echo [6/7] Configurando storage...

if not exist "public\storage" (
    php artisan storage:link >nul 2>&1
)

php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan view:clear >nul 2>&1

echo [OK] Storage configurado!

echo.
echo [7/7] Iniciando servidor Laravel...
start "Laravel Backend - Reviews Platform" cmd /k "cd /d %cd% && echo ========================================= && echo    REVIEWS PLATFORM - LARAVEL && echo ========================================= && echo. && echo Servidor iniciando... && echo. && php artisan serve && echo. && echo Acesse: http://localhost:8000 && pause"

timeout /t 2 /nobreak >nul

echo.
echo =========================================
echo    APLICACAO INICIADA COM SUCESSO!
echo =========================================
echo.
echo Acesse a aplicacao em:
echo.
echo   http://localhost:8000
echo.
echo Credenciais de acesso:
echo   Email: admin@reviewsplatform.com
echo   Senha: admin123
echo.
echo Para parar o servidor:
echo   - Feche a janela que abriu
echo   - Ou pressione Ctrl+C na janela
echo.
echo Esta janela pode ser fechada agora.
echo.
pause
