# ⚡ Guia de Início Rápido - Plataforma de Reviews

## 🎯 Para Usuários Windows (Mais Fácil)

### Pré-requisitos
- ✅ **PHP 8.0+** instalado
- ✅ **Composer** instalado  
- ✅ **Node.js 18+** instalado
- ✅ **MySQL** instalado e rodando

### Passo a Passo

1. **Baixe o projeto** para: `C:\Users\[SEU_USUARIO]\Documents\PROJETOS`

2. **Execute o script automático:**
   - Clique duplo em `INICIAR_APLICACAO.bat`
   - Aguarde alguns segundos
   - Duas janelas se abrirão automaticamente

3. **Acesse a aplicação:**
   - **Frontend:** http://localhost:5173
   - **Backend:** http://localhost:8000

4. **Login inicial:**
   - **Email:** admin@example.com
   - **Senha:** password

## 🐧 Para Linux/Mac

### Instalação Rápida

```bash
# Instalar dependências (Ubuntu/Debian)
sudo apt update
sudo apt install php8.1 php8.1-mysql php8.1-mbstring php8.1-xml composer nodejs npm mysql-server

# Instalar dependências (macOS)
brew install php composer node mysql

# Configurar projeto
cd reviews-platform
composer install
cd frontend && npm install && cd ..

# Configurar banco
mysql -u root -p
CREATE DATABASE reviews_platform;
EXIT;

# Configurar aplicação
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Iniciar servidores
php artisan serve &
cd frontend && npm run dev &
```

## 🚨 Se Algo Der Errado

### Problema: Script não funciona
**Solução:** Execute como Administrador (clique direito → "Executar como administrador")

### Problema: Erro de conexão com banco
**Solução:** 
1. Verifique se MySQL está rodando
2. Confirme senha no arquivo `.env`
3. Crie o banco: `CREATE DATABASE reviews_platform;`

### Problema: Porta já em uso
**Solução:**
```bash
# Laravel em porta diferente
php artisan serve --port=8001

# React em porta diferente  
npm run dev -- --port 5174
```

### Problema: Dependências não instaladas
**Solução:**
```bash
# PHP
composer install

# Node.js
cd frontend
npm install
```

## 📞 Precisa de Ajuda?

1. **Consulte:** `DOCUMENTACAO/TROUBLESHOOTING.md`
2. **Verifique:** Logs em `storage/logs/laravel.log`
3. **Execute:** `php artisan about` para diagnóstico

## 🎉 Pronto!

Sua aplicação está rodando! Agora você pode:
- ✅ Criar empresas
- ✅ Gerenciar reviews
- ✅ Personalizar páginas
- ✅ Configurar notificações

---

**💡 Dica:** Mantenha este arquivo salvo para referência rápida!
