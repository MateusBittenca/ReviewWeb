# 🚀 Guia Rápido - Gerenciamento de Usuários

## Como Começar

### 1️⃣ Acesse o Dashboard
1. Abra o navegador e acesse: `http://localhost:8000/login`
2. Faça login com suas credenciais de administrador

**Se você ainda não tem um usuário admin**, crie um acessando:
```
http://localhost:8000/create-admin
```

**Credenciais padrão criadas:**
- Email: `admin@reviewsplatform.com`
- Senha: `admin123`

### 2️⃣ Acesse o Gerenciamento de Usuários
1. No menu lateral esquerdo, procure a seção **CONFIGURAÇÕES**
2. Clique em **"Usuários"** (ícone de pessoas)
3. Você verá a lista de todos os usuários cadastrados

### 3️⃣ Criar um Novo Usuário

**Passo a passo:**
1. Clique no botão **"Novo Usuário"** (roxo, canto superior direito)
2. Preencha o formulário:
   - **Nome**: Digite o nome completo
   - **Email**: Digite um email válido (será usado para login)
   - **Função**: Escolha:
     - 🔷 **Administrador**: Acesso total (pode criar usuários)
     - 🔷 **Usuário**: Acesso limitado (não pode criar usuários)
   - **Senha**: Mínimo 6 caracteres
   - **Confirmar Senha**: Digite a mesma senha novamente
3. Clique em **"Criar Usuário"**
4. Pronto! O usuário foi criado ✅

### 4️⃣ Editar um Usuário

**Passo a passo:**
1. Na lista de usuários, localize o usuário desejado
2. Clique no botão azul **"Editar"**
3. Modifique as informações desejadas:
   - Nome
   - Email
   - Função (Admin/Usuário)
   - Senha (deixe em branco se não quiser alterar)
4. Clique em **"Salvar Alterações"**
5. Pronto! As informações foram atualizadas ✅

### 5️⃣ Excluir um Usuário

**Passo a passo:**
1. Na lista de usuários, localize o usuário desejado
2. Clique no botão vermelho **"Excluir"**
3. Confirme a exclusão no diálogo que aparecer
4. Pronto! O usuário foi removido ✅

**⚠️ Atenção:**
- Você **não pode** excluir sua própria conta
- Você **não pode** excluir o último administrador do sistema

## 📊 Entendendo o Dashboard

### Cartões de Estatísticas
No topo da página, você verá 3 cartões:

1. **Total de Usuários** (Roxo)
   - Mostra quantos usuários existem no total

2. **Administradores** (Azul)
   - Mostra quantos administradores existem

3. **Usuários Padrão** (Verde)
   - Mostra quantos usuários comuns existem

### Tabela de Usuários
A tabela mostra:
- 👤 **Avatar**: Iniciais do nome
- 📧 **Email**: Email de login
- 🏷️ **Função**: Badge mostrando se é Admin ou Usuário
- 📅 **Criado em**: Data de criação da conta
- 🎯 **Ações**: Botões de Editar e Excluir

## 🔐 Diferença entre Admin e Usuário

### Administrador (Admin)
✅ Pode criar, editar e excluir usuários  
✅ Pode gerenciar empresas  
✅ Pode ver todas as avaliações  
✅ Pode ver avaliações negativas  
✅ Acesso total ao sistema  

### Usuário Padrão (User)
❌ **NÃO** pode criar, editar ou excluir usuários  
✅ Pode gerenciar empresas  
✅ Pode ver avaliações  
✅ Acesso limitado ao sistema  

## ⚡ Dicas Rápidas

### Senhas Seguras
- Use no mínimo 6 caracteres (recomendado: 8+)
- Misture letras maiúsculas e minúsculas
- Adicione números e caracteres especiais
- Exemplo: `Senha123!`

### Editando sua Própria Conta
Você **pode** editar sua própria conta, mas tome cuidado:
- ⚠️ Se você remover seus privilégios de Admin, **não poderá recuperá-los sozinho**
- ⚠️ Você **não pode** excluir sua própria conta

### Recuperando Senhas
Para alterar a senha de um usuário:
1. Vá em **Editar Usuário**
2. Preencha os campos de senha
3. Deixe em branco se não quiser alterar
4. Clique em **Salvar Alterações**

## 🎨 Interface

### Cores dos Botões
- 🟣 **Roxo**: Ações principais (Criar, Salvar)
- 🔵 **Azul**: Editar
- 🔴 **Vermelho**: Excluir
- ⚫ **Cinza**: Cancelar/Voltar

### Notificações
O sistema mostra notificações automáticas:
- ✅ **Verde**: Sucesso (usuário criado/editado/excluído)
- ❌ **Vermelho**: Erro (algo deu errado)
- ⚠️ **Amarelo**: Aviso (atenção necessária)
- ℹ️ **Azul**: Informação

## 🆘 Problemas Comuns

### "Email já existe"
**Solução**: Use um email diferente ou edite o usuário existente

### "As senhas não coincidem"
**Solução**: Verifique se digitou a mesma senha nos dois campos

### "Acesso negado"
**Solução**: Você não é administrador. Peça a um admin para dar-lhe permissões

### "Não é possível excluir o último administrador"
**Solução**: Crie outro administrador antes de excluir este

### "Você não pode excluir sua própria conta"
**Solução**: Peça a outro administrador para fazer isso

## 📱 Atalhos do Teclado

### Navegação
- `Tab`: Navegar entre campos
- `Enter`: Submeter formulário
- `Esc`: Fechar diálogos

## 🔄 Fluxo de Trabalho Recomendado

### Para Novos Projetos
1. ✅ Crie um usuário administrador principal
2. ✅ Crie usuários administradores adicionais (backup)
3. ✅ Crie usuários padrão conforme necessário
4. ✅ Mantenha sempre pelo menos 2 administradores

### Manutenção Regular
1. 🔍 Revise a lista de usuários mensalmente
2. 🗑️ Remova usuários inativos
3. 🔐 Atualize senhas periodicamente
4. 📊 Monitore o número de administradores

## 📞 Suporte

Se precisar de ajuda:
1. Consulte este guia
2. Consulte a documentação completa em `SISTEMA_GERENCIAMENTO_USUARIOS.md`
3. Verifique os logs em `storage/logs/laravel.log`

## ✅ Checklist Inicial

Antes de começar a usar em produção:

- [ ] Criar usuário administrador principal
- [ ] Criar pelo menos um administrador backup
- [ ] Alterar a senha padrão do admin
- [ ] Testar criação de usuário
- [ ] Testar edição de usuário
- [ ] Testar exclusão de usuário
- [ ] Verificar permissões de acesso
- [ ] Documentar credenciais em local seguro

## 🎯 Próximos Passos

Agora que você sabe gerenciar usuários:
1. Configure suas empresas
2. Comece a receber avaliações
3. Monitore avaliações negativas
4. Explore outras funcionalidades do sistema

---

**💡 Lembre-se**: Apenas administradores podem gerenciar usuários!

**🔒 Segurança**: Nunca compartilhe suas credenciais de administrador!

**📝 Backup**: Mantenha sempre pelo menos 2 administradores ativos!

---

**Criado em**: Outubro 2025  
**Versão**: 1.0  
**Status**: ✅ Pronto para Uso

