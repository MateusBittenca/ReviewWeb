# 🔧 Configurar SQLTools Extension para MySQL

## 📋 Pré-requisitos

1. ✅ MySQL instalado e rodando (XAMPP, WAMP, ou MySQL standalone)
2. ✅ Extensão SQLTools instalada no VS Code/Cursor
3. ✅ Extensão MySQL/MariaDB driver instalada (SQLTools MySQL/MariaDB)

---

## 🚀 Passo a Passo

### 1. Instalar Extensões Necessárias

No VS Code/Cursor, instale:

1. **SQLTools** - por Matheus Teixeira
2. **SQLTools MySQL/MariaDB** - por Matheus Teixeira

Ou via terminal:
```bash
code --install-extension mtxr.sqltools
code --install-extension mtxr.sqltools-driver-mysql
```

---

### 2. Verificar Credenciais do MySQL

Primeiro, verifique suas credenciais do MySQL. Normalmente no XAMPP:

- **Host:** `127.0.0.1` ou `localhost`
- **Port:** `3306`
- **Database:** `reviews_platform`
- **Username:** `root`
- **Password:** (geralmente vazio no XAMPP, mas pode ter senha)

**Para verificar se tem senha:**
```bash
# Tente conectar sem senha
mysql -u root

# Se pedir senha, você tem senha configurada
mysql -u root -p
```

---

### 3. Configurar Conexão no SQLTools

#### Método 1: Via Interface Gráfica (Recomendado)

1. **Abra o painel SQLTools:**
   - Clique no ícone do SQLTools na barra lateral (ou `Ctrl+Shift+P` → "SQLTools: Show SQLTools")
   - Ou use o atalho: `Ctrl+Shift+E` e procure por "SQLTools"

2. **Adicionar Nova Conexão:**
   - Clique no ícone `+` (Add New Connection)
   - Ou clique com botão direito em "Connections" → "Add New Connection"

3. **Selecione o Driver:**
   - Escolha **"MySQL"** ou **"MariaDB"**

4. **Preencha os Dados:**
   ```
   Connection Name: Reviews Platform - MySQL
   Server Address: 127.0.0.1
   Port: 3306
   Database: reviews_platform
   Username: root
   Password: (deixe vazio se não tiver senha, ou digite sua senha)
   ```

5. **Teste a Conexão:**
   - Clique em "Test Connection"
   - Se der erro, verifique as credenciais

---

#### Método 2: Via Arquivo de Configuração

1. **Crie/Edite o arquivo:** `.vscode/settings.json` na raiz do projeto

2. **Adicione a configuração:**

```json
{
  "sqltools.connections": [
    {
      "name": "Reviews Platform - MySQL",
      "driver": "MySQL",
      "server": "127.0.0.1",
      "port": 3306,
      "database": "reviews_platform",
      "username": "root",
      "password": "",
      "connectionTimeout": 60,
      "requestTimeout": 60
    }
  ],
  "sqltools.useNodeRuntime": true
}
```

**⚠️ IMPORTANTE:**
- Se você **tem senha** no MySQL, substitua `"password": ""` por `"password": "sua_senha"`
- Se você **não tem senha**, deixe `"password": ""` (string vazia)

3. **Recarregue o VS Code/Cursor:**
   - `Ctrl+Shift+P` → "Developer: Reload Window"

---

### 4. Resolver o Erro "Password is required"

Se você está recebendo o erro **"SQLTools Driver Credentials: Password is required"**, siga estes passos:

#### Opção A: Se você NÃO tem senha no MySQL

1. **Deixe o campo Password vazio** na configuração
2. **Use string vazia no JSON:**
   ```json
   "password": ""
   ```
3. **Não deixe o campo em branco** - sempre coloque `""` (aspas duplas vazias)

#### Opção B: Se você TEM senha no MySQL

1. **Digite a senha** no campo Password
2. **No JSON, coloque a senha:**
   ```json
   "password": "sua_senha_aqui"
   ```

#### Opção C: Verificar se o MySQL está rodando

```powershell
# Verificar se MySQL está rodando
netstat -ano | findstr :3306

# Se não estiver rodando, inicie o XAMPP
# Ou inicie o MySQL manualmente
```

---

### 5. Testar a Conexão

1. **Abra o painel SQLTools** (ícone na barra lateral)
2. **Clique com botão direito** na conexão "Reviews Platform - MySQL"
3. **Selecione "Connect"**
4. **Se conectar com sucesso**, você verá as tabelas do banco

---

## 🔍 Troubleshooting

### Erro: "Access denied for user 'root'@'localhost'"

**Solução:**
1. Verifique se o MySQL está rodando
2. Verifique se a senha está correta
3. Tente resetar a senha do MySQL:

```sql
-- Conecte no MySQL como root
mysql -u root -p

-- Execute:
ALTER USER 'root'@'localhost' IDENTIFIED BY '';
FLUSH PRIVILEGES;
```

---

### Erro: "Can't connect to MySQL server on '127.0.0.1'"

**Solução:**
1. Verifique se o MySQL está rodando:
   ```powershell
   netstat -ano | findstr :3306
   ```

2. Se não estiver rodando:
   - **XAMPP:** Abra o XAMPP Control Panel e inicie o MySQL
   - **MySQL Standalone:** Inicie o serviço MySQL

3. Verifique se a porta está correta (geralmente 3306)

---

### Erro: "Unknown database 'reviews_platform'"

**Solução:**
1. Crie o banco de dados:
   ```sql
   CREATE DATABASE reviews_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Ou use outro banco que você já tenha criado

---

### Erro: "Password is required" mesmo com senha vazia

**Solução:**
1. No arquivo `.vscode/settings.json`, certifique-se de usar:
   ```json
   "password": ""
   ```
   (aspas duplas vazias, não remova as aspas)

2. Se ainda não funcionar, tente:
   ```json
   "askForPassword": false,
   "password": ""
   ```

---

## 📝 Configuração Completa de Exemplo

### Para XAMPP (sem senha):
```json
{
  "sqltools.connections": [
    {
      "name": "Reviews Platform - MySQL",
      "driver": "MySQL",
      "server": "127.0.0.1",
      "port": 3306,
      "database": "reviews_platform",
      "username": "root",
      "password": "",
      "connectionTimeout": 60,
      "requestTimeout": 60,
      "askForPassword": false
    }
  ]
}
```

### Para MySQL com senha:
```json
{
  "sqltools.connections": [
    {
      "name": "Reviews Platform - MySQL",
      "driver": "MySQL",
      "server": "127.0.0.1",
      "port": 3306,
      "database": "reviews_platform",
      "username": "root",
      "password": "sua_senha_aqui",
      "connectionTimeout": 60,
      "requestTimeout": 60,
      "askForPassword": false
    }
  ]
}
```

---

## ✅ Verificar se Funcionou

Após configurar:

1. **Abra o painel SQLTools** (ícone na barra lateral)
2. **Conecte** na conexão "Reviews Platform - MySQL"
3. **Expanda** o banco de dados
4. **Veja as tabelas** listadas
5. **Execute uma query** de teste:
   ```sql
   SHOW TABLES;
   ```

Se tudo estiver funcionando, você verá as tabelas do banco de dados! 🎉

---

## 🔐 Segurança

⚠️ **IMPORTANTE:** O arquivo `.vscode/settings.json` pode conter senhas. 

**Para não commitar senhas no Git:**

1. Adicione ao `.gitignore`:
   ```
   .vscode/settings.json
   ```

2. Ou use variáveis de ambiente (mais seguro):
   - Configure a senha via variável de ambiente
   - Use extensões que suportam variáveis de ambiente

---

## 📚 Recursos Adicionais

- [Documentação SQLTools](https://vscode-sqltools.mteixeira.dev/)
- [MySQL Driver Documentation](https://vscode-sqltools.mteixeira.dev/drivers/mysql)
- [Guia de Troubleshooting SQLTools](https://vscode-sqltools.mteixeira.dev/troubleshooting)

---

**Última atualização:** 2025-01-XX




