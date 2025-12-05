# 🚀 Guia Completo de Deploy no Railway

> **Este guia é para o dono do sistema que irá fazer o deploy e pagar pelo domínio**

## 📋 Pré-requisitos

- Conta no GitHub (com acesso ao repositório)
- Conta no Railway (pode criar gratuitamente em https://railway.app)
- Cartão de crédito para pagar o domínio (opcional, Railway tem plano gratuito)

---

## 🎯 Passo a Passo Completo

### **PASSO 1: Criar Conta no Railway**

1. Acesse: https://railway.app
2. Clique em **"Start a New Project"**
3. Faça login com sua conta **GitHub**
4. Autorize o Railway a acessar seus repositórios

---

### **PASSO 2: Conectar o Repositório**

1. No dashboard do Railway, clique em **"New Project"**
2. Selecione **"Deploy from GitHub repo"**
3. Escolha o repositório: `ReviewWeb` (ou o nome do repositório)
4. O Railway irá detectar automaticamente que é um projeto Laravel

⚠️ **CRÍTICO - CONFIGURAR ROOT DIRECTORY (FAZER ANTES DO PRIMEIRO DEPLOY):**

**Este passo é OBRIGATÓRIO e deve ser feito IMEDIATAMENTE após conectar o repositório:**

1. Vá em **Settings** → **Service**
2. Em **Root Directory**, digite exatamente: `reviews-platform`
3. Clique em **Save**
4. **AGUARDE** alguns segundos para a configuração ser aplicada
5. Agora faça o deploy novamente

**Por quê?** O projeto Laravel está dentro do subdiretório `reviews-platform/`, e o Railway precisa saber onde está o código ANTES de tentar fazer o build.

**Se você não fizer isso, verá o erro:**
```
⚠ Script start.sh not found
✖ Railpack could not determine how to build the app.
```

---

### **PASSO 3: Adicionar Banco de Dados MySQL**

1. No projeto criado, clique em **"New"** (botão verde)
2. Selecione **"Database"** → **"MySQL"**
3. O Railway criará automaticamente um banco MySQL
4. **Anote as credenciais** que aparecem (você vai precisar depois)

As credenciais aparecem automaticamente nas variáveis de ambiente do serviço MySQL.

---

### **PASSO 4: Configurar Variáveis de Ambiente**

1. No serviço da aplicação (não no MySQL), clique em **"Variables"**
2. Clique em **"New Variable"** e adicione cada uma das variáveis abaixo:

#### **Variáveis Obrigatórias:**

```env
APP_NAME="Avalie $ Ganhe"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-app.railway.app
```

#### **Variáveis do Banco de Dados (use as do MySQL criado):**

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

> **Nota:** As variáveis que começam com `${{MySQL.}}` são referências automáticas ao banco criado. O Railway preenche automaticamente.

#### **Variáveis de Email (configure com suas credenciais):**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="Avalie $ Ganhe"
```

> **Nota:** Para Gmail, você precisa usar uma "Senha de App" (não a senha normal). Veja como criar: https://support.google.com/accounts/answer/185833

#### **Variáveis de Sessão e Cache:**

```env
SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

---

### **PASSO 5: Gerar APP_KEY**

1. No serviço da aplicação, clique na aba **"Deployments"**
2. Clique no deployment mais recente
3. Clique em **"View Logs"** ou **"Shell"**
4. Execute o comando:

```bash
php artisan key:generate
```

5. Copie a chave gerada (começa com `base64:`)
6. Volte em **"Variables"** e adicione/atualize:

```env
APP_KEY=base64:CHAVE_GERADA_AQUI
```

---

### **PASSO 6: Executar Migrações do Banco**

1. No mesmo terminal/shell do passo anterior, execute:

```bash
php artisan migrate --force
```

Isso criará todas as tabelas necessárias no banco de dados.

---

### **PASSO 7: Criar Usuário Administrador (Opcional)**

Se quiser criar um usuário admin manualmente:

```bash
php artisan tinker
```

Depois execute:

```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@exemplo.com',
    'password' => Hash::make('senha_segura'),
    'role' => 'owner'
]);
```

Pressione `Ctrl+C` para sair do Tinker.

---

### **PASSO 8: Configurar Domínio Personalizado**

1. No serviço da aplicação, vá em **"Settings"** → **"Domains"**
2. Clique em **"Custom Domain"**
3. Digite seu domínio (ex: `avaliaganhe.com.br`)
4. O Railway mostrará instruções de DNS
5. Configure no seu provedor de domínio:

   - **Tipo:** `CNAME`
   - **Nome:** `@` ou `www`
   - **Valor:** O endereço fornecido pelo Railway (ex: `seu-app.up.railway.app`)

6. Aguarde alguns minutos para propagação DNS
7. O SSL será configurado automaticamente pelo Railway! 🔒

---

### **PASSO 9: Verificar Deploy**

1. Após o deploy, acesse a URL fornecida pelo Railway
2. Você deve ver a página de login
3. Se aparecer erro, verifique os logs em **"Deployments"** → **"View Logs"**

---

## 🔧 Solução de Problemas Comuns

### **Erro: "Script start.sh not found" ou "Railpack could not determine how to build the app"**

**Este é o erro mais comum e acontece quando o Root Directory não está configurado!**

**Solução:**
1. Vá em **Settings** → **Service**
2. Em **Root Directory**, digite exatamente: `reviews-platform`
3. Clique em **Save**
4. Aguarde alguns segundos
5. Vá em **Deployments** e clique em **"Redeploy"** ou **"Deploy"**
6. O build deve funcionar agora

**Se ainda não funcionar:**
- Verifique se digitou exatamente `reviews-platform` (sem barra no final, sem espaços)
- Tente fazer um novo deploy do zero (deletar o serviço e criar novamente)
- Verifique se o repositório está conectado corretamente

### **Erro: "No version available for php 8.0.2"**

**Solução:** Já está corrigido! O projeto usa PHP 8.2.

### **Erro de Conexão com Banco**

**Solução:**
1. Verifique se as variáveis `DB_*` estão corretas
2. Use as variáveis de referência: `${{MySQL.MYSQLHOST}}` (não valores diretos)
3. Verifique se o serviço MySQL está rodando

### **Página em Branco**

**Solução:**
1. Verifique se `APP_KEY` está configurada
2. Execute no shell:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

### **Erro 500 Internal Server Error**

**Solução:**
1. Verifique os logs em **"Deployments"** → **"View Logs"**
2. Verifique se todas as variáveis de ambiente estão configuradas
3. Verifique se as migrações foram executadas

---

## 📊 Estrutura de Custos Railway

### **Plano Gratuito (Hobby)**
- ✅ $5 de crédito grátis por mês
- ✅ Deploy ilimitado
- ✅ Domínio `.railway.app` grátis
- ⚠️ Serviço pode "dormir" após inatividade

### **Plano Pro ($20/mês)**
- ✅ Sempre online
- ✅ Domínio personalizado grátis
- ✅ Mais recursos
- ✅ Suporte prioritário

**Recomendação:** Comece com o plano gratuito e atualize se necessário.

---

## ✅ Checklist Final

Antes de considerar o deploy completo, verifique:

- [ ] Repositório conectado ao Railway
- [ ] Root Directory configurado como `reviews-platform`
- [ ] Banco MySQL criado e conectado
- [ ] Todas as variáveis de ambiente configuradas
- [ ] `APP_KEY` gerada e configurada
- [ ] Migrações executadas com sucesso
- [ ] Aplicação acessível pela URL do Railway
- [ ] Domínio personalizado configurado (se aplicável)
- [ ] SSL funcionando (automático no Railway)
- [ ] Email configurado e testado

---

## 🆘 Precisa de Ajuda?

Se encontrar problemas:

1. **Verifique os logs:** **Deployments** → **View Logs**
2. **Verifique as variáveis:** **Variables** (todas devem estar preenchidas)
3. **Consulte a documentação:** https://docs.railway.app
4. **Suporte Railway:** https://railway.app/help

---

## 📝 Notas Importantes

- ⚠️ **Nunca commite o arquivo `.env`** no GitHub (já está no `.gitignore`)
- ✅ O Railway faz deploy automático a cada push no GitHub
- ✅ Você pode fazer deploy manual clicando em **"Deploy"**
- ✅ O Railway fornece logs em tempo real
- ✅ SSL é configurado automaticamente (Let's Encrypt)

---

**Pronto!** 🎉 Seu sistema estará no ar e acessível pela internet!

---

**Última atualização:** 2025-01-09  
**Versão do Sistema:** 2.2.0

