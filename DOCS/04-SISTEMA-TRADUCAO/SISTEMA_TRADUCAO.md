# Sistema de Tradução - Reviews Platform

## 📋 Índice
1. [Visão Geral](#visão-geral)
2. [Estrutura de Arquivos](#estrutura-de-arquivos)
3. [Como Funciona](#como-funciona)
4. [Arquivos de Tradução](#arquivos-de-tradução)
5. [Middleware e Configuração](#middleware-e-configuração)
6. [Views Traduzidas](#views-traduzidas)
7. [JavaScript e Traduções Dinâmicas](#javascript-e-traduções-dinâmicas)
8. [Manutenção e Atualização](#manutenção-e-atualização)
9. [Troubleshooting](#troubleshooting)

---

## 🎯 Visão Geral

O sistema de tradução foi implementado para suportar **Português (pt_BR)** e **Inglês (en_US)** em toda a aplicação. O sistema utiliza:

- Laravel Translation System
- Seletor de idioma no header
- Middleware para gerenciar o locale
- Sessão para persistir a escolha do usuário
- Traduções dinâmicas em JavaScript

---

## 📁 Estrutura de Arquivos

```
reviews-platform/
├── lang/
│   ├── pt_BR/
│   │   ├── app.php                    # Traduções principais da aplicação
│   │   ├── companies.php              # Traduções de empresas
│   │   ├── reviews.php                # Traduções de avaliações
│   │   └── dashboard.php             # Traduções do dashboard
│   └── en_US/
│       ├── app.php
│       ├── companies.php
│       ├── reviews.php
│       └── dashboard.php
├── app/
│   └── Http/
│       └── Middleware/
│           └── SetLocale.php         # Middleware de idioma
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── admin.blade.php       # Layout principal (traduzido)
│       ├── companies.blade.php       # Listagem de empresas
│       ├── companies-create.blade.php # Criação de empresas
│       ├── dashboard.blade.php       # Dashboard
│       └── admin/
│           └── reviews/
│               └── index.blade.php   # Painel de avaliações
└── routes/
    └── web.php                       # Rota de mudança de idioma
```

---

## 🔧 Como Funciona

### 1. Fluxo de Tradução

```
Usuário → Seleciona idioma → Middleware SetLocale → Sessão salva locale → 
Aplicação usa locale → Views renderizadas com traduções
```

### 2. Componentes Principais

#### A. Middleware SetLocale
**Arquivo:** `app/Http/Middleware/SetLocale.php`

Responsabilidades:
- Captura parâmetro `lang` da URL (se presente)
- Salva o locale na sessão
- Define o locale da aplicação via `App::setLocale()`
- Valida que o locale é permitido (pt_BR ou en_US)

#### B. Rota de Troca de Idioma
**Arquivo:** `routes/web.php` (linhas 13-22)

Endpoint: `POST /change-locale`
- Recebe o novo locale
- Salva na sessão
- Retorna sucesso/falha

#### C. Componente Seletor de Idioma
**Arquivo:** `resources/views/components/language-selector.blade.php`

- Dropdown com opções Português e English
- Detecta idioma atual
- Faz requisição AJAX para trocar idioma
- Recarrega a página após sucesso

---

## 📝 Arquivos de Tradução

### Formato
Cada arquivo PHP retorna um array associativo:

```php
<?php
return [
    'key' => 'Valor traduzido',
    // ...
];
```

### Uso nas Views
```blade
{{ __('namespace.key') }}
```

Exemplos:
- `{{ __('app.name') }}` - Nome da aplicação
- `{{ __('companies.title') }}` - Título de empresas
- `{{ __('reviews.positive') }}` - Label "Positivas"

---

## 🎨 Arquivos Traduzidos

### 1. `lang/pt_BR/app.php` e `lang/en_US/app.php`

**Traduções principais:**
- Nome e subtítulo da plataforma
- Navegação (Dashboard, Empresas, Avaliações, etc.)
- Configurações (Assinatura, Cobrança, Perfil)
- Suporte (Central de Ajuda, FAQs)
- Labels genéricos (Sair, Entrar, etc.)

**Principais chaves:**
```php
'name' => 'Reviews Platform',
'dashboard' => 'Dashboard',
'companies' => 'Empresas',
'reviews' => 'Avaliações',
'settings' => 'Configurações',
'logout' => 'Sair',
// ... etc
```

### 2. `lang/pt_BR/companies.php` e `lang/en_US/companies.php`

**Traduções de Empresas:**

Categorias:
- Títulos e descrições de páginas
- Formulários (labels, placeholders, hints)
- Status (Ativo, Rascunho, Visível, Oculto)
- Ações (Editar, Ver Página, Excluir)
- Mensagens de sucesso/erro

**Principais chaves:**
```php
'title' => 'Empresas',
'create' => 'Criar Nova Empresa',
'edit' => 'Editar',
'active' => 'Ativo',
'draft' => 'Rascunho',
'view_page' => 'Ver Página',
// ... etc
```

### 3. `lang/pt_BR/reviews.php` e `lang/en_US/reviews.php`

**Traduções de Avaliações:**

Categorias:
- Dashboard de reviews
- Filtros e controles
- Estatísticas (Total, Positivas, Negativas, Média)
- Gráficos (labels, períodos)
- Tabelas (cabeçalhos)
- Ações em reviews (Processar, Excluir, Contatar)
- Dias da semana (para gráficos)

**Principais chaves:**
```php
'title' => 'Avaliações',
'dashboard_title' => 'Painel de Avaliações',
'filters' => 'Filtros',
'total_reviews' => 'Total de Avaliações',
'positivas' => 'Positivas',
'negativas' => 'Negativas',
'monday' => 'Seg',  // Dias da semana
// ... etc
```

### 4. `lang/pt_BR/dashboard.php` e `lang/en_US/dashboard.php`

**Traduções do Dashboard:**

Categorias:
- Cards de funcionalidades (Avaliações, Loja, Recursos, etc.)
- Descrições de cada card
- Títulos e labels

**Principais chaves:**
```php
'title' => 'Dashboard',
'overview' => 'Overview',
'total_reviews' => 'Total de Avaliações',
'store' => 'Loja',
'resources' => 'Recursos',
// ... etc
```

---

## ⚙️ Middleware e Configuração

### Registro do Middleware

**Arquivo:** `app/Http/Kernel.php`

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\SetLocale::class,
    ],
];
```

### Seletor de Idioma

**View:** `resources/views/components/language-selector.blade.php`

**Localização:** Header da aplicação (topo direito)

**Funcionalidade:**
- Exibe idioma atual
- Dropdown com alternativas
- Requisição AJAX para `/change-locale`
- Recarrega página após mudança

---

## 🎨 Views Traduzidas

### 1. Layout Admin (`layouts/admin.blade.php`)

**Traduções aplicadas:**
- Logo e nome da plataforma
- Sidebar completa (navegação, configurações, suporte)
- Texto do usuário (Administrador)
- Botão Sair

### 2. Listagem de Empresas (`companies.blade.php`)

**Traduções aplicadas:**
- Título e descrição da página
- Botões (Nova Empresa, Editar, Ver Página)
- Status (Ativo, Rascunho, Visível, Oculto)
- Labels (páginas, avaliações, limite de estrelas)
- Mensagens de estado vazio

### 3. Criar Empresa (`companies-create.blade.php`)

**Traduções aplicadas:**
- Título e descrição
- Barra de progresso
- Seções (Informações Básicas, Detalhes, Google My Business, Personalização Visual)
- Labels e placeholders de formulários
- Botões (Voltar, Salvar Empresa)
- Hints e descrições

### 4. Dashboard (`dashboard.blade.php`)

**Traduções aplicadas:**
- Todos os cards de funcionalidades
- Títulos e descrições de cada card
- JavaScript de navegação atualizado

### 5. Painel de Avaliações (`admin/reviews/index.blade.php`)

**Traduções aplicadas:**
- Títulos e descrições
- Filtros (Empresa, Tipo, Nota, Período)
- Estatísticas (Total, Positivas, Negativas, Média)
- Gráficos (labels, períodos, legendas)
- Tabela de performance (cabeçalhos)
- Lista de reviews (botões, status)
- Mensagens de loading e estado vazio

---

## 💻 JavaScript e Traduções Dinâmicas

### Traduções Estáticas

São traduções que o Laravel resolve no servidor durante o render da view:

```blade
{{ __('reviews.title') }}
```

### Traduções Dinâmicas (JavaScript)

Para conteúdo gerado dinamicamente por JavaScript:

#### A. Variáveis Globais

No início do script da página de reviews:

```javascript
const translations = {
    pt_BR: {
        monday: 'Seg', tuesday: 'Ter', // ... dias
        positivas: 'Positivas', negativas: 'Negativas'
    },
    en_US: {
        monday: 'Mon', tuesday: 'Tue', // ... dias
        positivas: 'Positive', negativas: 'Negative'
    }
};

const currentLang = '{{ app()->getLocale() }}';
const t = translations[currentLang] || translations.pt_BR;
```

**Uso:**
```javascript
const dayNames = [t.sunday, t.monday, t.tuesday, ...];
```

#### B. Interpolação em Templates JavaScript

Para botões e textos em templates gerados:

```javascript
return \`
    <button>{{ __('reviews.contact') }}</button>
\`;
```

### Atenção: Limitações

- JavaScript não recarrega automaticamente ao trocar idioma
- Templates gerados mantêm o idioma da renderização inicial
- Para updates dinâmicos, o usuário deve recarregar a página

---

## 🔄 Manutenção e Atualização

### Como Adicionar Nova Tradução

#### 1. Identificar onde adicionar

Determine se é:
- **Geral (app.php)**: Navegação, labels principais
- **Específico**: Crie/edite arquivo específico (ex: `users.php`)

#### 2. Adicionar nos arquivos

**Arquivo:** `lang/pt_BR/seu_arquivo.php`
```php
return [
    // ... traduções existentes
    'nova_chave' => 'Valor em Português',
];
```

**Arquivo:** `lang/en_US/seu_arquivo.php`
```php
return [
    // ... traduções existentes
    'nova_chave' => 'Value in English',
];
```

#### 3. Usar nas views

```blade
{{ __('namespace.nova_chave') }}
```

### Como Traduzir Nova Página

#### Passo 1: Criar arquivo de tradução

Criar `lang/pt_BR/sua_pagina.php` e `lang/en_US/sua_pagina.php`

#### Passo 2: Adicionar traduções

Definir todas as strings necessárias

#### Passo 3: Substituir textos na view

De:
```blade
<h1>Meu Título</h1>
```

Para:
```blade
<h1>{{ __('sua_pagina.titulo') }}</h1>
```

#### Passo 4: Limpar cache

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### Como Adicionar Novo Idioma

#### 1. Criar diretório

```bash
mkdir lang/fr_FR  # Exemplo: Francês
```

#### 2. Copiar arquivos

Copie todos os arquivos de `pt_BR` para `fr_FR` e traduza

#### 3. Atualizar Middleware

**Arquivo:** `app/Http/Middleware/SetLocale.php`

```php
if (!in_array($locale, ['pt_BR', 'en_US', 'fr_FR'])) {
    $locale = 'pt_BR';
}
```

#### 4. Atualizar Seletor

**Arquivo:** `resources/views/components/language-selector.blade.php`

Adicionar opção no dropdown

#### 5. Limpar cache

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

---

## 🐛 Troubleshooting

### Problema: Traduções não aparecem

**Solução:**
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### Problema: Chave de tradução não encontrada

**Erro:** `translation key not found`

**Solução:**
1. Verifique se a chave existe no arquivo correto
2. Verifique se está no idioma correto
3. Verifique o namespace usado

**Exemplo:**
```blade
{{ __('companies.title') }}  # Correto
{{ __('company.title') }}     # ERRADO - namespace errado
```

### Problema: Idioma não persiste

**Causa:** Sessão não configurada ou middleware não aplicado

**Solução:**
1. Verifique se `SetLocale` está registrado em `Kernel.php`
2. Verifique configuração de sessão em `.env`
3. Limpe cache de sessão

### Problema: JavaScript não traduz

**Solução:**
1. Verifique se `translations` está definido no script
2. Verifique se `currentLang` está sendo injetado corretamente
3. Se necessário, force recarregamento após mudança de idioma

---

## 📊 Checklist de Tradução

Ao adicionar nova funcionalidade, use este checklist:

- [ ] Identificar todos os textos hardcoded
- [ ] Criar/editar arquivo de tradução apropriado
- [ ] Adicionar chaves em PT_BR
- [ ] Adicionar chaves em EN_US
- [ ] Substituir textos nas views Blade
- [ ] Verificar templates JavaScript dinâmicos
- [ ] Adicionar traduções em variáveis JavaScript (se necessário)
- [ ] Limpar cache
- [ ] Testar em ambos idiomas
- [ ] Verificar persistência da escolha

---

## 📚 Arquivos Modificados

### Arquivos Criados

1. `lang/pt_BR/app.php` - Traduções principais
2. `lang/pt_BR/companies.php` - Traduções de empresas
3. `lang/pt_BR/reviews.php` - Traduções de avaliações
4. `lang/pt_BR/dashboard.php` - Traduções do dashboard
5. `lang/en_US/app.php` - Main translations
6. `lang/en_US/companies.php` - Company translations
7. `lang/en_US/reviews.php` - Reviews translations
8. `lang/en_US/dashboard.php` - Dashboard translations
9. `app/Http/Middleware/SetLocale.php` - Locale middleware
10. `resources/views/components/language-selector.blade.php` - Language selector

### Arquivos Modificados

1. `routes/web.php` - Rota de troca de idioma
2. `app/Http/Kernel.php` - Registro do middleware
3. `resources/views/layouts/admin.blade.php` - Aplicar traduções
4. `resources/views/companies.blade.php` - Aplicar traduções
5. `resources/views/companies-create.blade.php` - Aplicar traduções
6. `resources/views/dashboard.blade.php` - Aplicar traduções
7. `resources/views/admin/reviews/index.blade.php` - Aplicar traduções + JS

---

## 🎯 Boas Práticas

1. **Sempre traduza em par:** Quando adicionar em PT_BR, adicione em EN_US
2. **Use nomes descritivos:** `'create_company_button'` em vez de `'btn1'`
3. **Organize por contexto:** Agrupe traduções relacionadas
4. **Mantenha consistência:** Use o mesmo padrão de nomenclatura
5. **Documente exceções:** Comente traduções especiais
6. **Teste ambos idiomas:** Sempre verifique em PT e EN
7. **Cache management:** Limpe cache após mudanças

---

## 🚀 Comandos Úteis

```bash
# Limpar todos os caches
php artisan view:clear && php artisan config:clear && php artisan cache:clear

# Verificar locale atual
php artisan tinker
>>> app()->getLocale()

# Testar tradução específica
>>> __('app.name')
```

---

## 📞 Suporte

Para dúvidas ou problemas com o sistema de tradução:

1. Verifique esta documentação
2. Consulte a seção Troubleshooting
3. Verifique os logs em `storage/logs/laravel.log`
4. Teste em modo de debug (ativar em `.env`)

---

**Última atualização:** Dezembro 2024  
**Versão:** 1.0  
**Mantenedor:** Sistema de Tradução Reviews Platform

