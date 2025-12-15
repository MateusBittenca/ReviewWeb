# 🔧 Solução: Imagens Persistindo Entre Deploys no Railway

## ❌ Problema

Quando você faz deploy de uma nova versão via Git no Railway, **todas as fotos/imagens são excluídas** e você precisa fazer upload novamente.

## 🔍 Por Que Isso Acontece?

1. O Railway usa **containers efêmeros** - a cada deploy, o container é **recriado do zero**
2. O diretório `storage/app/public` está no `.gitignore` (não é commitado no Git)
3. Quando o container é recriado, o diretório `storage/app/public` é criado **vazio**
4. Todas as imagens que foram enviadas são **perdidas**

## ✅ Solução: Configurar Volume Persistente no Railway

O Railway permite criar **Volumes Persistentes** que mantêm os arquivos entre deploys.

### **PASSO 1: Criar Volume Persistente no Railway**

1. No Railway, vá para o seu **projeto**
2. Clique no **serviço da aplicação** (não no banco de dados MySQL)
3. No menu lateral esquerdo, procure por **"Volumes"** (não é "Usage"!)
   - Se não ver "Volumes" no menu, vá em **"Settings"** e procure a aba/seção **"Volumes"**
4. Clique em **"New Volume"** ou **"Create Volume"** (botão verde)
5. Configure:
   - **Name**: `storage-images` (ou qualquer nome que preferir)
   - **Mount Path**: `/var/www/html/storage/app/public`
     - ⚠️ Se o Root Directory estiver configurado como `reviews-platform`, use:
     - `/var/www/html/reviews-platform/storage/app/public`
   - **Size**: Escolha o tamanho necessário (ex: 1GB, 5GB, etc.)
6. Clique em **"Create"** ou **"Add Volume"**

⚠️ **IMPORTANTE**: 
- **NÃO é "Usage"** - Usage apenas mostra estatísticas de uso
- **É "Volumes"** - Seção específica para criar volumes persistentes
- O caminho deve ser exatamente como mostrado acima

### **PASSO 2: Verificar Configuração do Root Directory**

Certifique-se de que o **Root Directory** está configurado:

1. Vá em **Settings** → **Service**
2. Verifique se **Root Directory** está como: `reviews-platform`
3. Se não estiver, configure e salve

### **PASSO 3: Fazer Novo Deploy**

Após criar o volume:

1. Vá em **"Deployments"**
2. Clique em **"Redeploy"** ou faça um novo commit
3. O Railway irá:
   - Criar o container
   - Montar o volume persistente em `/var/www/html/storage/app/public`
   - As imagens antigas estarão lá!

### **PASSO 4: Verificar se Funcionou**

Após o deploy:

1. Faça upload de uma nova imagem
2. Faça um novo deploy
3. A imagem deve **permanecer** após o deploy! ✅

---

## 🔄 Alternativa: Usar Storage em Nuvem (S3)

Se você preferir uma solução mais robusta, pode usar **Amazon S3** ou **DigitalOcean Spaces**:

### Vantagens:
- ✅ Imagens não dependem do servidor
- ✅ Melhor performance (CDN)
- ✅ Escalável
- ✅ Backup automático

### Como Configurar:

1. Criar conta no S3 ou DigitalOcean Spaces
2. Configurar variáveis de ambiente no Railway:
   ```
   FILESYSTEM_DISK=s3
   AWS_ACCESS_KEY_ID=sua_chave
   AWS_SECRET_ACCESS_KEY=sua_secret
   AWS_DEFAULT_REGION=us-east-1
   AWS_BUCKET=nome-do-bucket
   AWS_URL=https://seu-bucket.s3.amazonaws.com
   ```
3. O Laravel já está configurado para usar S3 (ver `config/filesystems.php`)

---

## 📋 Checklist de Verificação

Após configurar o volume:

- [ ] Volume criado no Railway
- [ ] Mount Path correto: `/var/www/html/storage/app/public`
- [ ] Root Directory configurado: `reviews-platform`
- [ ] Novo deploy realizado
- [ ] Imagem de teste enviada
- [ ] Novo deploy realizado novamente
- [ ] Imagem ainda está presente ✅

---

## 🚨 Importante

**NUNCA** faça commit do diretório `storage/app/public` no Git. Ele deve continuar no `.gitignore`.

O volume persistente do Railway é a solução correta para manter as imagens entre deploys.

---

## 📞 Suporte

Se ainda tiver problemas:

1. Verifique os logs do deploy no Railway
2. Verifique se o volume está montado corretamente
3. Verifique as permissões do diretório (deve ser 755 ou 777)

