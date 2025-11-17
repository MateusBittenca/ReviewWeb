# ⚡ QUICK START - Configurar Email em 5 Minutos

## 🎯 Método Mais Rápido: Gmail

### **Passo 1: Obter Senha de App (2 minutos)**

1. Acesse: https://myaccount.google.com/security
2. Ative "Verificação em duas etapas" (se não tiver)
3. Acesse: https://myaccount.google.com/apppasswords
4. Selecione:
   - App: "Mail"
   - Device: "Other" → Digite: "Laravel"
5. Clique em **Gerar**
6. **Copie a senha de 16 caracteres** (ex: `abcd efgh ijkl mnop`)

### **Passo 2: Configurar .env (1 minuto)**

Edite `reviews-platform/.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=SEU_EMAIL@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=SEU_EMAIL@gmail.com
MAIL_FROM_NAME="Reviews Platform"
```

**Exemplo real:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=joao@gmail.com
MAIL_PASSWORD=xqwt pkrb lhjf hgzx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=joao@gmail.com
MAIL_FROM_NAME="Reviews Platform"
```

### **Passo 3: Limpar Cache (10 segundos)**

```bash
cd reviews-platform
php artisan config:clear
```

### **Passo 4: Testar (2 minutos)**

**Opção A - Script Automático:**
```bash
php test_email.php
```

**Opção B - Tinker:**
```bash
php artisan tinker
```

Depois no Tinker:
```php
use App\Models\Company;
use App\Models\Review;
use App\Mail\NewReviewNotification;
use Illuminate\Support\Facades\Mail;

$company = Company::first();
$review = Review::first();
Mail::to('seu_email@teste.com')->send(new NewReviewNotification($company, $review));
```

### **Passo 5: Verificar (1 minuto)**

- Abra seu email de teste
- Verifique se recebeu o email
- Se sim: ✅ **SUCESSO!**
- Se não: Consulte "Problemas Comuns" abaixo

---

## ❓ Problemas Comuns

### "Connection refused"
**Solução:** Remova espaços da senha no .env  
**Exemplo:** `abcd efgh ijkl mnop` → `abcdefghijklmnop`

### "Authentication failed"
**Solução:** Certifique-se que:
- Email está correto
- Senha de app (não a senha normal!)
- Verificação em duas etapas ativa

### "SMTP connect() failed"
**Solução:** Verifique se:
- MAIL_HOST está correto: `smtp.gmail.com`
- MAIL_PORT está correto: `587`
- MAIL_ENCRYPTION está correto: `tls`

---

## 🎉 Pronto!

Agora todas as avaliações enviarão emails automaticamente:
- ✅ Positivas → Email para proprietário
- ✅ Negativas → Email urgente com alerta

---

## 📧 Onde os Emails São Enviados?

Os emails vão para o email configurado em cada empresa:
- Campo: `negative_email` na tabela `companies`
- Email de exemplo: `proprietario@empresa.com`

Para visualizar: http://localhost:8000/companies

---

## 🔒 Segurança

⚠️ **NUNCA** commite o arquivo `.env` no Git!

O arquivo já está protegido no `.gitignore`.

---

**Tempo Total:** ~5 minutos  
**Dificuldade:** ⭐ Fácil  
**Documentação Completa:** `CONFIGURAR_EMAIL_SMTP.md`
