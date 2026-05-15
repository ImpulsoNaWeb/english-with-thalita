---
trigger: always_on
---

# 00 - INSTRUÇÕES MESTRE
Engenheiro autônomo baseado em gatilhos e workflows modulares.

---

### 📂 ESTRUTURA DE COMANDOS (WORKFLOWS)
A lógica operacional de cada comando foi movida para o diretório `.agents/workflows/`. Invoque-os através de menção ou comando direto:
- **Planejamento (`!`, `plan`, `planejar`)**: [.agents/workflows/plan.md](.agents/workflows/plan.md) - **PROIBIDO** criar planejamentos de forma automática ou via modo interno sem gatilho explícito do desenvolvedor. Quando solicitado, criar o arquivo físico em `.agents/plans/` seguindo o padrão `PLAN_XXXXX.md`.
- **Diagnóstico (`diag`, `diagnosticar`)**: [.agents/workflows/diag.md](.agents/workflows/diag.md)
- **Execução (`#`, `iniciar`)**: [.agents/workflows/exec.md](.agents/workflows/exec.md)

- **Revisão (`$`, `revisar`)**: [.agents/workflows/review.md](.agents/workflows/review.md)
- **Commit (`&`, `commit`)**: [.agents/workflows/commit.md](.agents/workflows/commit.md)
- **Push (`*`, `push`)**: [.agents/workflows/push.md](.agents/workflows/push.md)
- **Auditoria (`/audit`, `auditar`)**: [.agents/workflows/audit.md](.agents/workflows/audit.md)
- **Finalizar (`fin`)**: [.agents/workflows/fin.md](.agents/workflows/fin.md)

---

### 🧠 COMPORTAMENTO E FLUXO DO AGENTE
O Agente deve operar sob o regime de **Gatilho Único e Pausa Mandatória**:
- **Atomicidade Total:** Execute apenas UMA tarefa (US) por turno. É terminantemente proibido emendar workflows ou tarefas (ex: executar US1 e US2 juntas, ou executar US e depois `fin`).
- **Pausa Forçada:** Após concluir qualquer ação, o Agente deve **PARAR** imediatamente, relatar o progresso e aguardar o próximo comando do desenvolvedor.
- **Proibição de Cascata:** Nunca execute um comando após o outro (ex: `commit` seguido de `push`) por iniciativa própria. A execução conjunta de múltiplos workflows é uma **EXCEÇÃO EXCLUSIVA** permitida apenas quando solicitada explicitamente pelo desenvolvedor no mesmo prompt. Fora isso, a pausa após cada ação é mandatória.
- **Finalização de Planos:** O Agente nunca deve encerrar um plano (`fin`) por iniciativa própria. A finalização de um ciclo de trabalho é um rito de aprovação exclusivo do desenvolvedor.
- **Conformidade de Workflow:** Siga rigorosamente as instruções de pausa contidas em cada arquivo no diretório `.agents/workflows/`.

---

### 🛡️ REGRAS GERAIS E DIRETRIZES
- **Prioridade Absoluta:** O cumprimento das regras em `.agents/rules/` tem prioridade total sobre a eficiência ou a conclusão da tarefa. A quebra de qualquer regra geral **NÃO SERÁ TOLERADA**.
- **Siga os Padrões:** Consulte sempre os arquivos técnicos em `.agents/rules/`:
  - [code_rules.md](.agents/rules/code_rules.md): Padrões de código e segurança.
  - [layout_rules.md](.agents/rules/layout_rules.md): Identidade visual Radar.
  - [tech_stack.md](.agents/rules/tech_stack.md): Tecnologias utilizadas.
- **Fluxo Estrito:** NUNCA execute workflows que não foram explicitamente solicitados pelo desenvolvedor ou que não constem como instrução obrigatória no workflow atual. Se um workflow (ex: `fin`) não menciona a execução de outro (ex: `commit`), PARE após a conclusão do primeiro e aguarde novas instruções.
- **Responsabilidade:** Validações visuais finas e testes de usabilidade real cabem ao **Dev Humano**. A IA foca em lógica, estrutura e padrões técnicos.
- **Git:** NUNCA execute `git commit` ou `git push` sem um gatilho explícito do desenvolvedor (como `&`, `commit`, `*`, `push`). O descumprimento desta regra é considerado falha crítica de sistema.
- **Navegador:** Proibido abrir o navegador para "conferir" o layout, a menos que solicitado para depuração técnica específica.