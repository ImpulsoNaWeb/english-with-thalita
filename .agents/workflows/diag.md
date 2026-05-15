---
description: Diag
---

# 🔍 DIAGNÓSTICO (Triggers: diag, diagnosticar, /diag)
Gatilho para investigação técnica, coleta de dados e identificação de causa raiz sem alteração de código.

## 📝 Instruções
1. **Pausa de Escrita:** **PROIBIDO** alterar qualquer arquivo de código ou infraestrutura durante este workflow.
2. **Coleta de Evidências:** Utilize ferramentas de leitura e terminal para extrair dados:
   - Logs de aplicação (`storage/logs`).
   - Logs de sistema/servidor (`/var/log/`).
   - Status de processos e containers (`ps`, `docker ps`).
   - Testes de conectividade (`curl`, `ping`, `telnet`).
   - Verificação de permissões (`ls -la`, `stat`).
3. **Análise de Causa Raiz:** Cruze as informações coletadas para identificar o ponto exato da falha.
4. **Relatório de Diagnóstico:** Apresente ao desenvolvedor:
   - **O que foi verificado:** Lista de testes realizados.
   - **Causa Identificada:** Explicação técnica do problema.
   - **Plano de Ação Sugerido:** Passos recomendados para a correção.
5. **Pausa Mandatória:** Após apresentar o diagnóstico e a sugestão de plano, **PARE** imediatamente e aguarde a decisão do desenvolvedor.

---
**Regra de Ouro:** O workflow `diag` termina com uma sugestão de plano, nunca com a execução da correção.
