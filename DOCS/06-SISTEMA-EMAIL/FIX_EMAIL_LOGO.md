# 🔧 Fix: Logo não aparece nos Emails

## Problema

A logo da empresa não está aparecendo nos emails enviados pela aplicação.

## Causa

As imagens em emails precisam de **URLs absolutas completas** (com domínio). O sistema estava gerando URLs relativas que não funcionam em emails HTML.

## ✅ Solução Aplicada

### 1. Model Company Atualizado

Adicionado novo accessor `getFullLogoUrlAttribute()` que retorna URL absoluta:

```php
public function getFullLogoUrlAttribute()
{
    if (!$this->logo) {
        return null;
    }
    
    $appUrl = rtrim(config('app.url'), '/');
    return $appUrl . '/storage/' . $this->logo;
}
```

### 2. Templates de Email Atualizados

Ambos os templates de email foram atualizados para usar `full_logo_url`:

- `resources/views/emails/negative-review-alert.blade.php`
- `resources/views/emails/new-review.blade.php`

**Mudança:**
```blade
<!-- ANTES -->
<img src="{{ $company->logo_url }}" ...>

<!-- DEPOIS -->
<img src="{{ $company->full_logo_url }}" ...>
```

## 🚀 Verificar Configuração

### 1. Verificar APP_URL

**Arquivo:** `reviews-platform/.env`

Certifique-se que tem:

```env
APP_URL=http://localhost:8000
```

**Importante:** 
- Use a URL real do seu servidor em produção
- Deve ser acessível publicamente
- Exemplo: `APP_URL=https://seu-dominio.com`

### 2. Verificar Link Simbólico

O link simbólico já foi criado:

```bash
php artisan storage:link
```

Isso cria: `public/storage` → `storage/app/public`

### 3. Verificar Permissões

Certifique-se que as imagens são acessíveis:

```bash
chmod -R 755 storage/app/public
chmod -R 755 public/storage
```

## 🧪 Como Testar

### 1. Verificar URL da Logo

Execute no tinker:

```bash
php artisan tinker

# Dentro do tinker:
$company = App\Models\Company::first();
$company->full_logo_url;
```

O resultado deve ser algo como:
```
http://localhost:8000/storage/logos/logo.png
```

### 2. Testar em Navegador

Copie a URL gerada e cole no navegador. A imagem deve carregar.

### 3. Testar Email

Envie um email de teste e verifique se a logo aparece.

## 🔍 Troubleshooting

### Logo ainda não aparece?

1. **Verificar se imagem existe:**
   ```bash
   ls storage/app/public/logos/
   ```

2. **Verificar se link simbólico existe:**
   ```bash
   ls -la public/storage
   ```

3. **Verificar APP_URL:**
   ```bash
   grep APP_URL .env
   ```

4. **Regenerar link simbólico:**
   ```bash
   php artisan storage:link --force
   ```

### URL está incorreta?

1. Limpe o cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. Verifique o .env tem APP_URL correto

3. Reinicie o servidor

### Imagem carrega no navegador mas não no email?

- Alguns clientes de email bloqueiam imagens externas
- A logo pode estar em modo "download automático" bloqueado
- Teste em diferentes clientes (Gmail, Outlook, etc.)

## 📝 Para Produção

Ao fazer deploy:

1. **Configure APP_URL** com domínio real:
   ```env
   APP_URL=https://seu-dominio.com
   ```

2. **Certifique-se** que storage é público:
   ```bash
   php artisan storage:link
   ```

3. **Configure permissões** corretas no servidor

4. **Teste** envio de email e verifique logo

## ✅ Checklist

- [ ] `.env` tem `APP_URL` configurado
- [ ] Link simbólico está criado (`public/storage`)
- [ ] Imagens existem em `storage/app/public`
- [ ] Permissões estão corretas (755)
- [ ] Cache foi limpo
- [ ] Logo carrega no navegador
- [ ] Logo aparece em emails de teste

## 🔧 Comandos Rápidos

```bash
# Verificar configuração
php artisan tinker
$company = App\Models\Company::first();
$company->full_logo_url;

# Limpar cache
php artisan config:clear
php artisan cache:clear

# Criar link simbólico
php artisan storage:link

# Verificar imagens
ls storage/app/public/
```

---

**Implementado em:** Dezembro 2024  
**Status:** ✅ Corrigido

