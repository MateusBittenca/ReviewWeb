# 🎨 Guia de Implementação - Componentes Figma

Este documento fornece especificações detalhadas para recriar os componentes no Figma.

---

## 📥 ARQUIVOS FORNECIDOS

### 1. `design-tokens.json`
**Conteúdo:** Tokens de design completos  
**Uso:** Importar no Figma usando plugin "Figma Tokens"  
**O que contém:** Cores, tipografia, espaçamento, sombras, breakpoints

### 2. `component-specs.json`
**Conteúdo:** Especificações técnicas dos componentes  
**Uso:** Referência para criar componentes no Figma  
**O que contém:** Dimensões, cores, estados, variantes

### 3. `component-library.html`
**Conteúdo:** Biblioteca de componentes funcionais  
**Uso:** Visualizar componentes antes de criar no Figma  
**O que contém:** Exemplos visuais de todos os componentes

---

## 🔧 COMO CRIAR NO FIGMA

### Passo 1: Importar Tokens
1. Instalar plugin **"Figma Tokens"**
2. Selecionar: Plugin → Import Tokens
3. Upload do arquivo `design-tokens.json`
4. Tokens ficarão disponíveis como variáveis

### Passo 2: Criar Estilos de Cores
Para cada cor em `design-tokens.json`:

```
1. Crie um retângulo
2. Altere a cor de preenchimento
3. Clique nos 3 pontinhos ao lado da cor
4. Selecione "Add style"
5. Nomeie conforme: "Color/Primary/500"
```

**Cores principais:**
- Primary 500: #8b5cf6
- Primary 600: #7c3aed
- Secondary 500: #ec4899
- Success 500: #10b981
- Error 500: #ef4444

### Passo 3: Criar Estilos de Texto
Para cada tamanho em `typography`:

```
1. Crie um texto
2. Aplique fonte "Inter"
3. Configure tamanho, weight, line-height
4. Clique nos 3 pontinhos
5. Selecione "Add style"
6. Nomeie: "Text/H1" ou "Text/Body"
```

**Hierarquia de texto:**
- H1: Inter Bold, 48px
- H2: Inter Bold, 36px
- H3: Inter SemiBold, 30px
- Body: Inter Regular, 16px

### Passo 4: Criar Componente Button

#### Propriedades:
- **Variant:** Primary | Secondary | Tertiary
- **Size:** Small | Medium | Large
- **State:** Default | Hover | Active | Disabled | Loading

#### Dimensões:
- **Small:** Padding 8px 16px, Height 32px
- **Medium:** Padding 12px 24px, Height 40px
- **Large:** Padding 16px 32px, Height 48px

#### Criação no Figma:
1. Desenhe um retângulo (Auto Layout ON)
2. Configure padding conforme size
3. Adicione corner radius: 8px
4. Aplique cor conforme variant
5. Adicione texto "Button"
6. Configure Auto Layout:
   - Direction: Horizontal
   - Padding: Variável conforme size
   - Gap: 8px
7. Crie variants:
   - Property 1: Variant (3 opções)
   - Property 2: Size (3 opções)
   - Property 3: State (5 opções)

**Estados de hover/active:**
- Hover: +2px Y position, +shadow
- Active: -2px Y position
- Disabled: Opacity 50%
- Loading: Adicionar spinner icon

---

### Passo 5: Criar Componente Card

#### Propriedades:
- **Variant:** Default | Hover | Active

#### Dimensões:
- Padding: 24px
- Border Radius: 12px
- Border: 1px, cor #e5e7eb

#### Criação no Figma:
1. Desenhe um retângulo
2. Configure padding: 24px (Auto Layout ON)
3. Corner radius: 12px
4. Border: 1px #e5e7eb
5. Shadow: 0 1px 2px rgba(0,0,0,0.05)
6. Crie variants:
   - Default
   - Hover (elevation +2px, shadow +10px)
   - Active (borda roxa)

---

### Passo 6: Criar Componente Input

#### Propriedades:
- **Type:** Text | Email | Phone | Textarea
- **State:** Default | Focus | Error | Disabled

#### Dimensões:
- Height: 48px
- Border Radius: 8px
- Padding: 12px 16px

#### Criação no Figma:
1. Desenhe retângulo
2. Border: 1px #d1d5db
3. Corner radius: 8px
4. Padding: 12px 16px
5. Adicione placeholder text
6. Crie variants:
   - Default: border gray
   - Focus: border purple + ring
   - Error: border red + error message
   - Disabled: opacity 50%

---

### Passo 7: Criar Componente Badge

#### Propriedades:
- **Variant:** Success | Warning | Error | Info | Alert
- **Size:** Small | Medium

#### Dimensões:
- **Small:** Padding 4px 12px, Height 24px
- **Medium:** Padding 6px 16px, Height 28px

#### Criação no Figma:
1. Desenhe retângulo com corner radius: 999px (pill)
2. Configure Auto Layout
3. Adicione ícone (opcional)
4. Adicione número (para alertas)
5. Crie variants conforme cores

---

### Passo 8: Criar Layouts Completos

#### Dashboard:
1. Criar frame: 1920x1080
2. Sidebar: 256px width, full height
3. Main area: resto do espaço
4. Grid: 3 colunas, gap 24px
5. Preencher com cards

#### Mobile (375px):
1. Criar frame: 375x812
2. Stack vertical
3. Sidebar → Hamburger menu
4. Cards full width

---

## 📐 ESPECIFICAÇÕES TÉCNICAS

### Grid System
```
Container: Max 1280px
Gutter: 24px
Columns: 12 (desktop) | 8 (tablet) | 4 (mobile)
```

### Spacing Scale (8px base)
```
0.5: 4px
1: 8px
2: 16px
3: 24px
4: 32px
5: 40px
6: 48px
```

### Corner Radius
```
sm: 4px
md: 8px
lg: 12px
xl: 16px
full: 9999px
```

---

## 🎨 AUTOMATIZAÇÃO

### Exportar de Figma para Código

#### Usando Plugin "Figma to React":
1. Selecionar componente
2. Plugin → "Figma to React"
3. Copiar código gerado

#### Usando Plugin "HTML/CSS to Figma":
1. Abrir `component-library.html`
2. Copiar HTML
3. Plugin → Paste as Figma

---

## ✅ CHECKLIST DE CRIAÇÃO

### Design System
- [ ] Importar tokens JSON
- [ ] Criar estilos de cores (50+ variantes)
- [ ] Criar estilos de texto (todos os tamanhos)
- [ ] Criar estilos de efeitos (shadows)
- [ ] Criar estilos de espaçamento

### Componentes Base
- [ ] Button (45 variants: 3×3×5)
- [ ] Card (3 variants)
- [ ] Input (16 variants: 4×4)
- [ ] Badge (10 variants: 5×2)
- [ ] Sidebar
- [ ] Form elements

### Páginas
- [ ] Login
- [ ] Dashboard
- [ ] Companies List
- [ ] Create Company
- [ ] Reviews Dashboard
- [ ] Public Review Page

### Responsive
- [ ] Mobile versions
- [ ] Tablet versions
- [ ] Desktop versions

---

## 🚀 RESULTADO FINAL

### Arquivo Figma Criado:
```
Reviews-Platform.fig
├── 🎨 Design System
│   ├── Colors (50+)
│   ├── Typography (20+)
│   ├── Shadows (4)
│   └── Effects
├── 🧩 Components
│   ├── Buttons (45)
│   ├── Cards (3)
│   ├── Inputs (16)
│   └── More...
├── 📱 Pages
│   ├── Desktop (6)
│   └── Mobile (4)
└── 📚 Documentation
    └── README.md
```

---

## 📚 RECURSOS ÚTEIS

### Plugins Figma Recomendados:
- **Figma Tokens** - Importar tokens JSON
- **Figma to React** - Export para código
- **Content Reel** - Gerar conteúdo
- **Unsplash** - Imagens
- **Iconify** - Ícones

### Outros Recursos:
- **Component Library HTML:** Visualizar antes de criar
- **JSON Tokens:** Import direto no Figma
- **Especificações:** Dimensões precisas

---

**Status:** Arquivos prontos para importação  
**Próximo Passo:** Abrir Figma e começar a criar!

---

**Criado em:** 26/10/2025  
**Versão:** 1.0
