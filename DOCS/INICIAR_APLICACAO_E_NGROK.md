# 🚀 Guia: Como Iniciar a Aplicação e Ngrok

Este guia mostra passo a passo como iniciar a aplicação Laravel e configurar o ngrok para expor o servidor localmente na internet.

---

## 📋 Pré-requisitos

Antes de começar, certifique-se de que você tem:

- ✅ PHP instalado (versão 8.0 ou superior)
- ✅ Composer instalado
- ✅ MySQL rodando
- ✅ Ngrok instalado e configurado com token de autenticação

---

## 🎯 Método Rápido (Recomendado)

### Usando o Script Automático

1. **Clique duas vezes no arquivo:**
   ```
   INICIAR_APLICACAO_E_NGROK.bat
   ```

2. **Aguarde o script executar:**
   - Ele verificará todas as dependências
   - Iniciará o servidor Laravel automaticamente
   - Iniciará o ngrok automaticamente

3. **Copie a URL pública:**
   - Abra: `http://127.0.0.1:4040`
   - Copie a URL que aparece em "Forwarding"

**Pronto!** 🎉

---

## 🔧 Método Manual (Passo a Passo)

Se preferir fazer manualmente ou se o script não funcionar:

### Passo 1: Verificar o Ambiente

#### 1.1. Abrir o Terminal/PowerShell

- Pressione `Win + R`
- Digite `powershell` ou `cmd`
- Pressione Enter

#### 1.2. Navegar até a pasta do projeto

```powershell
cd "C:\Users\IAGO VILELA\Documents\Projeto-reviewWEB-projeto-quase-finalizado-falta-mobile-e-att-pagina-de-crud-usuario-para-ingles-e-formatar-excel\reviews-platform"
```

---

### Passo 2: Verificar Banco de Dados

#### 2.1. Verificar se o MySQL está rodando

- Abra o **XAMPP Control Panel** (ou seu gerenciador MySQL)
- Certifique-se de que o **MySQL** está **Running** (verde)

#### 2.2. Verificar conexão com o banco

O arquivo `.env` deve estar configurado com:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reviews_platform
DB_USERNAME=root
DB_PASSWORD=
```

---

### Passo 3: Verificar Dependências

#### 3.1. Verificar se as dependências estão instaladas

```powershell
# Verificar se a pasta vendor existe
dir vendor
```

Se a pasta `vendor` não existir ou estiver vazia:

```powershell
composer install
```

#### 3.2. Verificar se o arquivo .env existe

```powershell
# Verificar se o arquivo .env existe
dir .env
```

Se não existir, copie do exemplo:

```powershell
copy .env.example .env
```

---

### Passo 4: Iniciar o Servidor Laravel

#### 4.1. Iniciar o servidor de desenvolvimento

```powershell
php artisan serve
```

#### 4.2. Verificar se o servidor iniciou

Você deve ver uma mensagem como:

```
INFO  Server running on [http://127.0.0.1:8000]
```

**⚠️ IMPORTANTE:** Mantenha esta janela do terminal aberta! O servidor precisa estar rodando.

#### 4.3. Testar localmente (opcional)

Abra o navegador e acesse: `http://localhost:8000`

Se a página carregar, o servidor está funcionando corretamente.

---

### Passo 5: Configurar o Ngrok (Primeira Vez)

#### 5.1. Verificar se o ngrok está instalado

```powershell
ngrok version
```

Se não estiver instalado, baixe em: https://ngrok.com/download

#### 5.2. Configurar o token de autenticação (apenas uma vez)

```powershell
ngrok config add-authtoken 34wHrQv5NQUHttuhmGfWVi21zjU_5YQu6DHBRa8ujUA1yJnpy
```

Você deve ver:

```
Authtoken saved to configuration file: C:\Users\IAGO VILELA\AppData\Local/ngrok/ngrok.yml
```

**✅ Esta etapa só precisa ser feita UMA VEZ!** O token fica salvo.

---

### Passo 6: Iniciar o Ngrok

#### 6.1. Abrir uma NOVA janela do Terminal/PowerShell

**⚠️ IMPORTANTE:** Não feche a janela onde o servidor Laravel está rodando!

- Pressione `Win + R`
- Digite `powershell`
- Pressione Enter

#### 6.2. Iniciar o ngrok

```powershell
ngrok http 8000
```

#### 6.3. Verificar se o ngrok iniciou

Você deve ver uma tela como esta:

```
ngrok                                                                        

Session Status                online
Account                       [seu email]
Version                       3.24.0
Region                        United States (us)
Latency                       -
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://xxxxx.ngrok-free.dev -> http://localhost:8000

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

#### 6.4. Copiar a URL pública

Procure pela linha que começa com `Forwarding`. A URL pública será algo como:

```
https://xxxxx.ngrok-free.dev
```

**📋 Esta é a URL que você pode compartilhar com o cliente!**

---

### Passo 7: Verificar se Tudo Está Funcionando

#### 7.1. Acessar o painel do ngrok

Abra o navegador e acesse: `http://127.0.0.1:4040`

Aqui você pode:
- Ver todas as requisições em tempo real
- Ver estatísticas de uso
- Ver logs detalhados

#### 7.2. Testar a URL pública

Abra o navegador e acesse a URL pública do ngrok (ex: `https://xxxxx.ngrok-free.dev`)

**⚠️ Primeira vez:** O ngrok pode mostrar uma página de aviso. Clique em **"Visit Site"** para continuar.

#### 7.3. Verificar se a aplicação carrega

Se você ver a página inicial da aplicação, tudo está funcionando! 🎉

---

## 📝 Resumo dos Comandos

### Janela 1 - Servidor Laravel:
```powershell
cd "C:\Users\IAGO VILELA\Documents\Projeto-reviewWEB-projeto-quase-finalizado-falta-mobile-e-att-pagina-de-crud-usuario-para-ingles-e-formatar-excel\reviews-platform"
php artisan serve
```

### Janela 2 - Ngrok:
```powershell
ngrok http 8000
```

---

## 🛑 Como Parar os Serviços

### Parar o Ngrok:
- Na janela do ngrok, pressione `Ctrl + C`
- Ou feche a janela

### Parar o Servidor Laravel:
- Na janela do servidor, pressione `Ctrl + C`
- Ou feche a janela

---

## ⚠️ Problemas Comuns e Soluções

### Problema 1: "Port 8000 is already in use"

**Solução:** Alguém já está usando a porta 8000.

```powershell
# Verificar qual processo está usando a porta
netstat -ano | findstr :8000

# Ou use outra porta
php artisan serve --port=8001
# E depois inicie o ngrok na porta 8001
ngrok http 8001
```

### Problema 2: "ngrok: command not found"

**Solução:** O ngrok não está no PATH do sistema.

- Adicione o ngrok ao PATH do Windows
- Ou navegue até a pasta onde o ngrok está instalado

### Problema 3: "ERR_NGROK_334 - endpoint already online"

**Solução:** Já existe um túnel ngrok rodando.

```powershell
# Verificar túneis ativos
# Acesse: http://127.0.0.1:4040/api/tunnels

# Ou pare todos os processos ngrok
taskkill /F /IM ngrok.exe
```

### Problema 4: "Failed to connect to database"

**Solução:** O MySQL não está rodando.

1. Abra o XAMPP Control Panel
2. Inicie o MySQL
3. Aguarde alguns segundos
4. Tente novamente

### Problema 5: "Storage link not found"

**Solução:** O link simbólico do storage não existe.

```powershell
php artisan storage:link
```

### Problema 6: "Class not found" ou erros de autoload

**Solução:** As dependências não estão instaladas.

```powershell
composer install
composer dump-autoload
```

### Problema 7: "The .env file is invalid"

**Solução:** O arquivo .env tem algum problema de formatação.

```powershell
# Verifique se não há espaços extras ou caracteres especiais
# Certifique-se de que cada linha está no formato: CHAVE=valor
```

---

## 🔄 Checklist Rápido (Para Usar Todos os Dias)

Use este checklist toda vez que for iniciar a aplicação:

- [ ] MySQL está rodando (XAMPP)
- [ ] Naveguei até a pasta do projeto
- [ ] Verifiquei se o arquivo .env existe
- [ ] Iniciei o servidor Laravel (`php artisan serve`)
- [ ] Abri uma nova janela do terminal
- [ ] Iniciei o ngrok (`ngrok http 8000`)
- [ ] Copiei a URL pública do ngrok
- [ ] Testei a URL pública no navegador

---

## 📊 Monitoramento

### Ver requisições em tempo real:
- Acesse: `http://127.0.0.1:4040`
- Veja todas as requisições que chegam pela URL pública

### Ver logs do Laravel:
- Os logs ficam em: `storage/logs/laravel.log`
- Ou veja no terminal onde o servidor está rodando

---

## 🔐 Credenciais de Acesso

### Usuário Proprietário:
- **Email:** `iagovventura@gmail.com`
- **Senha:** `123456`
- **Função:** Admin

### Usuário Proprietário (Sistema):
- **Email:** `proprietario@reviewsplatform.com`
- **Senha:** `proprietario123`
- **Função:** Proprietário

---

## 📱 URLs Importantes

| Serviço | URL |
|---------|-----|
| **Aplicação Local** | `http://localhost:8000` |
| **Painel Ngrok** | `http://127.0.0.1:4040` |
| **URL Pública** | `https://xxxxx.ngrok-free.dev` (muda a cada vez) |

---

## 💡 Dicas Importantes

1. **Mantenha ambas as janelas abertas:**
   - Janela 1: Servidor Laravel
   - Janela 2: Ngrok

2. **URL do ngrok muda:**
   - A URL pública muda toda vez que você reinicia o ngrok
   - Para ter URL fixa, é necessário plano pago

3. **Primeira visita:**
   - O ngrok pode mostrar uma página de aviso na primeira visita
   - Clique em "Visit Site" para continuar

4. **Performance:**
   - O ngrok gratuito tem limitações de velocidade
   - Para produção, use uma hospedagem real

5. **Segurança:**
   - A URL do ngrok é pública, qualquer pessoa com o link pode acessar
   - Não compartilhe a URL publicamente se houver dados sensíveis

6. **Backup:**
   - Sempre faça backup do banco de dados antes de fazer alterações importantes
   - O ngrok não é uma solução de backup

---

## 🚀 Próximos Passos

Quando estiver pronto para produção:

1. Escolha uma hospedagem (Railway, Render, DigitalOcean, etc.)
2. Configure o banco de dados na nuvem
3. Faça o deploy da aplicação
4. Configure um domínio personalizado
5. Configure SSL/HTTPS

---

## 📞 Suporte

Se encontrar problemas:

1. Verifique os logs: `storage/logs/laravel.log`
2. Verifique o painel do ngrok: `http://127.0.0.1:4040`
3. Verifique se o MySQL está rodando
4. Verifique se as portas 8000 e 4040 estão livres
5. Consulte a documentação: `DOCS/CORRECOES_REALIZADAS.md`

---

## 📚 Documentação Relacionada

- **Correções Realizadas:** `DOCS/CORRECOES_REALIZADAS.md`
- **Guia de Usuários:** `DOCS/GUIA_RAPIDO_USUARIOS.md`
- **Instalação:** `DOCS/01-INSTALACAO/INSTALLATION.md`

---

**Última atualização:** 08/11/2025  
**Versão:** 1.0
