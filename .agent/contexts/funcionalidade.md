# Contexto de Funcionalidade - Correção de Boot e Setup Inicial

## Problema
A aplicação falhava durante o `composer install` (especificamente no `package:discover`) porque o modelo `Configuracao` tentava acessar a tabela de cache/configurações antes do banco de dados SQLite existir ou ser migrado.

## Solução
- Implementado bloco `try-catch` no método `Configuracao::get()` para retornar o valor padrão caso ocorra uma exceção de banco de dados.
- Configuração do `.env` baseada no `.env.example`.
- Criação e migração do banco de dados SQLite.

## Ajustes Recentes
- **WhatsApp nos Planos de Estudo:** O botão "Falar com a Thalita no WhatsApp" no modal de detalhes dos planos foi atualizado para redirecionar diretamente para o WhatsApp com uma mensagem personalizada, em vez de rolar para a seção de contato. Adicionada também a internacionalização (i18n) para este botão.

- **Correções de Produção (VPS):**
  - **HTTPS/Mixed Content:** Configurado `trustProxies(at: '*')` no `bootstrap/app.php` para resolver bloqueios de upload e assets causados por HTTPS atrás de proxy reverso.
  - **Console Errors:** Corrigido seletor JavaScript no `AdminPanelProvider.php` (usando Nowdoc para gestão segura de backslashes) e atualizada a metatag `mobile-web-app-capable`.
  - **PWA Manifest:** Limpeza de assets inexistentes para eliminar erros 404.
  - **Environment:** Ajustado `.env` para suporte a `APP_URL` com HTTPS e modo de depuração.

## Ajustes de Acesso e Sessão (2026-05-15)
- **Autorização Filament:** Implementada a interface `FilamentUser` no model `Usuario` e adicionado o método `canAccessPanel` retornando `true` para resolver erros 403 no ambiente de produção (VPS).
- **Estabilização de Sessão:** Alterado `SESSION_DRIVER` de `database` para `file` no `.env` para evitar conflitos de persistência e garantir estabilidade da sessão na VPS.
