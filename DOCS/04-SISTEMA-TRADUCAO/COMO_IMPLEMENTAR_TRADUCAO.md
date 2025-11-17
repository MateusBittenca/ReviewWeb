# 🌍 SISTEMA DE TRADUÇÃO (i18n) - Guia Completo

## 🎯 **OBJETIVO**
Implementar suporte a múltiplos idiomas (Português/English) na aplicação.

---

## 📋 **PLANO DE IMPLEMENTAÇÃO**

### **ETAPA 1: Configuração Básica**

#### **1.1. Configurar locale no config/app.php**

Edite `reviews-platform/config/app.php`:

```php
'locale' => env('APP_LOCALE', 'pt_BR'),
'fallback_locale' => 'pt_BR',
'available_locales' => ['pt_BR', 'en_US'],
```

#### **1.2. Criar Middleware para gerenciar locale**

**Arquivo:** `app/Http/Middleware/SetLocale.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->get('lang') 
            ?? session('locale') 
            ?? 'pt_BR';
        
        session(['locale' => $locale]);
        App::setLocale($locale);
        
        return $next($request);
    }
}
```

#### **1.3. Registrar middleware**

Edite `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // ... outros middlewares
        \App\Http\Middleware\SetLocale::class,
    ],
];
```

---

### **ETAPA 2: Criar Arquivos de Tradução**

#### **2.1. Estrutura de pastas**

```
reviews-platform/lang/
├── pt_BR/
│   ├── app.php
│   ├── auth.php
│   ├── companies.php
│   ├── reviews.php
│   └── dashboard.php
└── en_US/
    ├── app.php
    ├── auth.php
    ├── companies.php
    ├── reviews.php
    └── dashboard.php
```

#### **2.2. Arquivo de tradução - Empresas (pt_BR)**

**Arquivo:** `lang/pt_BR/companies.php`

```php
<?php

return [
    'title' => 'Empresas',
    'create' => 'Criar Nova Empresa',
    'edit' => 'Editar Empresa',
    'name' => 'Nome da Empresa',
    'active' => 'Ativo',
    'draft' => 'Rascunho',
    'published' => 'Publicada',
    'email' => 'Email para Feedback Negativo',
    'phone' => 'Telefone de Contato',
    'address' => 'Endereço',
    'website' => 'Site da Empresa',
    'google_maps' => 'URL do Google Meu Negócio',
    'logo' => 'Logo da Empresa',
    'background' => 'Imagem de Fundo',
    'save' => 'Salvar',
    'publish' => 'Ativar',
    'delete' => 'Excluir',
    'status' => 'Status',
    'created_at' => 'Criado em',
    'actions' => 'Ações',
    'success' => 'Empresa criada com sucesso!',
    'updated' => 'Empresa atualizada com sucesso!',
    'deleted' => 'Empresa excluída com sucesso!',
];
```

#### **2.3. Arquivo de tradução - Empresas (en_US)**

**Arquivo:** `lang/en_US/companies.php`

```php
<?php

return [
    'title' => 'Companies',
    'create' => 'Create New Company',
    'edit' => 'Edit Company',
    'name' => 'Company Name',
    'active' => 'Active',
    'draft' => 'Draft',
    'published' => 'Published',
    'email' => 'Email for Negative Feedback',
    'phone' => 'Contact Phone',
    'address' => 'Address',
    'website' => 'Company Website',
    'google_maps' => 'Google My Business URL',
    'logo' => 'Company Logo',
    'background' => 'Background Image',
    'save' => 'Save',
    'publish' => 'Activate',
    'delete' => 'Delete',
    'status' => 'Status',
    'created_at' => 'Created at',
    'actions' => 'Actions',
    'success' => 'Company created successfully!',
    'updated' => 'Company updated successfully!',
    'deleted' => 'Company deleted successfully!',
];
```

---

### **ETAPA 3: Criar Selector de Idioma**

#### **3.1. Adicionar ao layout admin**

**Arquivo:** `resources/views/layouts/admin.blade.php`

Adicione um selector de idioma no header:

```html
<select id="languageSelector" class="text-sm border rounded px-2 py-1">
    <option value="pt_BR" {{ session('locale') == 'pt_BR' ? 'selected' : '' }}>🇧🇷 Português</option>
    <option value="en_US" {{ session('locale') == 'en_US' ? 'selected' : '' }}>🇺🇸 English</option>
</select>
```

#### **3.2. JavaScript para trocar idioma**

```javascript
document.getElementById('languageSelector').addEventListener('change', function() {
    const locale = this.value;
    
    fetch('/change-locale', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ locale })
    }).then(() => location.reload());
});
```

#### **3.3. Rota para mudar idioma**

Edite `routes/web.php`:

```php
Route::post('/change-locale', function(Request $request) {
    session(['locale' => $request->locale]);
    return response()->json(['success' => true]);
});
```

---

### **ETAPA 4: Aplicar Traduções nas Views**

#### **4.1. Exemplo de uso nas views**

**Antes:**
```blade
<h1>Empresas Cadastradas</h1>
<button>Criar Nova Empresa</button>
```

**Depois:**
```blade
<h1>{{ __('companies.title') }}</h1>
<button>{{ __('companies.create') }}</button>
```

#### **4.2. Views a serem traduzidas**

- ✅ `resources/views/dashboard.blade.php`
- ✅ `resources/views/companies.blade.php`
- ✅ `resources/views/companies-create.blade.php`
- ✅ `resources/views/companies-edit.blade.php`
- ✅ `resources/views/admin/reviews/index.blade.php`
- ✅ `resources/views/public/review-page.blade.php`

---

### **ETAPA 5: Helper para traduções condicionais**

#### **5.1. Criar helper de idioma**

**Arquivo:** `app/Helpers/LanguageHelper.php`

```php
<?php

if (!function_exists('isPortuguese')) {
    function isPortuguese()
    {
        return app()->getLocale() === 'pt_BR';
    }
}

if (!function_exists('isEnglish')) {
    function isEnglish()
    {
        return app()->getLocale() === 'en_US';
    }
}
```

#### **5.2. Registrar no composer.json**

Adicione ao autoload:

```json
"autoload": {
    "files": [
        "app/Helpers/LanguageHelper.php"
    ]
}
```

Execute:
```bash
composer dump-autoload
```

---

### **ETAPA 6: Traduções dinâmicas (mensagens)**

#### **6.1. Mensagens de sessão**

**Antes:**
```php
return redirect()->with('success', 'Empresa criada com sucesso!');
```

**Depois:**
```php
return redirect()->with('success', __('companies.success'));
```

#### **6.2. Validações**

**Antes:**
```php
'name' => 'required|string|max:255'
```

**Depois:**
```php
'name' => ['required', 'string', 'max:255']
```

Com mensagens customizadas:
```php
'name.required' => __('companies.name_required'),
```

---

## 🚀 **CHECKLIST DE IMPLEMENTAÇÃO**

### **Configuração:**
- [ ] Configurar locale em `config/app.php`
- [ ] Criar middleware `SetLocale`
- [ ] Registrar middleware no Kernel

### **Traduções:**
- [ ] Criar arquivos `lang/pt_BR/companies.php`
- [ ] Criar arquivos `lang/en_US/companies.php`
- [ ] Criar arquivos `lang/pt_BR/reviews.php`
- [ ] Criar arquivos `lang/en_US/reviews.php`
- [ ] Criar arquivos `lang/pt_BR/dashboard.php`
- [ ] Criar arquivos `lang/en_US/dashboard.php`

### **Interface:**
- [ ] Adicionar selector de idioma no layout
- [ ] Criar rota `/change-locale`
- [ ] Adicionar JavaScript para trocar idioma

### **Views:**
- [ ] Traduzir `dashboard.blade.php`
- [ ] Traduzir `companies.blade.php`
- [ ] Traduzir `companies-create.blade.php`
- [ ] Traduzir `companies-edit.blade.php`
- [ ] Traduzir `admin/reviews/index.blade.php`
- [ ] Traduzir `public/review-page.blade.php`

---

## 💡 **ALTERNATIVA RÁPIDA**

Se quiser implementar de forma mais rápida, posso criar um pacote completo com:

1. ✅ Todos os arquivos de tradução
2. ✅ Middleware configurado
3. ✅ Selector de idioma
4. ✅ Helpers
5. ✅ Views traduzidas

**Digite:** "implementar agora" e eu faço tudo para você! 🚀

---

## 📝 **ESTRUTURA FINAL**

```
reviews-platform/
├── app/
│   └── Http/
│       └── Middleware/
│           └── SetLocale.php
├── lang/
│   ├── pt_BR/
│   │   ├── companies.php
│   │   ├── reviews.php
│   │   └── dashboard.php
│   └── en_US/
│       ├── companies.php
│       ├── reviews.php
│       └── dashboard.php
├── resources/
│   └── views/
│       └── layouts/
│           └── language-selector.blade.php
└── routes/
    └── web.php (rota change-locale adicionada)
```

---

**Tempo estimado:** 2-3 horas para implementação completa
**Dificuldade:** ⭐⭐ Média

