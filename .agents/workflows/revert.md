---
description: Revert
---

# ⏪ REVERTER (Gatilho: /revert)
Fluxo de emergência para desfazer commits acidentais e restaurar a conformidade do fluxo.

## 📝 Instruções
1. **Identificação**: Use este comando imediatamente após um `commit` ou `push` realizado por engano pelo Agente.
2. **Reversão Local**: Execute `git reset --soft HEAD~1` para remover o registro do commit mas preservar as alterações nos arquivos.
3. **Sincronização Remota**: Execute `git push origin [branch] --force` para garantir que o repositório remoto volte ao estado correto.
4. **Registro de Falha (Log)**: **OBRIGATÓRIO** criar ou atualizar o arquivo `.agents/logs/agent_errors.log` com:
   - Data e Hora.
   - Descrição da regra quebrada (ex: Commit sem gatilho durante US).
   - Link para o arquivo de plano ativo no momento do erro.
5. **Relatório**: Informe ao desenvolvedor que o estado foi restaurado e que o log de erro foi registrado.
6. **Conformidade**: Reforce o compromisso com as regras de Git do `00-master.md`.
