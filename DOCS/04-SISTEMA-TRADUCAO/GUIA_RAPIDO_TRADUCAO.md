# Guia Rápido - Sistema de Tradução

## 🎯 Quick Reference

### Estrutura de Diretórios

```
lang/
├── pt_BR/
│   ├── app.php           # Navegação, labels gerais
│   ├── companies.php     # Páginas de empresas
│   ├── reviews.php       # Painel de avaliações
│   └── dashboard.php     # Dashboard principal
└── en_US/
    ├── app.php
    ├── companies.php
    ├── reviews.php
    └── dashboard.php
```

---

## 📝 Uso Básico

### Em Views Blade

```blade
{{ __('namespace.chave') }}
```

**Exemplos:**
```blade
{{ __('app.name') }}                    <!-- Nome da aplicação -->
{{ __('companies.title') }}             <!-- Título Empresas -->
{{ __('reviews.total_reviews') }}      <!-- Total de Avaliações -->
```

### Em JavaScript

```javascript
const translations = {
    pt_BR: { monday: 'Seg', ... },
    en_US: { monday: 'Mon', ... }
};
const t = translations[locale];
```

---

## 🔧 Comandos Essenciais

```bash
# Limpar cache após mudanças
php artisan view:clear && php artisan config:clear && php artisan cache:clear

# Ver locale atual
app()->getLocale()
```

---

## ➕ Adicionar Nova Tradução

### 1. Escolha o arquivo
- Geral → `app.php`
- Empresas → `companies.php`
- Reviews → `reviews.php`

### 2. Adicione em ambos idiomas

```php
// lang/pt_BR/seu_arquivo.php
'minha_chave' => 'Valor em Português',

// lang/en_US/seu_arquivo.php
'minha_chave' => 'Value in English',
```

### 3. Use na view

```blade
{{ __('seu_arquivo.minha_chave') }}
```

### 4. Limpe cache

```bash
php artisan view:clear
```

---

## 🔄 Traduzir Nova Página

1. **Criar arquivos** `lang/pt_BR/nova_pagina.php` e `lang/en_US/nova_pagina.php`
2. **Definir traduções** para todas as strings
3. **Substituir textos** hardcoded por `{{ __('nova_pagina.chave') }}`
4. **Limpar cache**
5. **Testar** em ambos idiomas

---

## ⚙️ Configuração

### Middleware
Arquivo: `app/Http/Middleware/SetLocale.php`

Registrado em: `app/Http/Kernel.php`

### Seletor de Idioma
Arquivo: `resources/views/components/language-selector.blade.php`

Localização: Header superior direito

### Rota de Troca
Endpoint: `POST /change-locale`  
Arquivo: `routes/web.php`

---

## 📋 Checklist de Tradução

- [ ] Arquivo de tradução existe (PT e EN)
- [ ] Chaves adicionadas nos dois idiomas
- [ ] Textos substituídos na view
- [ ] JavaScript atualizado (se dinâmico)
- [ ] Cache limpo
- [ ] Testado em ambos idiomas

---

## 🐛 Problemas Comuns

| Problema | Solução |
|----------|---------|
| Traduções não aparecem | `php artisan view:clear` |
| Chave não encontrada | Verificar namespace e arquivo |
| Idioma não persiste | Verificar sessão e middleware |
| JS não traduz | Verificar variável `translations` |

---

## 📚 Arquivos Importantes

| Arquivo | Função |
|---------|--------|
| `SetLocale.php` | Gerencia locale da aplicação |
| `language-selector.blade.php` | Componente seletor |
| `lang/{locale}/*.php` | Arquivos de tradução |
| `routes/web.php` | Rota `/change-locale` |

---

**Para documentação completa:** Veja `SISTEMA_TRADUCAO.md`

