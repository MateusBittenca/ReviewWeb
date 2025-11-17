# 📧 CONFIGURAÇÃO DE EMAIL - Reviews Platform

## 🔧 Configuração SMTP (Gmail)

Para configurar o sistema de email, edite o arquivo `.env` com as seguintes configurações:

```env
# Configuração de Email - Gmail SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@reviewsplatform.com
MAIL_FROM_NAME="Reviews Platform"
```

## 📋 Passos para Configurar Gmail:

### 1. Criar Senha de App no Gmail:
1. Acesse: https://myaccount.google.com/security
2. Ative a **Verificação em duas etapas**
3. Vá em **Senhas de app**
4. Selecione **Outro (nome personalizado)**
5. Digite: "Reviews Platform"
6. **COPIE** a senha gerada (16 caracteres)

### 2. Configurar o .env:
```env
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=abcd-efgh-ijkl-mnop  # Senha de app gerada
```

### 3. Testar Configuração:
```bash
php artisan tinker
Mail::raw('Teste de email', function ($message) {
    $message->to('seu-email@gmail.com')->subject('Teste');
});
```

## 🚀 Alternativas de Email:

### SendGrid (Recomendado para Produção):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=sua-api-key-sendgrid
MAIL_ENCRYPTION=tls
```

### Mailtrap (Para Desenvolvimento):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu-username-mailtrap
MAIL_PASSWORD=sua-password-mailtrap
MAIL_ENCRYPTION=tls
```

## ✅ Verificar se está Funcionando:

1. **Teste simples:**
```bash
php artisan tinker
Mail::to('teste@email.com')->send(new \App\Mail\NewReviewNotification($company, $review));
```

2. **Verificar logs:**
```bash
tail -f storage/logs/laravel.log
```

3. **Testar no painel:**
   - Crie uma empresa
   - Envie uma avaliação
   - Verifique se o email foi enviado
