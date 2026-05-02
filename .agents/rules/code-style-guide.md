---
trigger: always_on
---

# Code Style Guide (Guia de Estilo de Código)

## Idioma e Arquitetura
- **Código:** pt-BR obrigatório. Todas as classes, métodos, variáveis, propriedades e comentários devem ser em Português (Brasil).
- **Banco de Dados:** Todas as tabelas, colunas (inclusive padrões como `nome`, `senha`, `email_verificado_em`), migrations e seeders devem ser em pt-BR.
- **Interface (UI):** Português (pt-BR). Todas as mensagens do sistema, labels do Filament e notificações devem ser em PT-BR.
- **Arquitetura:** Clean Architecture (SOLID, DRY). Seguir os padrões oficiais do Laravel, mas adaptados para nomes em português.

## CSS e Design
- **Tailwind CSS:** Uso exclusivo do framework. 
- **Sem CSS Inline:** Estilos devem ser aplicados via classes utilitárias ou arquivos CSS compilados no Vite.
- **Componentização:** Sempre que possível, utilize componentes Blade ou Livewire para elementos reutilizáveis.

## Padrões de Código
- Padronização PSR-12 para PHP.
- Uso de Type Hinting em métodos e retornos sempre que possível.