# 🗄️ 07 - Base de Dados

Documentação sobre a base de dados do sistema.

## 📁 Documentos

- **GUIA_BASE_DADOS.md** - Guia completo da base de dados
- **BANCO_CRIADO_COM_SUCESSO.md** - Status da criação
- **database_schema.sql** - Schema da base de dados
- **database_sample_data.sql** - Dados de exemplo

## 📊 Estrutura

### Tabelas Principais

1. **users** - Utilizadores
2. **companies** - Empresas
3. **reviews** - Avaliações
4. **review_pages** - Páginas de avaliação

## 🚀 Setup

1. **Importe** o schema: `database_schema.sql`
2. **Importe** dados de exemplo: `database_sample_data.sql`
3. **Configure** conexão no `.env`

## 🔍 Schema

Ver: `database_schema.sql`

## 📝 Dados de Exemplo

Ver: `database_sample_data.sql`

## 🔧 Comandos Artisan

```bash
php artisan migrate        # Criar tabelas
php artisan db:seed        # Popular dados
php artisan db:wipe        # Limpar base de dados
```

## ⚠️ Backup

Sempre faça backup antes de alterar dados!

## 📞 Mais Ajuda

Consulte: `../01-INSTALACAO/MYSQL_SETUP.md`

