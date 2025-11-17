# 📧 06 - Sistema de Email

Documentação do sistema de email SMTP.

## 📁 Documentos

- **CONFIGURAR_EMAIL_SMTP.md** - ⭐ Guia completo de configuração (LEIA PRIMEIRO)
- **QUICK_START_EMAIL.md** - Início rápido
- **EMAIL_CONFIG.md** - Configuração de email
- **EMAIL_SETUP.md** - Setup de email
- **FIX_EMAIL_LOGO.md** - Como corrigir logo nos emails
- **RESUMO_CORRECAO_LOGO.md** - Resumo da correção da logo

## 🚀 Configuração Rápida

1. **Leia:** `CONFIGURAR_EMAIL_SMTP.md`
2. **Configure:** Variáveis no `.env`
3. **Teste:** Envie email de teste
4. **Verifique:** Logs em `storage/logs/`

## ⚙️ Variáveis Necessárias

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 🔧 Suporte a Provedores

- **Gmail** (configurado por padrão)
- **Outlook/Hotmail**
- **Yahoo**
- **SMTP customizado**

## 🐛 Problemas Comuns

- **Erro de autenticação:** Veja senha de app em `CONFIGURAR_EMAIL_SMTP.md`
- **Erro de conexão:** Verifique firewall/proxy
- **Email não enviado:** Verifique logs em `storage/logs/`
- **Logo não aparece nos emails:** Veja `FIX_EMAIL_LOGO.md` e `RESUMO_CORRECAO_LOGO.md`

## 🔧 Correções Recentes

### Logo nos Emails ✅
- URLs absolutas implementadas
- Campo contact_detail adicionado
- Ver: `FIX_EMAIL_LOGO.md`

## 📞 Mais Ajuda

Consulte seção Troubleshooting em `CONFIGURAR_EMAIL_SMTP.md`

