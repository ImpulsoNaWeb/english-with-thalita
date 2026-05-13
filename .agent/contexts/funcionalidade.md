# Contexto de Funcionalidade - Correção de Boot e Setup Inicial

## Problema
A aplicação falhava durante o `composer install` (especificamente no `package:discover`) porque o modelo `Configuracao` tentava acessar a tabela de cache/configurações antes do banco de dados SQLite existir ou ser migrado.

## Solução
- Implementado bloco `try-catch` no método `Configuracao::get()` para retornar o valor padrão caso ocorra uma exceção de banco de dados.
- Configuração do `.env` baseada no `.env.example`.
- Criação e migração do banco de dados SQLite.

## Ajustes Recentes
- **WhatsApp nos Planos de Estudo:** O botão "Falar com a Thalita no WhatsApp" no modal de detalhes dos planos foi atualizado para redirecionar diretamente para o WhatsApp com uma mensagem personalizada, em vez de rolar para a seção de contato. Adicionada também a internacionalização (i18n) para este botão.

## Estado Atual
- Banco de dados: Configurado e migrado.
- Aplicação: Rodando via `php artisan serve`.
- Erros de boot: Resolvidos.
- **Fluxo de Conversão:** Link direto para WhatsApp nos detalhes dos planos implementado.
- **Gestão de Fotos do Site:** 
  - Centralizada a troca da foto da seção "Sobre" na aba "Sobre" das configurações.
  - Adicionado campo para "Foto de Fundo do Hero" (opcional).
  - Atualizado o `ConteudoSeeder` para utilizar caminhos locais (`seed/thalita_sobre.jpg`), facilitando o setup inicial com as fotos reais da Thalita.
