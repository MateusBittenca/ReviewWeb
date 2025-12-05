# ✅ Checklist de Deploy - Railway

> **Use este checklist para garantir que tudo está pronto antes de passar o repositório para o dono do sistema**

## 🔒 Segurança - Verificar ANTES de Compartilhar

- [ ] **Arquivo `.env` NÃO está no repositório** (verificado no `.gitignore`)
- [ ] **Nenhuma senha ou chave secreta está hardcoded no código**
- [ ] **Credenciais de banco de dados não estão expostas**
- [ ] **API keys não estão no código fonte**

## 📁 Arquivos de Configuração

- [x] `railway.json` na raiz com `rootDirectory: "reviews-platform"`
- [x] `reviews-platform/nixpacks.toml` configurado
- [x] `reviews-platform/railway.json` como fallback
- [x] `reviews-platform/composer.json` com PHP 8.2
- [x] `reviews-platform/Dockerfile` atualizado para PHP 8.2

## 📚 Documentação

- [x] `GUIA_DEPLOY_RAILWAY.md` criado com instruções completas
- [x] `DOCS/HOSPEDAGEM_RECOMENDADA.md` atualizado
- [x] README.md com informações básicas

## 🗄️ Banco de Dados

- [x] Migrations prontas e testadas
- [x] Seeders disponíveis (opcional)
- [x] Estrutura do banco documentada

## 🔧 Configurações Necessárias no Railway

### Variáveis de Ambiente Obrigatórias:
- [ ] `APP_NAME` - "Avalie $ Ganhe"
- [ ] `APP_ENV` - "production"
- [ ] `APP_KEY` - Gerar no Railway
- [ ] `APP_DEBUG` - "false"
- [ ] `APP_URL` - URL do Railway ou domínio personalizado

### Variáveis de Banco:
- [ ] `DB_CONNECTION` - "mysql"
- [ ] `DB_HOST` - `${{MySQL.MYSQLHOST}}`
- [ ] `DB_PORT` - `${{MySQL.MYSQLPORT}}`
- [ ] `DB_DATABASE` - `${{MySQL.MYSQLDATABASE}}`
- [ ] `DB_USERNAME` - `${{MySQL.MYSQLUSER}}`
- [ ] `DB_PASSWORD` - `${{MySQL.MYSQLPASSWORD}}`

### Variáveis de Email:
- [ ] `MAIL_MAILER` - "smtp"
- [ ] `MAIL_HOST` - Configurar
- [ ] `MAIL_PORT` - "587"
- [ ] `MAIL_USERNAME` - Configurar
- [ ] `MAIL_PASSWORD` - Configurar (senha de app)
- [ ] `MAIL_ENCRYPTION` - "tls"
- [ ] `MAIL_FROM_ADDRESS` - Configurar
- [ ] `MAIL_FROM_NAME` - "Avalie $ Ganhe"

## 🚀 Passos de Deploy

1. [ ] Criar conta no Railway
2. [ ] Conectar repositório GitHub
3. [ ] **Configurar Root Directory: `reviews-platform`**
4. [ ] Criar banco MySQL
5. [ ] Configurar todas as variáveis de ambiente
6. [ ] Gerar `APP_KEY` via terminal
7. [ ] Executar `php artisan migrate --force`
8. [ ] Verificar se aplicação está acessível
9. [ ] Configurar domínio personalizado (se necessário)
10. [ ] Testar funcionalidades principais

## 📝 Informações para o Dono do Sistema

### O que ele precisa saber:
- ✅ Repositório está pronto para deploy
- ✅ Todas as configurações estão documentadas
- ✅ Guia completo em `GUIA_DEPLOY_RAILWAY.md`
- ✅ Root Directory deve ser configurado como `reviews-platform`
- ✅ Variáveis de ambiente precisam ser configuradas manualmente
- ✅ Domínio personalizado pode ser configurado depois

### O que ele precisa ter:
- Conta GitHub (com acesso ao repositório)
- Conta Railway (pode criar gratuitamente)
- Credenciais de email para SMTP (Gmail recomendado)
- Domínio (opcional, para domínio personalizado)

## ⚠️ Problemas Conhecidos e Soluções

### Erro: "Script start.sh not found"
**Solução:** Configurar Root Directory como `reviews-platform` nas Settings

### Erro: "No version available for php 8.0.2"
**Status:** ✅ Corrigido - Projeto usa PHP 8.2

### Erro: "Railpack could not determine how to build the app"
**Solução:** Verificar se `rootDirectory` está configurado corretamente

---

**Status do Repositório:** ✅ **PRONTO PARA DEPLOY**

**Data de Verificação:** 2025-01-09

