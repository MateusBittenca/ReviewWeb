# 📧 Guia Completo - Configurar SMTP para Emails

## 🎯 **OBJETIVO**
Configurar o envio real de emails de notificação para avaliações positivas e negativas.

---

## 📋 **OPÇÕES DE CONFIGURAÇÃO**

### **Opção 1: Gmail SMTP (Gratuito - Recomendado para testes)**

#### **1.1. Obter credenciais do Gmail**

1. Acesse: https://myaccount.google.com/apppasswords
2. Faça login com sua conta Google
3. Vá em "Segurança" → "Senhas de app"
4. Selecione "Mail" e "Outro (Personalizado)"
5. Digite "Laravel Reviews Platform"
6. Clique em "Gerar"
7. Copie a senha de 16 caracteres gerada

#### **1.2. Configurar o .env**

Edite o arquivo `reviews-platform/.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=sua_senha_de_app_de_16_caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email@gmail.com
MAIL_FROM_NAME="Reviews Platform"
```

#### **1.3. Limpar cache**

```bash
cd reviews-platform
php artisan config:clear
```

#### **1.4. Testar envio**

Crie um comando de teste ou use o Tinker:

```bash
php artisan tinker
```

No Tinker:

```php
use App\Mail\NewReviewNotification;
use App\Models\Company;
use App\Models\Review;

$company = Company::first();
$review = Review::first();

Mail::to('seu_email@teste.com')->send(new NewReviewNotification($company, $review));
```

---

### **Opção 2: Mailtrap (Gratuito - Melhor para desenvolvimento)**

Mailtrap é ideal para desenvolvimento porque não envia emails reais.

#### **2.1. Criar conta no Mailtrap**

1. Acesse: https://mailtrap.io
2. Crie uma conta grátis
3. Vá em "Inboxes" → "My Inbox"
4. Copie as credenciais SMTP

#### **2.2. Configurar o .env**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_username
MAIL_PASSWORD=sua_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@reviewsplatform.com
MAIL_FROM_NAME="Reviews Platform"
```

#### **2.3. Testar**

Envie um email usando o Tinker e verifique na caixa de entrada do Mailtrap!

---

### **Opção 3: SendGrid (Produção - 100 emails/dia grátis)**

#### **3.1. Criar conta**

1. Acesse: https://sendgrid.com
2. Crie conta
3. Vá em "Settings" → "API Keys"
4. Crie uma API Key com permissões de "Mail Send"

#### **3.2. Instalar pacote**

```bash
composer require sendgrid/sendgrid
```

#### **3.3. Configurar .env**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SUA_API_KEY_DO_SENDGRID
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seudominio.com
MAIL_FROM_NAME="Reviews Platform"
```

---

### **Opção 4: Mailgun (Produção - 5.000 emails/mês grátis)**

#### **4.1. Criar conta**

1. Acesse: https://www.mailgun.com
2. Crie conta
3. Verifique seu domínio
4. Copie as credenciais SMTP

#### **4.2. Instalar pacote**

```bash
composer require symfony/mailgun-mailer symfony/http-client
```

#### **4.3. Configurar .env**

```env
MAIL_MAILER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@SEU_DOMINIO.mailgun.org
MAIL_PASSWORD=SUA_SENHA_DO_MAILGUN
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@seudominio.com
MAIL_FROM_NAME="Reviews Platform"
```

---

## 🧪 **TESTE DE ENVIO**

### **Método 1: Criar comando de teste**

Crie o arquivo `app/Console/Commands/TestEmail.php`:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReviewNotification;
use App\Models\Company;
use App\Models\Review;

class TestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Test email sending';

    public function handle()
    {
        $this->info('Testing email...');
        
        $company = Company::first();
        $review = Review::first();
        
        if (!$company || !$review) {
            $this->error('No company or review found! Create them first.');
            return;
        }
        
        try {
            Mail::to('seu_email@teste.com')->send(new NewReviewNotification($company, $review));
            $this->info('Email sent successfully!');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
```

Execute:

```bash
php artisan email:test
```

---

### **Método 2: Teste via Tinker**

```bash
php artisan tinker
```

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReviewNotification;
use App\Models\Company;
use App\Models\Review;

$company = Company::first();
$review = Review::first();

Mail::to('seu_email@teste.com')->send(new NewReviewNotification($company, $review));
```

---

## ⚠️ **SOLUÇÕES DE PROBLEMAS COMUNS**

### **Erro: "Connection refused"**
**Causa:** Firewall ou porta bloqueada  
**Solução:** Verifique se as portas 587 (TLS) ou 465 (SSL) estão abertas

### **Erro: "Authentication failed"**
**Causa:** Credenciais incorretas  
**Solução:** Verifique username e password no `.env`

### **Erro: "SMTP connect() failed"**
**Causa:** Configuração incorreta  
**Solução:** Verifique HOST, PORT e ENCRYPTION

### **Gmail bloqueando acesso**
**Solução:** Use "Senhas de app" ao invés de senha normal

---

## 🔒 **SEGURANÇA**

### **Nunca commite credenciais no Git!**

Certifique-se que o `.env` está no `.gitignore`:

```gitignore
.env
.env.backup
```

Sempre use variáveis de ambiente para senhas.

---

## 📝 **CHECKLIST DE CONFIGURAÇÃO**

- [ ] Escolher provedor SMTP (Gmail/Mailtrap/SendGrid)
- [ ] Configurar credenciais no `.env`
- [ ] Limpar cache: `php artisan config:clear`
- [ ] Testar envio de email
- [ ] Verificar recebimento
- [ ] Configurar MAIL_FROM_ADDRESS e MAIL_FROM_NAME
- [ ] Testar com avaliação real

---

## 🚀 **RECOMENDAÇÕES**

### **Para Desenvolvimento:**
- Use **Mailtrap** - não envia emails reais
- Ideal para testes sem bombardear caixas de email

### **Para Testes:**
- Use **Gmail** - fácil de configurar
- Realiza envios reais para validar

### **Para Produção:**
- Use **SendGrid** ou **Mailgun**
- Melhor entregabilidade
- Estatísticas e logs
- Suporte profissional

---

## 📧 **CONFIGURAÇÃO FINAL DO PROJETO**

Após configurar, certifique-se que os emails estão sendo disparados nos seguintes momentos:

1. ✅ **Avaliação Positiva** → Email: `NewReviewNotification`
2. ✅ **Avaliação Negativa** → Email: `NegativeReviewAlert`

O código já está implementado em:
- `app/Http/Controllers/ReviewController.php` - método `sendEmailNotification()`

---

**Tempo Estimado de Implementação:** 20-30 minutos
