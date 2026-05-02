---
trigger: always_on
---

# 02 - DIRETRIZES DE LAYOUT E DESIGN (WAVE UI)

Seu objetivo é criar interfaces que causem um efeito "WOW" imediato. Utilize um design moderno, limpo e focado em alta conversão.

---

### 🎨 IDENTIDADE VISUAL (TOKENS)
- **Cores de Fundo:** `bg-slate-900` (Dark Mode padrão) ou `bg-white` (Light Mode).
- **Cores de Destaque:** `text-emerald-400` / `bg-emerald-500` (Ações primárias e Sucesso).
- **Cores de Alerta:** `text-amber-400` / `bg-amber-500` (Oportunidades e Atenção).
- **Tipografia:** Use estritamente fontes Sans-serif limpas como **Inter** ou **Outfit**.

### 📦 COMPONENTES DE INTERFACE
- **Cards:** Use `bg-slate-800` com bordas finas `border-slate-700` e arredondamento `rounded-2xl`.
- **Botões:** 
  - Estilo: `bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all active:scale-95`.
- **Badges:** Para pontuações altas (>80), utilize `text-emerald-400 font-black tracking-widest uppercase text-[10px]`.

### 📝 FORMULÁRIOS E MODAIS
- **Modais:** Devem ter fundo `bg-zinc-50 dark:bg-zinc-900` com cabeçalhos e rodapés bem definidos.
- **Estrutura de Formulário:** Envolva em um card com `p-8` e `space-y-6`.
- **Vertical Rhythm:** 
  - Espaço entre cards/seções: `space-y-8`.
  - Espaço entre grupos de campos: `space-y-5`.
  - Labels: `mb-1.5 text-[10px] font-black text-emerald-500 dark:text-emerald-400 uppercase tracking-widest block`.
- **Inputs:** `py-3 px-4 rounded-xl border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 focus:ring-4 focus:ring-emerald-500/10 transition-all`.

### 📱 RESPONSIVIDADE E ESPAÇAMENTO
- **Mobile-First:** Projete primeiro para telas pequenas e expanda usando prefixos `md:` e `lg:`.
- **Containers:** Utilize `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` para centralizar o conteúdo no desktop.
- **Paddings:** Seja generoso nos paddings verticais de seções (`py-16` ou `py-24`).

### 💬 MENSAGENS E FEEDBACK
- **Humanização:** Substitua erros técnicos por frases amigáveis e proativas.
- **Sucesso:** "Tudo pronto! Seu registro foi salvo com sucesso."
- **Erro:** "Ops! Algo não saiu como esperado. Vamos tentar novamente?"