# 🎨 Plano de Implementação: Mocks Figma

**Objetivo:** Criar documentação visual completa do projeto no Figma  
**Tempo Estimado:** 2-3 horas  
**Prioridade:** BAIXA (opcional, documentação visual)

---

## 📋 O QUE SERIA CRIADO

### 1. ESTRUTURA DE ARQUIVOS FIGMA

#### Organização Proposta:
```
Reviews Platform - Design System
├── 🎨 Design System
│   ├── Colors
│   │   ├── Primary (Roxo)
│   │   ├── Secondary (Rosa)
│   │   ├── Success (Verde)
│   │   ├── Error (Vermelho)
│   │   └── Neutrals (Cinzas)
│   ├── Typography
│   │   ├── Font Family (Inter)
│   │   ├── Headings (H1-H6)
│   │   ├── Body Text
│   │   └── Labels
│   ├── Spacing
│   │   ├── 4px Grid System
│   │   ├── Padding System
│   │   └── Margin System
│   ├── Shadows
│   │   ├── Shadow-sm
│   │   ├── Shadow-md
│   │   └── Shadow-lg
│   └── Components
│       ├── Buttons (Primary, Secondary, Tertiary)
│       ├── Cards (Default, Hover, Active)
│       ├── Inputs (Text, Email, Phone, Textarea)
│       ├── Select (Dropdown)
│       └── Badges (Success, Warning, Error, Info)
│
├── 📱 Pages (Desktop)
│   ├── 01 - Login
│   ├── 02 - Dashboard
│   ├── 03 - Companies List
│   ├── 04 - Companies Create
│   ├── 05 - Reviews Dashboard
│   └── 06 - Public Review Page
│
├── 📱 Pages (Mobile)
│   ├── 01 - Login (Mobile)
│   ├── 02 - Dashboard (Mobile)
│   ├── 03 - Companies List (Mobile)
│   └── 04 - Public Review Page (Mobile)
│
└── 🎭 States & Variants
    ├── Button States
    ├── Input States
    ├── Card States
    └── Form States
```

---

## 🎨 COMPONENTES QUE SERIAM CRIADOS

### 1. Design System (Figma Component Library)

#### 1.1 Cores (Color Styles)
```
Primary Colors:
- Purple 500: #8B5CF6
- Purple 600: #7C3AED
- Pink 500: #EC4899
- Pink 600: #DB2777

State Colors:
- Success: #10B981
- Error: #EF4444
- Warning: #FBBF24
- Info: #3B82F6

Neutral Colors:
- Gray 50: #F9FAFB
- Gray 100: #F3F4F6
- Gray 200: #E5E7EB
- Gray 800: #1F2937
- Gray 900: #111827
```

#### 1.2 Tipografia (Text Styles)
```
Headings:
- H1: Inter, Bold, 48px
- H2: Inter, Bold, 36px
- H3: Inter, SemiBold, 30px

Body:
- Large: Inter, Regular, 18px
- Base: Inter, Regular, 16px
- Small: Inter, Regular, 14px

Labels:
- Label: Inter, Medium, 12px
- Caption: Inter, Regular, 10px
```

#### 1.3 Espaçamento (Auto Layout)
```
Padding System:
- xs: 4px
- sm: 8px
- md: 16px
- lg: 24px
- xl: 32px

Gap System:
- xs: 8px
- sm: 16px
- md: 24px
- lg: 32px
```

#### 1.4 Sombras (Effect Styles)
```
Shadow-sm: 0 1px 2px rgba(0,0,0,0.05)
Shadow-md: 0 4px 6px rgba(0,0,0,0.1)
Shadow-lg: 0 10px 15px rgba(0,0,0,0.1)
```

---

### 2. Componentes Base (Auto Layout + Variants)

#### 2.1 Buttons
```figma
Properties:
- Variant: Primary | Secondary | Tertiary
- Size: Small | Medium | Large
- State: Default | Hover | Active | Disabled | Loading

Features:
- Auto Layout (Padding: 12px 24px)
- Icon Slot (Left | Right)
- Shadow on hover
- Transform on click
```

**Variants Exemplos:**
```
[Primary, Medium, Default]
[Primary, Medium, Hover]
[Primary, Medium, Disabled]
[Secondary, Large, Default]
[Tertiary, Small, Default]
```

#### 2.2 Cards
```figma
Properties:
- Variant: Default | Hover | Active
- Size: Small | Medium | Large

Features:
- Auto Layout (Padding: 24px)
- Corner Radius: 12px
- Border: 1px gray
- Shadow system
- Hover elevation (+2px shadow)
```

#### 2.3 Inputs
```figma
Properties:
- Variant: Text | Email | Phone | Textarea
- State: Default | Focus | Error | Disabled
- Size: Medium | Large

Features:
- Auto Layout
- Placeholder text
- Error message slot
- Icon support (prefix | suffix)
```

**Variants:**
```
[Text, Default, Medium]
[Text, Focus, Medium]
[Text, Error, Medium]
[Textarea, Default, Medium]
```

#### 2.4 Badges
```figma
Properties:
- Variant: Success | Warning | Error | Info
- Size: Small | Medium

Features:
- Auto Layout
- Icon support
- Pill shape
- Pulse animation (para alertas)
```

---

### 3. Páginas Completas

#### 3.1 Login
```
Canvas: Desktop (1920x1080)
Components:
- Background gradient
- Centered card
- Logo (Reviews Platform)
- Form inputs (Email, Password)
- Button (Entrar)
- Footer links

States:
- Default
- Error (validation)
- Loading
```

#### 3.2 Dashboard
```
Canvas: Desktop (1920x1080)
Layout:
- Sidebar (Fixed, 256px)
- Main Content Area
- Grid Cards (3 columns)
- Stats Section

Components:
- Sidebar Navigation
- Profile Section
- 9 Action Cards
- Badge de Negativas (Top Right)
- Alert Banner (quando há negativas)
```

**Responsive Breakpoints:**
- Desktop: 1920px
- Tablet: 768px
- Mobile: 375px

#### 3.3 Companies List
```
Components:
- Table Header
- Company Cards
- Status Badges (Published | Draft)
- Action Buttons
- Search/Filter Bar
- Pagination
```

#### 3.4 Create Company Form
```
Components:
- Multi-step Progress
- Form Sections
- Upload Zones
- Sliders
- Validation States
```

#### 3.5 Reviews Dashboard
```
Components:
- Filter Sidebar
- Stats Cards (4 cards)
- Charts (Line + Pie)
- Review List
- Export Button
```

#### 3.6 Public Review Page
```
Components:
- Hero Section (Gradient + Background)
- Logo Section
- Rating Stars
- Form Inputs
- Language Selector
- Footer

States:
- Before review
- After positive review (Google redirect)
- After negative review (Feedback form)
```

---

## 🎭 ESTADOS E VARIAÇÕES

### Button States
```
Default → Hover → Active → Disabled
         ↓
      Loading (spinner)
```

### Card States
```
Default → Hover (elevate) → Active (selected)
```

### Form States
```
Empty → Filled → Valid → Error
```

### Review Page States
```
Initial → Filled → Submitting → Success (redirect)
                      ↓
                  Error (try again)
```

---

## 📱 RESPONSIVE BREAKPOINTS

### Desktop (1920px)
- Layout completo
- Sidebar fixa
- Grid 3 colunas
- Todas funcionalidades

### Tablet (768px)
- Sidebar colapsável
- Grid 2 colunas
- Cards menores

### Mobile (375px)
- Sidebar hamburger menu
- Grid 1 coluna
- Stack vertical
- Touch-optimized

---

## 🔗 INTEGRAÇÃO E EXPORTAÇÃO

### 1. Tokens Sync
```javascript
// Figma Plugin para sincronizar com código
import 'figma-tokens-api';

// Exportar tokens
figma.variables
  .getLocalVariables()
  .exportToJSON('design-tokens.json');
```

### 2. Component Export
```figma
// Export como SVG/PNG
frames.forEach(frame => {
  exportPNG(frame, {
    resolution: '@2x',
    format: 'PNG'
  });
});
```

### 3. HTML/CSS Export
```figma
// Usar plugin "Figma to HTML"
// Gera código CSS das propriedades
```

---

## 📚 ESPECIFICAÇÕES TÉCNICAS

### 1. Component API
```typescript
interface ButtonProps {
  variant: 'primary' | 'secondary' | 'tertiary';
  size: 'sm' | 'md' | 'lg';
  state: 'default' | 'hover' | 'active' | 'disabled' | 'loading';
  icon?: Icon;
  iconPosition?: 'left' | 'right';
}

interface CardProps {
  variant: 'default' | 'hover' | 'active';
  shadow: 'sm' | 'md' | 'lg';
  padding: 'md' | 'lg';
}

interface InputProps {
  type: 'text' | 'email' | 'phone' | 'textarea';
  state: 'default' | 'focus' | 'error' | 'disabled';
  placeholder: string;
  label?: string;
  error?: string;
}
```

### 2. Auto Layout
```
All components use Auto Layout with:
- Padding: Consistent spacing
- Gap: 8px, 16px, 24px, 32px
- Align: Left/Center/Right
- Wrap: Smart wrap
```

### 3. Constraints
```
Sidebar:
- Horizontal: Left
- Vertical: Top + Bottom

Main Content:
- Horizontal: Left + Right
- Vertical: Top + Bottom

Cards:
- Horizontal: Left + Right
- Vertical: Top
```

---

## 🎯 BENEFÍCIOS

### Para Desenvolvedores
- ✅ Ver exatamente como implementar
- ✅ Especificações visuais precisas
- ✅ Medidas e espaçamentos corretos
- ✅ Cores e tipografia definidas

### Para Designers
- ✅ Asset library reutilizável
- ✅ Design consistente
- ✅ Variants para todos estados
- ✅ Fácil manutenção

### Para Clientes
- ✅ Mockups visuais do produto
- ✅ Protótipos interativos
- ✅ Apresentação profissional
- ✅ Documentação visual

---

## 📦 ENTREGÁVEIS

### 1. Arquivo Figma
```
Reviews-Platform-Design-System.fig
├── Design System
├── Components Library
├── Pages (Desktop)
├── Pages (Mobile)
└── Documentation
```

### 2. Assets Exports
```
exports/
├── icons/ (SVG)
├── logos/ (PNG @2x)
├── screenshots/ (PNG @1x)
└── tokens/ (JSON)
```

### 3. Especificações
```
specs/
├── components.md
├── colors.md
├── typography.md
└── spacing.md
```

---

## ⏱️ CRONOGRAMA ESTIMADO

### Fase 1: Design System (1h)
- [ ] Cores e Tokens
- [ ] Tipografia
- [ ] Espaçamento
- [ ] Sombras e Efeitos

### Fase 2: Componentes Base (45min)
- [ ] Buttons (3 variants × 3 sizes × 5 states)
- [ ] Cards (3 states)
- [ ] Inputs (4 types × 4 states)
- [ ] Badges (4 variants)

### Fase 3: Páginas (1h)
- [ ] Login
- [ ] Dashboard
- [ ] Companies List
- [ ] Create Company
- [ ] Reviews Dashboard
- [ ] Public Review Page

### Fase 4: Documentação (15min)
- [ ] README do Figma
- [ ] Component specs
- [ ] Export assets

**Total:** ~3 horas

---

## ✅ CONCLUSÃO

Criar mocks Figma seria criar:

1. **Design System completo** com tokens
2. **Biblioteca de componentes** reutilizáveis
3. **Todas as páginas** em versões Desktop e Mobile
4. **Estados e variações** de cada componente
5. **Documentação técnica** com specs
6. **Exports** para uso no código

**Benefício Principal:** Visualização profissional do projeto para clientes e documentação técnica para desenvolvedores.

---

**Status:** Opcional (documentação visual)  
**Prioridade:** Baixa  
**Valor:** Alto (apresentação profissional)
