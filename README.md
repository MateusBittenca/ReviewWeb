# 🌟 Reviews Platform

> Sistema completo de gestão de avaliações com redirecionamento inteligente e feedback privado

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)](https://mysql.com)
[![Status](https://img.shields.io/badge/Status-Produção-success)](docs/project/status.md)

---

## ⚡ Início Rápido

### Para Windows (XAMPP)

1. **Certifique-se de que o XAMPP está rodando** (Apache e MySQL ativos)

2. **Clique duas vezes em:**
   ```
   INICIAR_APLICACAO.bat
   ```

3. **Acesse:**
   ```
   http://localhost:8000
   ```

4. **Login padrão:**
   - Email: `admin@reviewsplatform.com`
   - Senha: `admin123`

**Pronto!** 🎉 O sistema fará toda a configuração automaticamente.

---

## 📁 Estrutura do Projeto

```
Projeto-reviewWEB/
│
├── 📄 INICIAR_APLICACAO.bat    ← Execute este para iniciar
├── 📄 PARAR_APLICACAO.bat       ← Execute este para parar
├── 📄 README.md                 ← Este arquivo
│
├── 📁 DOCS/                     ← Documentação completa
│   ├── 01-INSTALACAO/          ← Guias de instalação
│   ├── 03-DESENVOLVIMENTO/     ← Guias de desenvolvimento
│   ├── 04-SISTEMA-TRADUCAO/    ← Sistema de tradução
│   ├── 05-SISTEMA-DARKMODE/    ← Dark mode
│   ├── 06-SISTEMA-EMAIL/       ← Configuração de email
│   ├── 07-BASE-DADOS/          ← Banco de dados
│   ├── 08-TROUBLESHOOTING/     ← Solução de problemas
│   └── ...
│
├── 📁 scripts/                  ← Scripts auxiliares
│   ├── backup_database.bat
│   ├── check_system_status.bat
│   └── INICIAR_APLICACAO_E_NGROK.bat
│
└── 📁 reviews-platform/        ← PROJETO PRINCIPAL (Laravel)
    ├── app/                    ← Lógica da aplicação
    ├── database/               ← Migrations e seeders
    ├── public/                  ← Arquivos públicos
    ├── resources/              ← Views Blade
    ├── routes/                  ← Rotas
    ├── storage/                 ← Logs e cache
    └── .env                     ← Configurações
```

---

## ✨ Funcionalidades

### 🎯 Core Features
- ✅ **Gestão de Empresas** - CRUD completo com upload de logo e fundo
- ✅ **Páginas Públicas** - URL customizada por empresa
- ✅ **Coleta de Avaliações** - Sistema de estrelas + WhatsApp obrigatório
- ✅ **Redirecionamento Inteligente** - Baseado na nota (positiva/negativa)
- ✅ **Notificações por Email** - Alertas automáticos ao proprietário
- ✅ **Dashboard Administrativo** - Estatísticas e gráficos em tempo real
- ✅ **Exportação CSV** - Download de contatos e dados

### 🎁 Extras Implementados
- 🌍 **Tradução PT/EN** - Interface em dois idiomas
- 🌙 **Dark Mode** - Modo escuro para reduzir fadiga visual
- 🚨 **Badge de Negativas** - Alerta visual de novas avaliações negativas
- 🔒 **Proteção de Dados** - Impede deleção de empresas com avaliações
- 📊 **Gráficos Interativos** - Chart.js com animações

---

## 🛠️ Requisitos

- PHP 8.1 ou superior
- Composer
- MySQL 8.0 ou superior
- XAMPP (recomendado para Windows)

---

## 📚 Documentação

Documentação completa disponível em: **[DOCS/README.md](DOCS/README.md)**

### Guias Principais:
- 📖 [Guia de Instalação](DOCS/01-INSTALACAO/INSTALLATION.md)
- 🚀 [Início Rápido](DOCS/01-INSTALACAO/INICIO_RAPIDO.md)
- 🗄️ [Configuração MySQL](DOCS/01-INSTALACAO/MYSQL_SETUP.md)
- 📧 [Configuração Email](DOCS/06-SISTEMA-EMAIL/EMAIL_SETUP.md)
- 🆘 [Troubleshooting](DOCS/08-TROUBLESHOOTING/README.md)

---

## 🚀 Como Funciona

### Para Administradores
1. **Criar Empresa** no painel administrativo
2. **Configurar** logo, fundo, URL e nota positiva
3. **Compartilhar** link público com clientes
4. **Monitorar** avaliações no dashboard
5. **Exportar** contatos quando necessário

### Para Clientes (Avaliadores)
1. **Acessar** link público da empresa
2. **Informar** WhatsApp
3. **Dar** nota de 1 a 5 estrelas
4. **Se positiva** (≥ nota configurada):
   - Escrever comentário opcional
   - Redirecionado para Google Maps
5. **Se negativa** (< nota configurada):
   - Dar feedback privado
   - Escolher forma de contato
   - Proprietário recebe email

---

## 🔧 Scripts Disponíveis

### Na Raiz:
- `INICIAR_APLICACAO.bat` - Inicia o servidor Laravel
- `PARAR_APLICACAO.bat` - Para o servidor Laravel

### Em `scripts/`:
- `backup_database.bat` - Faz backup do banco de dados
- `check_system_status.bat` - Verifica status do sistema
- `INICIAR_APLICACAO_E_NGROK.bat` - Inicia com ngrok (túnel público)

---

## 🆘 Problemas Comuns

### Erro de Conexão com Banco
```bash
# Verificar se MySQL está rodando no XAMPP
# Verificar configurações no .env
```

### Página em Branco
```bash
# Limpar cache
cd reviews-platform
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

📖 **Mais soluções:** [Troubleshooting](DOCS/08-TROUBLESHOOTING/README.md)

---

## 📝 Licença

Este projeto é propriedade privada. Todos os direitos reservados.

---

## 👨‍💻 Desenvolvedores

**Iago Vilela**  
**Mateus Bittencourt**

---

<div align="center">

**[Documentação](DOCS/README.md)** • 
**[Quick Start](DOCS/01-INSTALACAO/INICIO_RAPIDO.md)** • 
**[Troubleshooting](DOCS/08-TROUBLESHOOTING/README.md)**

---

Feito com ❤️

**Versão 2.2.0** | 2025

</div>
