@echo off
chcp 65001 >nul 2>&1
echo.
echo ========================================
echo    CONFIGURAR EMAIL SMTP - Gmail
echo ========================================
echo.

cd /d "%~dp0"

echo [1/3] Verificando arquivo .env...
if not exist ".env" (
    echo [ERRO] Arquivo .env nao encontrado!
    pause
    exit /b 1
)
echo [OK] Arquivo .env encontrado!
echo.

echo [2/3] Configurando SMTP...
echo.
echo IMPORTANTE: Para usar Gmail, voce precisa criar uma SENHA DE APP
echo.
echo Passos:
echo   1. Acesse: https://myaccount.google.com/apppasswords
echo   2. Faca login com sua conta Google
echo   3. Ative a Verificacao em duas etapas (se nao tiver)
echo   4. Vá em "Senhas de app"
echo   5. Selecione "Mail" e "Outro (Personalizado)"
echo   6. Digite: "Reviews Platform"
echo   7. Clique em "Gerar"
echo   8. COPIE a senha de 16 caracteres gerada
echo.
echo ========================================
echo.

set /p EMAIL="Digite seu email Gmail: "
set /p PASSWORD="Digite a senha de app (16 caracteres, sem espacos): "

if "%EMAIL%"=="" (
    echo [ERRO] Email nao pode estar vazio!
    pause
    exit /b 1
)

if "%PASSWORD%"=="" (
    echo [ERRO] Senha nao pode estar vazia!
    pause
    exit /b 1
)

echo.
echo [3/3] Atualizando arquivo .env...

powershell -Command "$content = Get-Content .env -Raw; $content = $content -replace 'MAIL_MAILER=log', 'MAIL_MAILER=smtp'; $content = $content -replace 'MAIL_USERNAME=.*', 'MAIL_USERNAME=%EMAIL%'; $content = $content -replace 'MAIL_PASSWORD=.*', 'MAIL_PASSWORD=%PASSWORD%'; $content = $content -replace 'MAIL_FROM_ADDRESS=.*', 'MAIL_FROM_ADDRESS=\"%EMAIL%\"'; $content | Set-Content .env -NoNewline"

if errorlevel 1 (
    echo [ERRO] Falha ao atualizar .env!
    pause
    exit /b 1
)

echo [OK] Arquivo .env atualizado!
echo.

echo Limpando cache...
php artisan config:clear >nul 2>&1
echo [OK] Cache limpo!
echo.

echo ========================================
echo    CONFIGURACAO CONCLUIDA!
echo ========================================
echo.
echo Configuracoes aplicadas:
echo   MAIL_MAILER=smtp
echo   MAIL_HOST=smtp.gmail.com
echo   MAIL_PORT=587
echo   MAIL_USERNAME=%EMAIL%
echo   MAIL_PASSWORD=*** (oculto)
echo   MAIL_ENCRYPTION=tls
echo   MAIL_FROM_ADDRESS=%EMAIL%
echo.
echo Para testar, execute:
echo   php test_password_reset_email.php
echo.
pause

