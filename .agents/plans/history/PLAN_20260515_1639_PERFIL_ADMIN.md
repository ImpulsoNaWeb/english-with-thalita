# 📋 PLANEJAMENTO - Tela de Perfil do Administrador

Implementação de tela para que o administrador possa alterar seus dados de acesso (E-mail e Senha) diretamente pelo painel Filament.

---

## 📝 USER STORIES

### [x] US01: Criação da Página de Perfil Customizada
- **Objetivo:** Criar uma página que permita editar os dados do usuário autenticado.
- **Ações:**
  - Criar o diretório `app/Filament/Pages/Auth` se não existir.
  - Criar o arquivo `EditarPerfil.php` estendendo `Filament\Pages\Auth\EditProfile`.
  - Configurar o formulário com os campos: `nome`, `email`, `senha` e `confirmacao_senha`.
  - Implementar validação de e-mail único (exceto para o próprio usuário).
  - Garantir que a senha seja criptografada antes de salvar.
- **Arquivos:** `app/Filament/Pages/Auth/EditarPerfil.php`

### [x] US02: Ativação no Painel Administrativo
- **Objetivo:** Tornar a página acessível através do menu de usuário no topo do painel.
- **Ações:**
  - Modificar `app/Providers/Filament/AdminPanelProvider.php`.
  - Adicionar a chamada `->profile(EditarPerfil::class)` na configuração do painel.
- **Arquivos:** `app/Providers/Filament/AdminPanelProvider.php`

### [x] US03: Refinamento de UI/UX e Feedback
- **Objetivo:** Garantir que a experiência seja fluida e visualmente atraente.
- **Ações:**
  - Adicionar ícones aos campos (Lucide).
  - Personalizar mensagens de sucesso e erro em pt-BR conforme `layout_rules.md`.
  - Verificar se o botão de salvar possui o estilo correto (`bg-emerald-500`).
- **Arquivos:** `app/Filament/Pages/Auth/EditarPerfil.php`

---

## ⚠️ IMPACTO COLATERAL
- **Autenticação:** Erros na atualização da senha podem deslogar o usuário ou impedir novos logins.
- **Sessão:** A alteração do e-mail pode invalidar sessões dependendo da configuração do driver.

---

## 📅 VALIDAÇÃO
- [x] Acessar o menu do usuário e clicar em "Perfil".
- [x] Alterar o nome e salvar.
- [x] Alterar o e-mail para um já existente e verificar erro de validação.
- [x] Alterar a senha e verificar se o login continua funcionando com a nova senha.

## Finalizado em: 2026-05-15 16:39

