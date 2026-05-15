---
description: Auditoria de Segurança, Performance e Regras
---

# 🛡️ AUDITORIA (Triggers: /audit, auditar)
Gatilho para varredura profunda de segurança, performance e conformidade técnica.

## 📝 Instruções de Execução

### 1. Auditoria de Segurança e Dados
- **OWASP Top 10:** Aplique rigorosamente a varredura contra Injeção, Broken Access Control e Exposição de Dados.
- **Zero-Storage:** Verifique se dados sensíveis estão protegidos com criptografia nativa do Laravel (`Crypt`).
- **Validação:** Garanta que TODO input no servidor use `FormRequests` ou `request->validate()`.
- **Integridade:** Verifique se IDs de entrada são validados contra o banco de dados e se pertencem ao contexto/workspace correto antes do processamento.
- **Autorização:** Confirme se há verificações de permissão explícita para cada ação solicitada pelo usuário.
- **Segredos:** Garanta que chaves e tokens NUNCA estejam no código, apenas em arquivos `.env`.
- **Transações:** Use `DB::transaction` em TODA operação que envolva múltiplas tabelas ou lógica complexa de escrita para garantir atomicidade.
- **Queries Inseguras:** Localize `DB::raw` ou `whereRaw` sem bindings via `grep_search`.

### 2. Auditoria de Performance
- **Queries N+1:** Analise loops que executam consultas ao banco (use `with()` para Eager Loading).
- **Assets:** Verifique se há importações pesadas de bibliotecas inteiras no frontend onde apenas um componente é necessário.
- **Caching:** Identifique dados estáticos ou semi-estáticos que poderiam ser cacheados.

### 3. Conformidade com Regras (.agents/rules)
- **Code Rules:** Verifique o uso obrigatório de pt-BR em variáveis e comentários (exceção nativos do Laravel). Valide se a nomenclatura segue PascalCase para classes e camelCase para métodos.
- **Layout Rules:** Valide se os componentes usam estritamente os tokens de cor do Radar UI (`emerald`, `slate`, `zinc`).
- **Atomicidade:** Garanta que transações de banco (`DB::transaction`) são usadas em operações complexas.

### 4. Blindagem de Bugs
- **Análise Estática:** Se disponível, execute comandos de linting ou análise estática.
- **Smoke Tests:** Tente simular ou planejar um teste de caminho feliz para a funcionalidade auditada.

## 🏁 Entrega da Auditoria
Ao finalizar, apresente um relatório estruturado:
- **✅ OK:** Itens em conformidade.
- **⚠️ Alerta:** Sugestões de melhoria não críticas.
- **🚨 Crítico:** Vulnerabilidades ou bugs que impedem o deploy.
