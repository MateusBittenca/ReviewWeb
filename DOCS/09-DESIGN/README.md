# 🎨 09 - Design

Documentação sobre design system e UX implementada.

## 📁 Documentos

- **DESIGN_SYSTEM.md** - Sistema de design completo
- **SUGESTOES_DESIGN_UX.md** - Sugestões de UX
- **ANALISE_PADROES_FIGMA.md** - Análise comparativa com Figma
- **PLANO_MOCKS_FIGMA.md** - Plano de implementação Figma
- **FIGMA_IMPLEMENTATION_GUIDE.md** - Guia passo a passo

## 🎯 Conteúdo

### Design System
- **Cores** - Paleta de cores
- **Tipografia** - Fontes e tamanhos
- **Componentes** - Botões, cards, inputs
- **Espaçamento** - Grids e margins

### UX
- **Fluxos** - Jornadas do utilizador
- **Padrões** - Padrões de interface
- **Acessibilidade** - Boas práticas
- **Responsividade** - Mobile-first

## 🎨 Paleta de Cores

- **Primary:** Roxo (#8B5CF6)
- **Secondary:** Rosa (#EC4899)
- **Success:** Verde (#10B981)
- **Warning:** Amarelo (#F59E0B)
- **Error:** Vermelho (#EF4444)
- **Info:** Azul (#3B82F6)

## 📐 Grid System

Tailwind CSS configurado com:
- Container máximo: 1280px
- Breakpoints: sm, md, lg, xl
- Gaps: 4, 8, 16, 24

## 📦 Arquivos Figma Prontos

### design-tokens.json
**Descrição:** Tokens de design completos exportáveis  
**Uso:** Importar no Figma via plugin "Figma Tokens"  
**Conteúdo:** Cores, tipografia, espaçamento, shadows, breakpoints

### component-specs.json
**Descrição:** Especificações técnicas dos componentes  
**Uso:** Referência para criar variantes no Figma  
**Conteúdo:** Dimensões, propriedades, estados

### component-library.html
**Descrição:** Biblioteca visual de componentes  
**Uso:** Abrir no navegador para ver componentes  
**Conteúdo:** Todos os componentes renderizados

## 🔧 Como Usar

### Para Criar Mocks no Figma:

1. **Instalar plugin** "Figma Tokens"
2. **Importar** `design-tokens.json`
3. **Visualizar** `component-library.html` para referência
4. **Seguir** `FIGMA_IMPLEMENTATION_GUIDE.md` passo a passo

### Para Ver Componentes:
```bash
# Abrir no navegador
documentacoes/09-DESIGN/component-library.html
```

## 📊 Componentes Disponíveis

### Base Components
- ✅ Button (3 variants × 3 sizes × 5 states)
- ✅ Card (3 states)
- ✅ Input (4 types × 4 states)
- ✅ Badge (5 variants)
- ✅ Sidebar
- ✅ Form elements

### Page Components
- ✅ Dashboard
- ✅ Login
- ✅ Companies List
- ✅ Create Company
- ✅ Reviews Dashboard
- ✅ Public Review Page

## 📚 Mais Informações

- **DESIGN_SYSTEM.md** - Sistema completo
- **FIGMA_IMPLEMENTATION_GUIDE.md** - Como criar no Figma
- **ANALISE_PADROES_FIGMA.md** - Comparação com padrões

---

**Última Atualização:** 26/10/2025