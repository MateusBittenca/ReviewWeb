# 🗄️ Guia da Base de Dados - Reviews Platform

## 📋 Visão Geral

Este guia explica como usar os scripts SQL fornecidos para criar uma base de dados idêntica à descrita na documentação do projeto.

---

## 📦 Arquivos Disponíveis

### 1. **database_schema.sql**
- **Descrição**: Cria a estrutura completa do banco de dados
- **Conteúdo**: Todas as tabelas, índices e relacionamentos
- **Uso**: Criar banco vazio ou resetar estrutura
- **Tamanho**: ~200 linhas

### 2. **database_sample_data.sql**
- **Descrição**: Adiciona dados de exemplo para testes
- **Conteúdo**: 3 empresas + avaliações + usuário admin
- **Uso**: Popular banco com dados de demonstração
- **Tamanho**: ~150 linhas

### 3. **database_complete_data.sql** (opcional)
- **Descrição**: Dados completos para testes avançados
- **Conteúdo**: 10 empresas + múltiplas avaliações
- **Uso**: Ambiente de desenvolvimento completo

---

## 🚀 Como Usar

### **Opção 1: Via phpMyAdmin (Mais Fácil)**

#### Passo 1: Criar o Banco
1. Acesse: http://localhost/phpmyadmin
2. Login: `root` (sem senha)
3. Clique em "Novo" no menu lateral
4. Nome: `reviews_platform`
5. Collation: `utf8mb4_unicode_ci`
6. Clique "Criar"

#### Passo 2: Importar Estrutura
1. Clique no banco `reviews_platform`
2. Clique na aba "Importar"
3. Clique "Escolher arquivo"
4. Selecione: `database_schema.sql`
5. Clique "Executar"
6. Aguarde a mensagem de sucesso

#### Passo 3: Importar Dados (Opcional)
1. Ainda na aba "Importar"
2. Clique "Escolher arquivo"
3. Selecione: `database_sample_data.sql`
4. Clique "Executar"
5. Aguarde a mensagem de sucesso

---

### **Opção 2: Via Linha de Comando**

#### Método Completo (Estrutura + Dados)
```bash
# Navegar até a pasta do projeto
cd C:\Users\[SEU_USUARIO]\Documents\Projeto\Projeto-reviewWEB

# Executar estrutura
mysql -u root -p < database_schema.sql

# Executar dados de exemplo
mysql -u root -p < database_sample_data.sql
```

#### Método Separado
```bash
# Apenas estrutura (banco vazio)
mysql -u root -p reviews_platform < database_schema.sql

# Apenas dados (em banco existente)
mysql -u root -p reviews_platform < database_sample_data.sql
```

---

### **Opção 3: Script Automático (Windows)**

Use o script batch fornecido:

```bash
# Execute o script
IMPORTAR_BANCO.bat

# Escolha uma opção:
# 1. Criar estrutura + dados de exemplo
# 2. Apenas estrutura (banco vazio)
# 3. Resetar banco completamente
```

---

## 📊 Estrutura do Banco de Dados

### **Tabelas Principais**

#### 1. **users** - Usuários Administrativos
```sql
- id (PK)
- name
- email (UNIQUE)
- password
- role (admin/user)
- created_at, updated_at
```

#### 2. **companies** - Empresas/Estabelecimentos
```sql
- id (PK)
- name
- slug (UNIQUE)
- token (UNIQUE)
- logo
- background_image
- negative_email
- contact_number
- business_website
- business_address
- google_business_url
- positive_score (padrão: 4)
- is_active
- created_at, updated_at
```

#### 3. **reviews** - Avaliações dos Clientes
```sql
- id (PK)
- company_id (FK)
- rating (1-5 estrelas)
- whatsapp
- comment
- private_feedback
- contact_preference (enum)
- has_private_feedback
- is_positive
- is_processed
- processed_at
- created_at, updated_at
```

#### 4. **review_pages** - Páginas de Avaliação
```sql
- id (PK)
- company_id (FK)
- token (UNIQUE)
- url
- views_count
- reviews_count
- is_active
- created_at, updated_at
```

---

## 🔑 Credenciais Padrão

### Login Administrativo
- **Email**: `admin@example.com`
- **Senha**: `password`
- **Role**: `admin`

### Dados de Exemplo (database_sample_data.sql)

#### Empresas Criadas:
1. **Restaurante Sabor & Arte**
   - Token: `rest-sabor-arte`
   - Email: `contato@saborarte.com.br`
   - Google URL: https://g.page/restaurante-exemplo

2. **Clínica Saúde Total**
   - Token: `clinica-saude-total`
   - Email: `atendimento@saudetotal.com.br`
   - Google URL: https://g.page/clinica-exemplo

3. **Academia FitPro**
   - Token: `academia-fitpro`
   - Email: `contato@fitpro.com.br`
   - Google URL: https://g.page/academia-exemplo

#### Avaliações Incluídas:
- 6 avaliações positivas (4-5 estrelas)
- 3 avaliações negativas (1-3 estrelas)
- Mix de comentários em português
- Números de WhatsApp de exemplo
- Feedbacks privados nas avaliações negativas

---

## 🧪 Testar a Base de Dados

### Via phpMyAdmin
```sql
-- Verificar usuários
SELECT * FROM users;

-- Verificar empresas
SELECT id, name, slug, token FROM companies;

-- Verificar avaliações
SELECT 
    r.id,
    c.name AS empresa,
    r.rating,
    r.whatsapp,
    r.is_positive
FROM reviews r
JOIN companies c ON r.company_id = c.id;

-- Estatísticas gerais
SELECT 
    c.name AS empresa,
    COUNT(r.id) AS total_avaliacoes,
    AVG(r.rating) AS media_estrelas,
    SUM(CASE WHEN r.is_positive = 1 THEN 1 ELSE 0 END) AS positivas,
    SUM(CASE WHEN r.is_positive = 0 THEN 1 ELSE 0 END) AS negativas
FROM companies c
LEFT JOIN reviews r ON c.id = r.company_id
GROUP BY c.id, c.name;
```

### Via Aplicação Laravel
```bash
# Verificar conexão
php artisan tinker

# Testar queries
>>> \App\Models\User::count();
>>> \App\Models\Company::count();
>>> \App\Models\Review::count();

# Ver dados
>>> \App\Models\Company::with('reviews')->get();
```

---

## 🔧 Comandos Úteis

### Backup do Banco
```bash
# Backup completo
mysqldump -u root -p reviews_platform > backup_reviews_$(date +%Y%m%d).sql

# Backup apenas estrutura
mysqldump -u root -p --no-data reviews_platform > backup_structure.sql

# Backup apenas dados
mysqldump -u root -p --no-create-info reviews_platform > backup_data.sql
```

### Resetar o Banco
```bash
# Dropar e recriar
mysql -u root -p -e "DROP DATABASE IF EXISTS reviews_platform; CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Reimportar estrutura
mysql -u root -p reviews_platform < database_schema.sql

# Reimportar dados
mysql -u root -p reviews_platform < database_sample_data.sql
```

### Verificar Estrutura
```bash
# Ver todas as tabelas
mysql -u root -p reviews_platform -e "SHOW TABLES;"

# Ver estrutura de uma tabela
mysql -u root -p reviews_platform -e "DESCRIBE companies;"

# Ver índices
mysql -u root -p reviews_platform -e "SHOW INDEX FROM reviews;"
```

---

## 🐛 Solução de Problemas

### **Erro: "Access denied for user 'root'"**
**Solução:**
```bash
# Verificar se MySQL está rodando
netstat -an | findstr :3306

# Resetar senha do root (XAMPP)
# 1. Parar MySQL no XAMPP
# 2. Abrir: C:\xampp\mysql\bin
# 3. Executar: mysql -u root
# 4. Executar: ALTER USER 'root'@'localhost' IDENTIFIED BY '';
```

### **Erro: "Database exists"**
**Solução:**
```bash
# Dropar banco existente
mysql -u root -p -e "DROP DATABASE reviews_platform;"

# Recriar
mysql -u root -p < database_schema.sql
```

### **Erro: "Unknown collation: utf8mb4_unicode_ci"**
**Solução:**
```bash
# Atualizar MySQL para versão 5.7+
# Ou usar collation alternativa:
# Editar scripts SQL: utf8mb4_unicode_ci → utf8_general_ci
```

### **Erro: "Foreign key constraint fails"**
**Solução:**
```bash
# Importar na ordem correta:
# 1º: database_schema.sql (cria estrutura)
# 2º: database_sample_data.sql (insere dados)

# Verificar chaves estrangeiras
mysql -u root -p reviews_platform -e "SET FOREIGN_KEY_CHECKS=0;"
```

---

## 📈 Relacionamentos

```
users (1) ──── (N) companies [futuro]
    └─> Um usuário pode gerenciar várias empresas

companies (1) ──── (N) reviews
    └─> Uma empresa tem várias avaliações

companies (1) ──── (1) review_pages
    └─> Uma empresa tem uma página de avaliação

reviews (N) ──── (1) companies
    └─> Uma avaliação pertence a uma empresa
```

---

## 🎯 Cenários de Uso

### **Cenário 1: Desenvolvimento Local**
```bash
# Use dados de exemplo
mysql -u root -p < database_schema.sql
mysql -u root -p < database_sample_data.sql
```

### **Cenário 2: Testes Automatizados**
```bash
# Criar banco de testes
mysql -u root -p -e "CREATE DATABASE reviews_platform_test;"
mysql -u root -p reviews_platform_test < database_schema.sql
```

### **Cenário 3: Produção**
```bash
# Apenas estrutura (sem dados de exemplo)
mysql -u root -p < database_schema.sql

# Criar usuário admin via Laravel
php artisan db:seed --class=AdminUserSeeder
```

### **Cenário 4: Demo para Cliente**
```bash
# Dados completos e realistas
mysql -u root -p < database_schema.sql
mysql -u root -p < database_complete_data.sql
```

---

## 📝 Notas Importantes

### ⚠️ Segurança
- **Altere a senha padrão** `password` em produção
- **Use senhas fortes** para usuários admin
- **Configure backup automático** em produção
- **Não exponha** dados sensíveis de clientes

### 🔄 Manutenção
- **Backup regular** antes de mudanças
- **Teste migrations** em ambiente local primeiro
- **Documente** alterações na estrutura
- **Mantenha** dados de exemplo atualizados

### 🚀 Performance
- **Índices** já estão otimizados nos scripts
- **Foreign keys** garantem integridade
- **CHARSET utf8mb4** suporta emojis
- **ENGINE InnoDB** para transações

---

## 📞 Suporte

### Arquivos Relacionados
- `database_schema.sql` - Estrutura do banco
- `database_sample_data.sql` - Dados de exemplo
- `IMPORTAR_BANCO.bat` - Script automático (Windows)
- `LEIA-ME.txt` - Documentação principal

### Documentação Adicional
- `DOCS/MYSQL_SETUP.md` - Configuração do MySQL
- `DOCS/MYSQL_CONFIG.md` - Configuração avançada
- `DOCS/TROUBLESHOOTING.md` - Solução de problemas

---

## ✅ Checklist de Instalação

- [ ] MySQL instalado e rodando
- [ ] XAMPP configurado (ou MySQL standalone)
- [ ] phpMyAdmin acessível
- [ ] Banco `reviews_platform` criado
- [ ] Script `database_schema.sql` executado
- [ ] Script `database_sample_data.sql` executado (opcional)
- [ ] Login admin testado via phpMyAdmin
- [ ] Arquivo `.env` do Laravel configurado
- [ ] Aplicação Laravel conectada ao banco
- [ ] Testes básicos funcionando

---

**🎉 Banco de dados criado com sucesso!**

*Para mais informações, consulte a documentação completa em `/DOCS`*

