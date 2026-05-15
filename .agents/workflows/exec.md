---
description: Execução
---

# 🚀 INICIAR / EXECUTAR (Triggers: #, iniciar, executar)
Gatilho para codificação controlada e atômica.

## 📝 Instruções
1. **Execução Direta:** Se o comando vier com tarefa (ex: `#ajustar botão`), realize IMEDIATAMENTE como US atômica.
2. **Atomicidade Obrigatória:** Proibido executar mais de uma US no mesmo turno. **NUNCA** emende uma US em outra, independentemente da simplicidade.
3. **Prioridade de Prompt:** 
   - Verifica `.agents/prompts/`.
   - Se houver, execute e arquive em `.agents/prompts/history/`.
4. **Fluxo de Plano:** 
   - Localiza primeira US pendente em `.agents/plans/`.
   - Atualiza status para "Em andamento".
   - Executa rigorosamente o passo a passo técnico.
5. **Pausa Forçada:** Ao concluir a US atual, marque `[x]`, informe os impactos técnicos e **PARE** imediatamente. Aguarde a validação humana antes de prosseguir para a próxima US.
6. **Proibição de Finalização:** **NUNCA** execute o workflow `fin` (finalizar/arquivar plano) sem um comando explícito. A finalização é um rito de entrega que pertence ao desenvolvedor.
7. **Disciplina:** Seguir as regras de "Execução Controlada e Blindada".


### ✅ CHECKLIST PRÉ-ENTREGA
Antes de finalizar qualquer tarefa, valide:
1. Mobile (390px) OK?
2. Idioma pt-BR total?
3. SoftDeletes e pt-BR no BD?
4. Lógica fora do Blade?
5. Logs e Memória (.agents/contexts) OK?
6. OWASP e N+1 OK?