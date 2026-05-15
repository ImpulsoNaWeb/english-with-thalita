---
description: Report
---

# 🚩 WORKFLOW: REPORT
Este workflow deve ser acionado sempre que o Agente apresentar comportamento inesperado, alucinações (como textos em idiomas não solicitados) ou descumprimento de regras.

---

### 📂 PROCEDIMENTO DE RELATO
1.  **Identificação:** O Agente deve identificar o erro cometido (ex: "Alucinação de idioma", "Quebra de regra de commit").
2.  **Criação de Arquivo:** Criar um arquivo novo em `.agents/reports/REPORT-YYYY-MM-DD-HHmm.md`.
3.  **Conteúdo do Relato:**
    - `# 🚩 RELATO DE FALHA: [TIPO]`
    - **Data/Hora:** `[YYYY-MM-DD HH:mm:ss]`
    - **Contexto:** Link para o arquivo onde ocorreu ou descrição da tarefa.
    - **Descrição:** Detalhar a falha (se for alucinação de idioma, incluir original e tradução).
    - **Ação Corretiva:** Como o erro foi mitigado e plano de prevenção.
4.  **Pausa Mandatória:** Após salvar o arquivo, o Agente deve parar e aguardar a ciência do desenvolvedor.

---

### 🧠 REGRAS DE AUTOCONTROLE
- O Agente não deve tentar "justificar" o erro com humor.
- O relato deve ser puramente técnico e direto.
- Se o erro envolver dados sensíveis, o log deve ser mascarado.
