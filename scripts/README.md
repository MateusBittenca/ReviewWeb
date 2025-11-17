# 📜 Scripts Auxiliares

Esta pasta contém scripts auxiliares para gerenciar o projeto.

## 📋 Scripts Disponíveis

### 🔧 Utilitários

#### `backup_database.bat`
Faz backup do banco de dados MySQL.

**Uso:**
```bash
.\scripts\backup_database.bat
```

**O que faz:**
- Cria backup do banco `reviews_platform`
- Salva em `reviews-platform/backups/`
- Nome do arquivo: `backup_YYYYMMDD_HHMMSS.sql`

---

#### `check_system_status.bat`
Verifica o status do sistema e dependências.

**Uso:**
```bash
.\scripts\check_system_status.bat
```

**O que verifica:**
- PHP instalado e versão
- Composer instalado
- MySQL rodando
- Portas 8000 e 3306 disponíveis
- Estrutura do projeto

---

#### `INICIAR_APLICACAO_E_NGROK.bat`
Inicia a aplicação Laravel e o ngrok para expor publicamente.

**Uso:**
```bash
.\scripts\INICIAR_APLICACAO_E_NGROK.bat
```

**Requisitos:**
- Ngrok instalado e configurado
- Token de autenticação do ngrok configurado

**O que faz:**
- Inicia o servidor Laravel na porta 8000
- Inicia o ngrok na porta 4040
- Expõe a aplicação publicamente na internet

---

## 📁 Estrutura

```
scripts/
├── README.md                      ← Este arquivo
├── backup_database.bat            ← Backup do banco
├── check_system_status.bat       ← Verificação de status
└── INICIAR_APLICACAO_E_NGROK.bat ← Iniciar com ngrok
```

---

## 💡 Dicas

- Execute os scripts como **Administrador** se houver problemas de permissão
- Os backups são salvos automaticamente em `reviews-platform/backups/`
- Mantenha backups regulares antes de atualizações importantes

---

## 🔒 Segurança

⚠️ **Importante:**
- Não compartilhe backups que contenham dados sensíveis
- Mantenha os backups em local seguro
- Remova backups antigos periodicamente

