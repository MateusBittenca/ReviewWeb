# Sistema de Design - Reviews Platform

Este documento descreve o sistema de design unificado implementado para manter consistência visual em todo o projeto.

## 🎨 Paleta de Cores

### Cores Principais
```css
--primary-color: #8b5cf6      /* Roxo principal */
--primary-dark: #7c3aed       /* Roxo escuro */
--secondary-color: #ec4899    /* Rosa secundário */
--secondary-dark: #db2777     /* Rosa escuro */
```

### Gradientes
```css
--primary-gradient: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
--sidebar-gradient: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
--icon-gradient: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
```

### Cores de Estado
- **Sucesso**: `#10b981` (Verde)
- **Erro**: `#ef4444` (Vermelho)
- **Aviso**: `#fbbf24` (Amarelo)
- **Info**: `#3b82f6` (Azul)

## 📐 Layout

### Estrutura de Páginas Administrativas
Todas as páginas administrativas usam o layout base `layouts/admin.blade.php`:

```blade
@extends('layouts.admin')

@section('title', 'Título da Página')
@section('page-title', 'Título Principal')
@section('page-description', 'Descrição da página')

@section('header-actions')
    <!-- Botões de ação no cabeçalho -->
@endsection

@section('content')
    <!-- Conteúdo da página -->
@endsection

@section('scripts')
    <!-- Scripts JavaScript específicos -->
@endsection
```

### Sidebar
- **Largura**: 256px (w-64)
- **Background**: Gradiente claro (#f8fafc → #f1f5f9)
- **Logo**: Ícone com gradiente roxo/rosa em container 40x40px
- **Items de Navegação**: 
  - Estado normal: Texto cinza (#374151)
  - Hover: Background roxo claro com texto roxo
  - Ativo: Background roxo mais forte + borda lateral roxa

## 🎯 Componentes

### Botões

#### Botão Primário
```html
<button class="btn-primary text-white px-4 py-2 rounded-lg font-medium">
    <i class="fas fa-icon mr-2"></i>
    Texto do Botão
</button>
```
- Background: Gradiente roxo/rosa
- Hover: Eleva 2px com sombra roxa
- Transição: 0.3s

#### Botão Secundário
```html
<button class="btn-secondary text-white px-4 py-2 rounded-lg font-medium">
    Texto
</button>
```
- Background: Cinza (#6b7280)
- Hover: Cinza mais escuro (#4b5563)

### Cards

#### Card Padrão
```html
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
    <!-- Conteúdo -->
</div>
```
- Background: Branco
- Border: Cinza claro
- Border Radius: 12px (rounded-xl)
- Hover: Eleva 2px com sombra

#### Card com Ícone
```html
<div class="flex items-center mb-4">
    <div class="w-12 h-12 icon-gradient rounded-lg flex items-center justify-center mr-4">
        <i class="fas fa-icon text-white text-xl"></i>
    </div>
    <div>
        <h3 class="font-semibold text-gray-800">Título</h3>
        <p class="text-sm text-gray-600">Descrição</p>
    </div>
</div>
```

### Formulários

#### Input de Texto
```html
<input 
    type="text" 
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
    placeholder="Placeholder"
>
```

#### Textarea
```html
<textarea 
    rows="3"
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
></textarea>
```

#### Select
```html
<select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
    <option>Opção</option>
</select>
```

### Notificações

#### Sucesso
```html
<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>Mensagem de sucesso</span>
    </div>
</div>
```

#### Erro
```html
<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span>Mensagem de erro</span>
    </div>
</div>
```

## 🎭 Animações

### Fade In
```css
.fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```

### Card Hover
```css
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
```

## 📱 Responsividade

### Breakpoints (Tailwind)
- **SM**: 640px
- **MD**: 768px
- **LG**: 1024px
- **XL**: 1280px

### Grid Responsivo
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Cards -->
</div>
```

## 🎨 Ícones

### Font Awesome 6.4.0
Todos os ícones usam Font Awesome:
```html
<i class="fas fa-icon-name"></i>    <!-- Solid -->
<i class="far fa-icon-name"></i>    <!-- Regular -->
<i class="fab fa-icon-name"></i>    <!-- Brands -->
```

### Ícones Comuns
- **Dashboard**: `fa-home`
- **Empresas**: `fa-building`
- **Avaliações**: `fa-star`
- **Configurações**: `fa-cog`
- **Adicionar**: `fa-plus`
- **Editar**: `fa-edit`
- **Excluir**: `fa-trash`
- **Visualizar**: `fa-eye`
- **Exportar**: `fa-download`

## 📝 Tipografia

### Font Family
```css
font-family: 'Inter', sans-serif;
```

### Tamanhos de Fonte
- **Texto pequeno**: `text-xs` (0.75rem)
- **Texto normal**: `text-sm` (0.875rem)
- **Texto médio**: `text-base` (1rem)
- **Texto grande**: `text-lg` (1.125rem)
- **Título**: `text-xl` (1.25rem)
- **Título grande**: `text-2xl` (1.5rem)
- **Título principal**: `text-3xl` (1.875rem)

### Pesos de Fonte
- **Normal**: `font-normal` (400)
- **Médio**: `font-medium` (500)
- **Semibold**: `font-semibold` (600)
- **Bold**: `font-bold` (700)

## 🚀 Páginas Especiais

### Login
- Usa gradiente azul/roxo diferente: `#667eea` → `#764ba2`
- Layout centralizado sem sidebar
- Formas flutuantes animadas no fundo
- Design mais "público" e convidativo

### Review Page (Página Pública)
- Hero section com gradiente azul/roxo
- Formas flutuantes animadas
- Layout sem sidebar
- Design focado na experiência do cliente
- Cores e gradientes similares ao login para manter consistência nas páginas públicas

## 📋 Checklist de Implementação

Ao criar uma nova página administrativa:

- [ ] Estende `layouts/admin.blade.php`
- [ ] Define título da página
- [ ] Define título e descrição do header
- [ ] Adiciona ações no header se necessário
- [ ] Usa classes CSS padronizadas (btn-primary, card-hover, etc.)
- [ ] Usa paleta de cores definida
- [ ] Adiciona animações fade-in para melhor UX
- [ ] Implementa estados de loading/empty/error
- [ ] Usa ícones Font Awesome consistentes
- [ ] Testa responsividade em diferentes tamanhos de tela

## 🎯 Boas Práticas

1. **Sempre use o layout base** para páginas administrativas
2. **Mantenha a paleta de cores** definida neste documento
3. **Use gradientes consistentes** (roxo/rosa para elementos principais)
4. **Adicione animações suaves** para melhor experiência
5. **Implemente estados de feedback** (loading, success, error)
6. **Teste em diferentes dispositivos** antes de finalizar
7. **Use ícones apropriados** e consistentes
8. **Mantenha espaçamento padronizado** (gap-6, p-6, mb-6)
9. **Implemente hover states** em elementos interativos
10. **Use notificações do sistema** para feedback ao usuário

## 📚 Recursos

- **Tailwind CSS**: https://tailwindcss.com/docs
- **Font Awesome**: https://fontawesome.com/icons
- **Google Fonts (Inter)**: https://fonts.google.com/specimen/Inter
- **Chart.js**: https://www.chartjs.org/docs/

## 🔄 Atualizações

**Versão 1.0** - Implementação inicial do sistema de design unificado
- Layout base criado
- Paleta de cores definida
- Componentes padronizados
- Animações implementadas
- Todas as páginas administrativas atualizadas

---

**Mantido por**: Equipe Reviews Platform  
**Última atualização**: Outubro 2024

