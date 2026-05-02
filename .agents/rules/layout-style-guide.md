# Layout Style Guide (Guia de Estilo de Layout)

## App-Like Experience (Mobile-First)
A interface deve ser projetada primeiramente para dispositivos móveis, simulando o comportamento de um aplicativo nativo.

## Configurações de PWA e Mobile Shell
- **App Shell:** Ocultar a barra nativa do navegador via `apple-mobile-web-app-capable`.
- **Scroll:** Remover o scroll elástico (`overscroll-behavior-y: contain`).
- **Gestos:** Implementar e suportar pull-to-refresh nativo do navegador.

## Unidades e Escala de UI
- **Arredondamento:** Bordas largas e suaves utilizando `rounded-xl` ou `rounded-2xl`.
- **Botões:** Altura mínima de **48px** para garantir acessibilidade e facilidade de toque.
- **Inputs:** Fonte mínima de **16px** (essencial para evitar o zoom automático no iOS ao focar no campo).

## Customização Filament
- **Sidebar:** Oculta por padrão em mobile.
- **Topbar:** Minimalista, focando no título da página e ações rápidas.
- **Bottom Navigation Bar:** Barra fixa no rodapé visível apenas em mobile.
  - Deve respeitar o `env(safe-area-inset-bottom)` do iPhone.
  - Ícones: Início, Conteúdo, Configurações, Perfil.

## Animações e Transições
- Transições suaves entre páginas e modais para melhorar a percepção de performance.

## Idioma e Localização (PT-BR)
- **Obrigatório:** Toda a implementação do painel, sem exceções, deve utilizar Português do Brasil (pt-BR).
- Isso inclui botões, textos gerais, seções de ajuda, placeholders, modais, validações e alertas.
- Nenhuma string ou termo em inglês deve estar presente na interface visual do usuário ou de administração.
