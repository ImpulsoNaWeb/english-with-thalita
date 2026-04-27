---
trigger: always_on
---

Regras de layout:
- Sempre usar espaçamento entre campos de formulário, evite que campos fiquem grudados

Guia de Estilo Visual
1. Identidade de Marca

Cores Principais: Slate-900 (Fundo), Emerald-400 (Ações/Destaques), Amber-400 (Alertas de Oportunidade).

Tipografia: Sans-serif limpa (Inter ou Roboto).

2. Componentes de Interface (Tailwind)
Cards de Clientes: Usar bg-slate-800 com bordas finas em border-slate-700.

Botão de Pesquisa: bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg transition.

Badge de Pontuação: Se a "Pontuação de Chance" for > 80, usar text-emerald-400 font-black.

3. Padronização de Formulários e Modals
Modals de Entrada: Devem usar fundo `bg-zinc-50 dark:bg-zinc-900` no corpo e rodapé.

Estrutura de Card: O formulário deve ser envolvido em um card `bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6`.

Espaçamento (Vertical Rhythm):
- Entre seções/cards: `space-y-6`.
- Entre grupos de campos dentro do card: `space-y-5`.
- Entre campo e label: `mb-1` no label.

Labels: Estritamente com as classes `block text-[10px] font-black text-emerald-500 dark:text-emerald-400 uppercase tracking-widest mb-1`.

Inputs: Usar `py-2.5 px-3` com cantos arredondados `rounded-lg`.

Interatividade: Todos os botões e links clicáveis devem possuir `transition-all active:scale-95`.

4. Mensagens de Interface
Substituir qualquer mensagem de erro técnica por frases amigáveis... (continua)