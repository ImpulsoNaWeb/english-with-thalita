---
description: Commit
---

# 💾 COMMIT (Triggers: &, commit)
Gatilho para criar ponto de restauração seguro.

## 📝 Instruções
1. **Revisão Obrigatória:** Executar `$ revisar` antes de prosseguir.
2. **Finalizar Plano:** Utilizar o comando `fin` para registrar data/hora e mover o plano ativo para `.agents/plans/history/`.
3. **Check Técnico:** Validar sintaxe e erros fatais. Se houver falha, **ABORTE**.
4. **Build:** Executar `npm run build`.
5. **Documentação:** Atualizar README e contexto em `.agents/contexts/funcionalidade.md`.
6. **Staging:** `git add .`.
7. **Mensagem:** Usar Conventional Commits em pt-BR (ex: `feat:`, `fix:`).