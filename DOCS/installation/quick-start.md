# 🚀 Quick Start - Reviews Platform

Comece a usar o Reviews Platform em **5 minutos**!

---

## ⚡ Pré-requisitos

Antes de começar, certifique-se de ter:

- ✅ PHP 8.1 ou superior
- ✅ Composer instalado
- ✅ MySQL 8.0 ou superior
- ✅ Node.js e npm (opcional, para assets)

---

## 📦 Instalação Rápida

### 1. Clone o Repositório

```bash
cd Projeto-reviewWEB/reviews-platform
```

### 2. Instale as Dependências

```bash
composer install
```

### 3. Configure o Ambiente

```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 4. Configure o Banco de Dados

Edite o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

### 5. Crie o Banco de Dados

```bash
# Execute as migrations
php artisan migrate

# Popule com dados de teste (OPCIONAL)
php artisan db:seed
```

### 6. Configure o Storage

```bash
php artisan storage:link
```

### 7. Inicie o Servidor

```bash
php artisan serve
```

Acesse: **http://localhost:8000**

---

## 🔐 Login Inicial

Após executar o seeder, use:

- **Email:** `admin@reviewsplatform.com`
- **Senha:** `password123`

> ⚠️ **IMPORTANTE:** Altere a senha após o primeiro login!

---

## ✅ Primeiros Passos

### 1. Criar Sua Primeira Empresa

1. Acesse o **Dashboard**
2. Clique em **"Empresas"** no menu lateral
3. Clique em **"Criar Nova Empresa"**
4. Preencha:
   - Nome da empresa
   - Email para notificações
   - Upload do logo
   - Upload da imagem de fundo
   - URL customizada (ex: `minha-empresa`)
   - Nota positiva (3, 4 ou 5 estrelas)
   - URL do Google Maps
5. Clique em **"Salvar"**

### 2. Compartilhar Link Público

Sua página pública estará em:
```
http://localhost:8000/review/minha-empresa
```

Compartilhe este link com seus clientes!

### 3. Receber Avaliações

Quando um cliente acessar o link:
- Informa o WhatsApp
- Dá nota de 1 a 5 estrelas
- **Positiva:** Redireciona para Google Maps
- **Negativa:** Coleta feedback privado

### 4. Monitorar no Dashboard

- Veja estatísticas em tempo real
- Liste todas as avaliações
- Filtre por empresa, data ou tipo
- Exporte contatos (CSV)

---

## 🌍 Trocar Idioma

O sistema suporta Português (PT-BR) e Inglês (EN-US):

1. No dashboard, use o seletor de idioma
2. Nas páginas públicas, clique nas bandeiras

---

## 🌙 Ativar Dark Mode

1. No dashboard, clique no ícone de lua
2. A preferência é salva automaticamente

---

## 📧 Configurar Email (Opcional)

Para receber notificações por email, edite o `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@reviewsplatform.com
MAIL_FROM_NAME="Reviews Platform"
```

> 📖 Guia completo: [Email Setup](email-setup.md)

---

## 🆘 Problemas?

### Erro de Conexão com Banco
```bash
# Verifique se o MySQL está rodando
mysql -u root -p

# Crie o banco manualmente
CREATE DATABASE reviews_platform;
```

### Erro de Permissão de Storage
```bash
# No Windows
icacls storage /grant "Everyone:(OI)(CI)F" /T

# No Linux/Mac
chmod -R 775 storage bootstrap/cache
```

### Página em Branco
```bash
# Limpe o cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

> 📖 Mais soluções: [Troubleshooting](../troubleshooting/README.md)

---

## 📚 Próximos Passos

Agora que você tem o sistema funcionando:

- 📖 [Guia de Instalação Completo](installation-guide.md)
- 🎨 [Funcionalidades do Sistema](../features/README.md)
- 🔧 [Guia de Desenvolvimento](../development/development-guide.md)
- 📋 [Briefing do Projeto](../project/briefing.md)

---

## 🎉 Pronto!

Seu Reviews Platform está funcionando!

Agora você pode:
- ✅ Criar empresas
- ✅ Coletar avaliações
- ✅ Gerenciar feedback
- ✅ Exportar contatos

---

**Precisa de ajuda?** Consulte a [documentação completa](../README.md)

