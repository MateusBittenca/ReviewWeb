# 🔒 Segurança Docker - Configuração de Secrets

## ✅ Status Atual

O Dockerfile **NÃO contém secrets hardcoded**. Todos os valores sensíveis são fornecidos em **runtime** via variáveis de ambiente.

## 📋 Como Funciona

### ❌ NÃO fazer (inseguro):
```dockerfile
# ERRADO - NUNCA faça isso
ARG APP_KEY=secret-key
ENV APP_KEY=$APP_KEY
```

### ✅ Fazer (seguro):
```dockerfile
# CORRETO - Sem secrets no Dockerfile
# Secrets são fornecidos em runtime
```

## 🔧 Configuração de Secrets

### Railway (Produção)
1. Acesse o painel do Railway
2. Vá em **Variables**
3. Adicione todas as variáveis necessárias:
   - `APP_KEY`
   - `DB_PASSWORD`
   - `MAIL_PASSWORD`
   - `SENDGRID_API_KEY`
   - etc.

### Docker Compose (Desenvolvimento Local)
O arquivo `docker-compose.yml` contém valores hardcoded **apenas para desenvolvimento local**. 
Em produção, use variáveis de ambiente ou um arquivo `.env` local (não commitado).

### Docker Run
```bash
docker run -e APP_KEY=value -e DB_PASSWORD=value ...
```

## 🚨 Avisos do Scanner

Se você receber avisos sobre secrets em ARG/ENV:
1. Verifique se não há ARG/ENV com secrets no Dockerfile atual
2. Pode ser cache do scanner - tente limpar cache
3. O Railway pode estar analisando uma versão antiga

## ✅ Checklist de Segurança

- [x] Dockerfile não contém ARG com secrets
- [x] Dockerfile não contém ENV com secrets
- [x] `.env` está no `.dockerignore`
- [x] Secrets são fornecidos apenas em runtime
- [x] `docker-compose.yml` é apenas para desenvolvimento local

## 📝 Notas

- O arquivo `.dockerignore` garante que `.env` nunca seja copiado para a imagem
- Todos os secrets devem ser configurados no Railway via painel
- Nunca commite arquivos `.env` com valores reais
