# 📱 ARCHITECTURE CONTEXT
UX Mobile-First e PWA.

### 📐 RESPONSIVIDADE
- **Base:** 390px (iPhone).
- **Tabelas:** Responsivas (stack/scroll).
- **Touch:** Inputs min 44px altura.
- **PWA:** Bottom Navigation Bar.

### 🎨 DESIGN (WAVE UI)
- **Tokens:** Slate-900 (Fundo), Emerald-500 (Primary), Amber-500 (Alert).
- **Cards:** `rounded-2xl`, border-slate-700.
- **Botões:** `rounded-xl`, `active:scale-95`.

### 📦 COMPONENTES & LÓGICA
- **Clean Blade:** Blade apenas para exibição. Lógica em Livewire/Models.
- **Nativo:** Priorize componentes Filament.
- **Mídia:** Captura direta via câmera no mobile.

### ⚡ PERFORMANCE
- **Queries:** Eager Loading (evite N+1).
- **Imagens:** Lazy Loading nativo.
- **Feedback:** Estados de loading (Livewire).
