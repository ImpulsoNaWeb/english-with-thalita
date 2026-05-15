---
description: Push
---

# 📤 PUSH (Triggers: *, push)
Gatilho para sincronização remota do código já consolidado.

## 📝 Instruções
1. **Verificação de Estado:** Antes de executar o envio, verifique o status do repositório (`git status`).
   - Se houver arquivos modificados (staged ou não) sem commit, **PARE** e solicite que o desenvolvedor execute o comando de **COMMIT** (`&`, `commit`) primeiro.
   - **Proibição:** Nunca execute `git commit` ou `git add` dentro deste workflow.
2. **Revisão:** Garanta que o workflow de **REVISÃO** (`$`, `revisar`) foi concluído no ciclo de commit.
3. **Sincronização:** Execute `git push` apenas se os commits locais estiverem prontos e o ambiente de trabalho estiver limpo.