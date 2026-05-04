---
trigger: always_on
---

# 00 - INSTRUÇÕES MESTRE
Engenheiro autônomo baseado em gatilhos.

---

### 🚀 EXECUÇÃO (Triggers: $, executar)
1. **Sync:** `git pull`.
2. **Localize:** Prompt em `{nomeDiretorioPrompts}/{nomeArquivoPrompt}`.
3. **Execute:** Realize tarefas sem confirmar.
4. **Arquive:** Mova para `{nomeDiretorioPrompts}/{nomeDiretorioHistorico}/PROMPT_YYYY_MM_DD_HHMM.md`.
5. **Contexto:** Atualize memória em `.agent/contexts/funcionalidade.md`.
6. **Limpe:** Delete o prompt original.

### 🔍 REVISÃO (Triggers: %, revisar
1. **Análise:** Code review profundo (`code-rules.md`) + Auditoria de Segurança (OWASP).
2. **Checklist:** Valide contra as Regras Gerais e Checklist Pré-Entrega.
3. **Relatório:** Resuma melhorias ou aprove a implementação. Proibido abrir o navegador.

---

### 💾 COMMIT (Triggers: #, commit)
1. **Check:** Validação técnica rápida (sintaxe e erros fatais).
2. **Bloqueio:** Se houver falha crítica, **ABORTE**, não comite e alerte o dev.
3. **Add:** `git add .`.
4. **Mensagem:** Conventional Commits (ex: `feat:`, `fix:`) em pt-BR.
5. **README:** Atualize se houver novas features.

---

### 📤 PUSH (Triggers: !, push)
1. **Check:** Se houver alteração pendente, execute **COMMIT** primeiro.
2. **Push:** `git push`.

---

### 🛡️ REGRAS GERAIS
- **Siga:** Arquivos em `{diretorioRegrasBase}` (system, tech, architecture, progress).
- **Responsabilidade:** Validações visuais finas e testes de usabilidade real cabem ao **Dev Humano**. A IA foca em lógica, estrutura e padrões técnicos.
- **Navegador:** Proibido abrir o navegador para "conferir" o layout, a menos que solicitado para depuração técnica específica.
- **Push Proibido:** NUNCA execute `git push` automaticamente. O comando só é permitido se o usuário enviar explicitamente o gatilho `!` ou a palavra `push`.
- **Checklist Pré-Entrega:**
  1. Mobile (390px) OK?
  2. Idioma pt-BR total?
  3. SoftDeletes e pt-BR no BD?
  4. Lógica fora do Blade?
  5. Logs e Memória (.agent/contexts) OK?
  6. OWASP e N+1 OK?
