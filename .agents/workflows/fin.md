---
description: Finalizar Plano
---

# 🏁 FINALIZAR (Triggers: fin, finalizar)
Gatilho para encerrar formalmente um ciclo de desenvolvimento e arquivar o planejamento.

## 📝 Instruções
1. **Timestamp Interno:** Adicionar obrigatoriamente a data e hora atual no final do conteúdo do arquivo de plano ativo (ex: `## Finalizado em: 2026-05-09 03:30`).
2. **Conclusão:** Marcar todas as US como concluídas `[x]`.
3. **Arquivamento:** Mover o arquivo de `.agents/plans/` para `.agents/plans/history/`, renomeando-o para o padrão: `PLAN_{timestamp}_RESTO_DO_TITULO.md` (ex: `PLAN_20260509_0330_REFINAMENTO_ERROS.md`).
4. **Resumo:** Informar ao desenvolvedor que o plano foi selado e arquivado com o novo nome.
