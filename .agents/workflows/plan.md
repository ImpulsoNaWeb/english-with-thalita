---
description: Planejamento
---

# 📋 PLANEJAMENTO (Triggers: !, plan, planejar)
Gatilho para organizar e refinar o arquivo de planejamento sem alterar código. **PROIBIDO** iniciar sem comando explícito.

## 📝 Instruções
1. **Comando com Descrição:** O texto que segue o gatilho é a descrição da tarefa a ser organizada.
2. **Idioma:** Todos os arquivos de plano, títulos e descrições DEVEM ser escritos em **pt-BR**.
3. **Pausa Absoluta:** **PARE O DESENVOLVIMENTO**. Não altere nenhum código.
4. **Documento Vivo:** Crie/Atualize o arquivo `.md` em `.agents/plans/` seguindo estritamente o padrão `PLAN_NOME_DA_FUNCIONALIDADE.md` (Ex: `PLAN_AJUSTE_CORES.md`).
5. **User Stories (US):** Divida o objetivo em US pequenas e sequenciais:
   - `[ ]` Objetivo Geral.
   - `[ ]` Passo a passo técnico detalhado.
   - **Impacto Colateral:** Lista de arquivos/componentes que podem quebrar.
6. **Validação:** Apresente o plano e aguarde aprovação. **NENHUM CÓDIGO** até o comando `iniciar`.
7. **Execução Blindada:** Trabalhe em apenas UMA US por vez. Se houver imprevisto, pare e adicione `US Extra`.
8. **Fim da US:** Marque `[x]`, informe impactos e **PARE** para validação.