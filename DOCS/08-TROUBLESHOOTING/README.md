# 🔧 08 - Troubleshooting

Soluções para problemas comuns do sistema.

## 📁 Documentos

- **SOLUCAO_ERRO_PDO.md** - Solução de erros PDO
- **COMO_RESOLVER_ERRO_LOGIN.txt** - Erros de login
- **COMO_USAR.md** - Como usar o sistema
- **COMO_USAR.txt** - Guia de uso

## 🚨 Problemas Comuns

### Erros PDO
- **Documento:** `SOLUCAO_ERRO_PDO.md`
- **Solução:** Verificar conexão MySQL

### Erros de Login
- **Documento:** `COMO_RESOLVER_ERRO_LOGIN.txt`
- **Solução:** Verificar credenciais

### Base de Dados
- **Ver:** `../07-BASE-DADOS/`
- **Solução:** Verificar conexão

### Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 💡 Dicas

1. **Sempre** verifique os logs: `storage/logs/`
2. **Limpe** cache após mudanças
3. **Verifique** permissões de ficheiros
4. **Confirme** configurações no `.env`

## 📞 Ainda com Problemas?

1. Verifique esta documentação
2. Consulte logs do Laravel
3. Verifique configurações do .env
4. Entre em contato com suporte

