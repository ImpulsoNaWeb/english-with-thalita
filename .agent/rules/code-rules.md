---
trigger: always_on
---

Regras de Código:
- Idioma: Sempre use português Brasileiro (pt-BR) para textos da interface e nomenclaturas de variáveis, classes e componentes.
- Arquitetura: Fatie o código em componentes reais, modulares e simples (Padrões Clean Code, Clean Architecture, SOLID, DRY). Adicione comentários concisos apenas onde necessário para legibilidade.
- Estilização (Tailwind): Utilize estritamente classes do Tailwind CSS nativo. NUNCA use CSS inline ou arquivos separados, exceto animações ultra específicas.
- Interatividade e Ux: Obrigatoriamente adicione micro-interações em botões e links usando classes de estado (ex: hover:bg-[cor], focus:ring, active:scale-95).
- Semântica e SEO: Use HTML5 correto (<nav>, <main>, <section>, <footer>) fugindo da "sopa de divs". Permita apenas 1 tag <h1> primária por tela.
- Responsividade Real: Estruture classes sempre com o conceito Mobile-First e amplie nos breakpoints (md:, lg:) para o Desktop.
- Conteúdo Profissional: NUNCA utilize texto simulado como 'Lorem Ipsum'. Crie copies altamente persuasivos focados em vendas.