@echo off
chcp 65001 >nul 2>&1
setlocal enabledelayedexpansion

echo.
echo ╔════════════════════════════════════════════════════════╗
echo ║   INICIAR APLICAÇÃO E NGROK - Reviews Platform         ║
echo ╚════════════════════════════════════════════════════════╝
echo.

cd /d "%~dp0reviews-platform"

echo [1/5] Verificando estrutura do projeto...
if not exist "app" (
    echo [ERRO] Projeto nao encontrado!
    echo Diretorio atual: %cd%
    pause
    exit /b 1
)

if not exist ".env" (
    echo [ERRO] Arquivo .env nao encontrado!
    echo Copiando .env.example para .env...
    copy .env.example .env
    if errorlevel 1 (
        echo [ERRO] Nao foi possivel criar o arquivo .env!
        pause
        exit /b 1
    )
    echo [AVISO] Arquivo .env criado. Configure as credenciais do banco de dados!
    pause
)

echo [OK] Projeto encontrado!
echo.

echo [2/5] Verificando dependencias...
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

echo [3/5] Verificando link do storage...
if not exist "public\storage" (
    echo [AVISO] Criando link simbolico do storage...
    php artisan storage:link
)
echo [OK] Storage configurado!
echo.

echo [4/5] Verificando se MySQL esta rodando...
netstat -ano | findstr :3306 >nul 2>&1
if errorlevel 1 (
    echo [AVISO] MySQL nao parece estar rodando na porta 3306!
    echo [AVISO] Certifique-se de que o MySQL esta rodando antes de continuar.
    echo.
    timeout /t 3 /nobreak >nul
)
echo [OK] Verificacao concluida!
echo.

echo [5/5] Iniciando servidor Laravel...
echo.
echo ╔════════════════════════════════════════════════════════╗
echo ║   SERVIDOR LARAVEL INICIANDO...                        ║
echo ╚════════════════════════════════════════════════════════╝
echo.
echo Servidor iniciando na porta 8000...
echo.
echo IMPORTANTE: Mantenha esta janela aberta!
echo.
start "Laravel Backend - Reviews Platform" cmd /k "cd /d %cd% && echo ╔════════════════════════════════════════════════════════╗ && echo ║   REVIEWS PLATFORM - LARAVEL SERVER                    ║ && echo ╚════════════════════════════════════════════════════════╝ && echo. && echo Servidor iniciando... && echo. && php artisan serve && echo. && echo Servidor parado. Pressione qualquer tecla para fechar... && pause"

timeout /t 3 /nobreak >nul

echo.
echo ╔════════════════════════════════════════════════════════╗
echo ║   INICIANDO NGROK...                                   ║
echo ╚════════════════════════════════════════════════════════╝
echo.
echo Aguarde alguns segundos para o servidor Laravel iniciar...
timeout /t 5 /nobreak >nul

echo Iniciando ngrok na porta 8000...
echo.
start "Ngrok Tunnel - Reviews Platform" cmd /k "ngrok http 8000 && echo. && echo Ngrok parado. Pressione qualquer tecla para fechar... && pause"

timeout /t 3 /nobreak >nul

echo.
echo ╔════════════════════════════════════════════════════════╗
echo ║   ✅ APLICAÇÃO E NGROK INICIADOS COM SUCESSO!         ║
echo ╚════════════════════════════════════════════════════════╝
echo.
echo 📋 INFORMAÇÕES IMPORTANTES:
echo.
echo 🔹 Servidor Laravel: http://localhost:8000
echo 🔹 Painel Ngrok: http://127.0.0.1:4040
echo.
echo 📝 PRÓXIMOS PASSOS:
echo.
echo 1. Aguarde alguns segundos para o ngrok iniciar completamente
echo 2. Abra o navegador e acesse: http://127.0.0.1:4040
echo 3. Copie a URL pública do ngrok (ex: https://xxxxx.ngrok-free.dev)
echo 4. Compartilhe essa URL com o cliente
echo.
echo ⚠️  IMPORTANTE:
echo    - Mantenha AMBAS as janelas abertas (Laravel e Ngrok)
echo    - A URL do ngrok muda toda vez que você reinicia
echo    - Para parar, feche as janelas ou pressione Ctrl+C
echo.
echo Esta janela pode ser fechada agora.
echo.
pause





