# 🔧 Solução para Erro "Railpack could not determine how to build the app"

## ❌ Erro que Você Está Vendo

```
⚠ Script start.sh not found
✖ Railpack could not determine how to build the app.
```

## 🔍 Por Que Isso Acontece?

O Railway está analisando a **raiz do repositório**, mas o projeto Laravel está dentro do subdiretório `reviews-platform/`. O Nixpacks (ferramenta de build do Railway) não consegue encontrar o projeto PHP na raiz.

## ✅ Solução (3 Opções)

### **OPÇÃO 1: Configurar Root Directory no Dashboard (RECOMENDADO)**

**Esta é a solução mais simples e recomendada:**

1. No Railway, vá em **Settings** → **Service**
2. Role até a seção **"Root Directory"**
3. Digite exatamente: `reviews-platform`
4. Clique em **Save**
5. Aguarde alguns segundos
6. Vá em **Deployments** e clique em **"Redeploy"**

**Isso deve resolver o problema!**

---

### **OPÇÃO 2: Usar Dockerfile (Alternativa)**

Se a Opção 1 não funcionar, você pode usar um Dockerfile:

1. Crie um arquivo `Dockerfile` na **raiz** do repositório com este conteúdo:

```dockerfile
FROM php:8.2-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip wget

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do subdiretório
COPY reviews-platform/ .

# Instalar dependências
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Expor porta
EXPOSE 8000

# Comando de inicialização
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

2. No Railway, vá em **Settings** → **Service**
3. Em **Build Command**, deixe vazio ou remova
4. Em **Start Command**, deixe vazio (o Dockerfile já tem)
5. Salve e faça deploy

---

### **OPÇÃO 3: Mover Arquivos para Raiz (NÃO RECOMENDADO)**

Esta opção requer mudanças no repositório e não é recomendada, mas pode funcionar se as outras não funcionarem.

---

## 📋 Checklist de Verificação

Após aplicar a solução, verifique:

- [ ] Root Directory configurado como `reviews-platform` (sem barra no final)
- [ ] Deploy iniciado após configurar
- [ ] Logs mostram que está encontrando o `composer.json` em `reviews-platform/`
- [ ] Build está instalando dependências PHP e Node
- [ ] Aplicação está rodando na porta correta

---

## 🆘 Se Ainda Não Funcionar

1. **Verifique os logs completos:**
   - Vá em **Deployments** → Clique no deployment → **View Logs**
   - Procure por erros específicos

2. **Verifique se o repositório está correto:**
   - Confirme que o diretório `reviews-platform/` existe
   - Confirme que há um `composer.json` dentro de `reviews-platform/`

3. **Tente criar um novo serviço:**
   - Às vezes é melhor começar do zero
   - Delete o serviço atual
   - Crie um novo e configure o Root Directory ANTES do primeiro deploy

4. **Contate o suporte do Railway:**
   - https://railway.app/help
   - Explique que está tentando fazer deploy de um Laravel em subdiretório

---

## 📝 Arquivos Criados para Ajudar

Foram criados os seguintes arquivos na raiz do repositório para ajudar o Railway:

- ✅ `railway.json` - Configuração com `rootDirectory: "reviews-platform"`
- ✅ `nixpacks.toml` - Configuração do Nixpacks apontando para subdiretório
- ✅ `composer.json` - Arquivo na raiz para ajudar detecção PHP

**Mas a solução mais confiável ainda é configurar o Root Directory no dashboard do Railway!**

---

**Última atualização:** 2025-01-09

