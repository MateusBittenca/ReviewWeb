# 👨‍💻 Guia de Desenvolvimento

## 📋 Visão Geral

Este guia é para desenvolvedores que querem contribuir ou modificar a Plataforma de Reviews.

## 🏗️ Arquitetura da Aplicação

### Estrutura do Backend (Laravel)

```
reviews-platform/
├── app/
│   ├── Console/Commands/     # Comandos Artisan customizados
│   ├── Http/Controllers/     # Controladores da aplicação
│   │   ├── Admin/           # Controladores do painel admin
│   │   └── Public/          # Controladores públicos
│   ├── Models/              # Modelos Eloquent
│   ├── Services/            # Lógica de negócio
│   └── Mail/                # Classes de email
├── database/
│   ├── migrations/          # Migrações do banco
│   └── seeders/             # Seeders para dados iniciais
├── resources/
│   └── views/               # Views Blade
└── routes/
    ├── web.php              # Rotas web
    └── admin.php            # Rotas do admin
```

### Estrutura do Frontend (React)

```
frontend/
├── src/
│   ├── components/          # Componentes React
│   │   ├── CompanyForm.jsx  # Formulário de empresas
│   │   ├── Dashboard.jsx   # Dashboard principal
│   │   ├── Layout.jsx      # Layout base
│   │   ├── ReviewPage.jsx  # Página de reviews
│   │   └── ReviewsList.jsx # Lista de reviews
│   ├── App.jsx             # Componente principal
│   └── main.jsx            # Ponto de entrada
├── index.html              # HTML base
└── vite.config.js          # Configuração do Vite
```

## 🔧 Configuração do Ambiente de Desenvolvimento

### 1. Clonar e Configurar

```bash
# Clonar repositório
git clone https://github.com/seu-usuario/reviews-platform.git
cd reviews-platform

# Instalar dependências PHP
composer install

# Instalar dependências Node.js
cd frontend
npm install
cd ..

# Configurar ambiente
cp .env.example .env
php artisan key:generate
```

### 2. Configurar Banco de Dados

```bash
# Criar banco de desenvolvimento
mysql -u root -p
CREATE DATABASE reviews_platform_dev;
EXIT;

# Configurar .env
DB_DATABASE=reviews_platform_dev

# Executar migrações
php artisan migrate
php artisan db:seed
```

### 3. Iniciar Servidores de Desenvolvimento

```bash
# Terminal 1 - Backend
php artisan serve

# Terminal 2 - Frontend
cd frontend
npm run dev
```

## 📝 Convenções de Código

### PHP (Laravel)

#### Estrutura de Controladores
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('reviews')->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Company::create($validated);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Empresa criada com sucesso!');
    }
}
```

#### Estrutura de Modelos
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo_url',
        'website',
        'email',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
```

#### Estrutura de Services
```php
<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Review;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReviewNotification;

class ReviewService
{
    public function createReview(array $data): Review
    {
        $review = Review::create($data);
        
        $this->notifyCompany($review);
        
        return $review;
    }

    private function notifyCompany(Review $review): void
    {
        if ($review->company->email) {
            Mail::to($review->company->email)
                ->send(new NewReviewNotification($review));
        }
    }
}
```

### React/JavaScript

#### Estrutura de Componentes
```jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';

const CompanyForm = ({ onSubmit, initialData = {} }) => {
    const [formData, setFormData] = useState({
        name: '',
        description: '',
        website: '',
        email: '',
        ...initialData
    });

    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState({});

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setErrors({});

        try {
            await onSubmit(formData);
        } catch (error) {
            if (error.response?.status === 422) {
                setErrors(error.response.data.errors);
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div>
                <label htmlFor="name" className="block text-sm font-medium">
                    Nome da Empresa
                </label>
                <input
                    type="text"
                    id="name"
                    value={formData.name}
                    onChange={(e) => setFormData({
                        ...formData,
                        name: e.target.value
                    })}
                    className="mt-1 block w-full rounded-md border-gray-300"
                    required
                />
                {errors.name && (
                    <p className="mt-1 text-sm text-red-600">{errors.name[0]}</p>
                )}
            </div>
            
            <button
                type="submit"
                disabled={loading}
                className="bg-blue-600 text-white px-4 py-2 rounded-md disabled:opacity-50"
            >
                {loading ? 'Salvando...' : 'Salvar'}
            </button>
        </form>
    );
};

export default CompanyForm;
```

#### Estrutura de Hooks Customizados
```jsx
import { useState, useEffect } from 'react';
import axios from 'axios';

export const useApi = (url, options = {}) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                setLoading(true);
                const response = await axios.get(url, options);
                setData(response.data);
            } catch (err) {
                setError(err);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [url]);

    return { data, loading, error };
};
```

## 🧪 Testes

### Testes PHP (PHPUnit)

```php
<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_company()
    {
        $admin = User::factory()->admin()->create();
        
        $companyData = [
            'name' => 'Empresa Teste',
            'description' => 'Descrição da empresa',
            'website' => 'https://empresa.com',
            'email' => 'contato@empresa.com',
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/companies', $companyData);

        $response->assertRedirect('/admin/companies');
        $this->assertDatabaseHas('companies', $companyData);
    }

    public function test_company_can_have_reviews()
    {
        $company = Company::factory()->create();
        $review = $company->reviews()->create([
            'name' => 'João Silva',
            'email' => 'joao@email.com',
            'rating' => 5,
            'comment' => 'Excelente serviço!',
        ]);

        $this->assertTrue($company->reviews->contains($review));
        $this->assertEquals(5, $company->average_rating);
    }
}
```

### Testes React (Jest + Testing Library)

```jsx
import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import CompanyForm from '../CompanyForm';

describe('CompanyForm', () => {
    const mockOnSubmit = jest.fn();

    beforeEach(() => {
        mockOnSubmit.mockClear();
    });

    it('renders form fields correctly', () => {
        render(<CompanyForm onSubmit={mockOnSubmit} />);
        
        expect(screen.getByLabelText(/nome da empresa/i)).toBeInTheDocument();
        expect(screen.getByRole('button', { name: /salvar/i })).toBeInTheDocument();
    });

    it('submits form with correct data', async () => {
        render(<CompanyForm onSubmit={mockOnSubmit} />);
        
        fireEvent.change(screen.getByLabelText(/nome da empresa/i), {
            target: { value: 'Empresa Teste' }
        });
        
        fireEvent.click(screen.getByRole('button', { name: /salvar/i }));
        
        await waitFor(() => {
            expect(mockOnSubmit).toHaveBeenCalledWith({
                name: 'Empresa Teste',
                description: '',
                website: '',
                email: '',
            });
        });
    });
});
```

## 🔄 Fluxo de Desenvolvimento

### 1. Criar Branch

```bash
# Criar nova branch
git checkout -b feature/nova-funcionalidade

# Ou para correção de bug
git checkout -b fix/corrigir-bug
```

### 2. Desenvolver Feature

```bash
# Fazer alterações no código
# Executar testes
php artisan test
npm test

# Commit das alterações
git add .
git commit -m "feat: adicionar funcionalidade X"
```

### 3. Criar Pull Request

```bash
# Push da branch
git push origin feature/nova-funcionalidade

# Criar PR no GitHub/GitLab
```

### 4. Code Review

- Revisar código
- Executar testes
- Verificar documentação
- Aprovar merge

## 📊 Debugging

### Laravel

```php
// Usar dd() para debug
dd($variable);

// Usar Log para debug
Log::info('Debug info', ['data' => $data]);

// Usar Tinker para debug interativo
php artisan tinker
```

### React

```jsx
// Usar console.log
console.log('Debug info:', data);

// Usar debugger
debugger;

// Usar React DevTools
// Instalar extensão do navegador
```

## 🚀 Deploy de Desenvolvimento

### Ambiente Local

```bash
# Usar Laravel Sail (Docker)
composer require laravel/sail --dev
php artisan sail:install
./vendor/bin/sail up -d

# Ou usar ambiente tradicional
php artisan serve
cd frontend && npm run dev
```

### Ambiente de Staging

```bash
# Deploy automático com GitHub Actions
# Ver arquivo .github/workflows/deploy.yml
```

## 📚 Recursos Úteis

### Documentação
- [Laravel Documentation](https://laravel.com/docs)
- [React Documentation](https://react.dev)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Vite Documentation](https://vitejs.dev/guide)

### Ferramentas
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [React DevTools](https://react.dev/learn/react-developer-tools)
- [Postman](https://www.postman.com/) - Para testar APIs
- [Insomnia](https://insomnia.rest/) - Alternativa ao Postman

### Extensões VS Code
- PHP Intelephense
- Laravel Blade Snippets
- ES7+ React/Redux/React-Native snippets
- Tailwind CSS IntelliSense
- GitLens

---

**💡 Dica:** Sempre escreva testes para suas funcionalidades e mantenha a documentação atualizada!
