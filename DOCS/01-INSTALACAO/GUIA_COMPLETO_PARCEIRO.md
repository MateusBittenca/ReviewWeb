# 🚀 Guia Completo para Parceiro - Plataforma de Reviews

## 📋 Visão Geral

Este guia foi criado especificamente para que você consiga rodar a aplicação **exatamente** no mesmo estado que está funcionando no ambiente atual. A aplicação é uma plataforma completa de gerenciamento de reviews com:

- **Backend**: Laravel 9 + PHP 8.0+
- **Frontend**: React 19 + Vite + Tailwind CSS  
- **Banco**: MySQL 8.0+ com phpMyAdmin
- **Funcionalidades**: Sistema completo de reviews, dashboard admin, notificações por email

---

## 🎯 Pré-requisitos Obrigatórios

### 1. Software Necessário
- **PHP 8.0+** - [Download](https://www.php.net/downloads.php)
- **Composer** - [Download](https://getcomposer.org/download/)
- **Node.js 18+** - [Download](https://nodejs.org/)
- **MySQL 8.0+** - Recomendo XAMPP para facilitar
- **Git** - [Download](https://git-scm.com/downloads)

### 2. Verificar Instalações
```bash
# Abrir CMD/PowerShell e verificar:
php --version          # Deve mostrar PHP 8.0+
composer --version     # Deve mostrar Composer
node --version         # Deve mostrar Node 18+
npm --version          # Deve mostrar NPM
mysql --version        # Deve mostrar MySQL 8.0+
```

---

## 🛠️ Instalação Passo a Passo

### **ETAPA 1: Preparar o Ambiente**

#### 1.1 Instalar XAMPP (Recomendado)
1. **Baixar**: https://www.apachefriends.org/download.html
2. **Instalar** como administrador em `C:\xampp`
3. **Marcar**: Apache, MySQL, PHP, phpMyAdmin
4. **Iniciar** XAMPP Control Panel
5. **Clicar "Start"** em Apache e MySQL
6. **Aguardar** ficarem verdes

#### 1.2 Verificar XAMPP
- **Apache**: http://localhost → Deve mostrar página do XAMPP
- **phpMyAdmin**: http://localhost/phpmyadmin → Deve mostrar login
- **Login phpMyAdmin**: usuário `root`, senha vazia

### **ETAPA 2: Configurar o Projeto**

#### 2.1 Baixar/Copiar o Projeto
```bash
# Opção A: Se você tem acesso ao repositório Git
git clone [URL_DO_REPOSITORIO] C:\Users\[SEU_USUARIO]\Documents\PROJETOS

# Opção B: Se você recebeu o projeto por arquivo
# Copie toda a pasta do projeto para: C:\Users\[SEU_USUARIO]\Documents\PROJETOS
```

#### 2.2 Navegar para o Projeto
```bash
cd C:\Users\[SEU_USUARIO]\Documents\PROJETOS\reviews-platform
```

#### 2.3 Instalar Dependências PHP
```bash
composer install
```

#### 2.4 Instalar Dependências Node.js
```bash
cd frontend
npm install
cd ..
```

### **ETAPA 3: Configurar Banco de Dados**

#### 3.1 Criar Banco de Dados
**Via phpMyAdmin:**
1. Acesse: http://localhost/phpmyadmin
2. Clique em "Novo" no menu lateral
3. Nome: `reviews_platform`
4. Collation: `utf8mb4_unicode_ci`
5. Clique "Criar"

**Via Linha de Comando:**
```bash
mysql -u root -p
CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

#### 3.2 Configurar Arquivo .env
```bash
# Copiar arquivo de exemplo
cp .env.example .env

# Se não existir .env.example, criar manualmente:
```

**Conteúdo do arquivo `.env`:**
```env
APP_NAME="Reviews Platform"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

#### 3.3 Gerar Chave da Aplicação
```bash
php artisan key:generate
```

#### 3.4 Executar Migrations e Seeders
```bash
# Executar migrations
php artisan migrate

# Criar usuário admin
php artisan db:seed --class=AdminUserSeeder

# Escolher uma das opções abaixo para dados:
```

**Opções de Dados Disponíveis:**

**Opção A: Dados Básicos (Recomendado para início)**
```bash
php artisan db:seed --class=DemoDataSeeder
# Cria: 1 admin + 3 empresas + avaliações de exemplo
```

**Opção B: Dados Completos (Para teste completo)**
```bash
php artisan db:seed --class=CompleteDataSeeder
# Cria: 1 admin + 10 empresas + avaliações realistas
```

**Opção C: Dados Reais (Se você recebeu o arquivo)**
```bash
# 1. Coloque o arquivo RealDataSeeder.php em database/seeders/
# 2. Execute:
php artisan db:seed --class=RealDataSeeder
# Usa os dados exatos do ambiente atual
```

#### 3.5 Criar Link de Storage
```bash
php artisan storage:link
```

### **ETAPA 4: Configurar Frontend**

#### 4.1 Compilar Assets
```bash
cd frontend
npm run build
cd ..
```

### **ETAPA 5: Iniciar Aplicação**

#### 5.1 Opção A: Script Automático (Windows)
```bash
# Na pasta raiz do projeto, execute:
INICIAR_APLICACAO.bat
```

#### 5.2 Opção B: Manual (2 Terminais)
**Terminal 1 - Backend:**
```bash
cd C:\Users\[SEU_USUARIO]\Documents\PROJETOS\reviews-platform
php artisan serve
```

**Terminal 2 - Frontend:**
```bash
cd C:\Users\[SEU_USUARIO]\Documents\PROJETOS\reviews-platform\frontend
npm run dev
```

---

## 🌐 Acessar a Aplicação

### URLs da Aplicação
- **Frontend React**: http://localhost:5173
- **Backend Laravel**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- **phpMyAdmin**: http://localhost/phpmyadmin

### Login Inicial
- **Email**: admin@example.com
- **Senha**: password

---

## 🧪 Testar Funcionalidades

### 1. Login Admin
1. Acesse: http://localhost:8000/login
2. Use as credenciais acima
3. Deve redirecionar para o dashboard

### 2. Criar Primeira Empresa
1. No dashboard, clique "Nova Empresa"
2. Preencha os dados obrigatórios
3. Faça upload de uma logo (opcional)
4. Salve a empresa

### 3. Testar Avaliação Pública
1. Copie a URL pública gerada (ex: `/r/{token}`)
2. Acesse a URL em nova aba
3. Preencha uma avaliação positiva (4-5 estrelas)
4. Deve redirecionar para Google
5. Teste uma avaliação negativa (1-3 estrelas)
6. Deve mostrar formulário de feedback

### 4. Verificar Dashboard
1. Volte ao dashboard admin
2. Verifique se a avaliação apareceu
3. Teste os filtros e exportações

---

## 🐛 Solução de Problemas Comuns

### **Problema: "mysql não é reconhecido"**
**Solução:**
1. Instalar XAMPP (recomendado)
2. Ou adicionar MySQL ao PATH do Windows
3. Verificar se MySQL está rodando

### **Problema: "Erro de conexão com banco"**
**Solução:**
```bash
# Verificar se MySQL está rodando
netstat -an | findstr :3306

# Se não estiver, iniciar XAMPP
# Verificar configurações no .env
```

### **Problema: "Porta já em uso"**
**Solução:**
```bash
# Laravel em porta diferente
php artisan serve --port=8001

# React em porta diferente
npm run dev -- --port 5174
```

### **Problema: "Dependências não instaladas"**
**Solução:**
```bash
# PHP
composer install

# Node.js
cd frontend
npm install
```

### **Problema: "Storage link not found"**
**Solução:**
```bash
php artisan storage:link
```

### **Problema: "E-mails não enviados"**
**Solução:**
1. Configurar SMTP real no `.env`
2. Ou usar Mailtrap para testes
3. Verificar logs: `storage/logs/laravel.log`

---

## 📊 Verificação Final

### Checklist de Funcionamento
- [ ] XAMPP rodando (Apache + MySQL)
- [ ] phpMyAdmin acessível
- [ ] Banco `reviews_platform` criado
- [ ] Arquivo `.env` configurado
- [ ] Dependências instaladas (composer + npm)
- [ ] Migrations executadas
- [ ] Usuário admin criado
- [ ] Storage link criado
- [ ] Backend rodando (porta 8000)
- [ ] Frontend rodando (porta 5173)
- [ ] Login admin funcionando
- [ ] Criação de empresa funcionando
- [ ] Avaliação pública funcionando

### Comandos de Diagnóstico
```bash
# Verificar status geral
php artisan about

# Verificar configuração de banco
php artisan config:show database

# Verificar migrations
php artisan migrate:status

# Limpar cache se necessário
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 🚀 Próximos Passos

Após conseguir rodar a aplicação:

1. **Explorar o Dashboard**: Familiarize-se com todas as funcionalidades
2. **Criar Empresas de Teste**: Teste diferentes cenários
3. **Configurar E-mails**: Configure SMTP real para produção
4. **Personalizar**: Ajuste cores, logos e textos conforme necessário
5. **Testar Fluxo Completo**: Simule cenários reais de uso

---

## 📞 Suporte

### Se Algo Não Funcionar
1. **Verifique os logs**: `storage/logs/laravel.log`
2. **Execute diagnóstico**: `php artisan about`
3. **Consulte troubleshooting**: Seção acima
4. **Verifique XAMPP**: Apache e MySQL devem estar verdes

### Arquivos Importantes
- **Configuração**: `.env`
- **Logs**: `storage/logs/laravel.log`
- **Banco**: phpMyAdmin em http://localhost/phpmyadmin
- **Script de inicialização**: `INICIAR_APLICACAO.bat`

---

## 🎯 Estado Atual da Aplicação

A aplicação está configurada com:

### ✅ Funcionalidades Implementadas
- Sistema completo de CRUD de empresas
- Páginas públicas de avaliação com design responsivo
- Dashboard administrativo com estatísticas
- Sistema de notificações por email
- Upload e redimensionamento de imagens
- Exportação de dados (CSV/Excel)
- Filtros avançados no dashboard
- Sistema de roles (admin/owner)
- Validações completas frontend e backend
- Sistema de filas para emails
- Commands artisan para manutenção

### 🎨 Design e UX
- Interface moderna com Tailwind CSS
- Design responsivo para mobile
- Animações suaves e loading states
- Sistema de estrelas interativo
- Formulários com validação em tempo real
- Mensagens de sucesso/erro amigáveis

### 🔒 Segurança
- Proteção CSRF
- Validação de uploads
- Sanitização de dados
- Rate limiting em rotas públicas
- Middleware de autenticação

---

**🎉 Parabéns! Agora você tem uma plataforma completa de reviews funcionando!**

*Este guia foi criado especificamente para replicar o ambiente atual. Se encontrar algum problema específico, consulte a seção de troubleshooting ou verifique os logs da aplicação.*
