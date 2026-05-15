---
trigger: always_on
---

# 🧠 CODE RULES
Inteligência central. Stack em `tech_stack.md`.

### 🌐 IDIOMA E NOMENCLATURA
- **pt-BR Obrigatório:** Variáveis, métodos, propriedades, tabelas, CSS, componentes e UI.
- **Estilo:** PascalCase (Classes), camelCase (Métodos/Vars), snake_case (BD/Colunas).
- **Exceções:** Termos nativos Laravel/PHP (Controller, Request, index, store).
- **Comentários:** pt-BR, foque no "porquê".
- **Timezone:** Use SEMPRE o fuso horário brasileiro (`America/Sao_Paulo`) para exibição e manipulação de horários.

### 💡 PROTOCOLO DE INCERTEZA
- **Pare e Pergunte:** Se ambíguo ou faltar dados (logo, cores, credenciais), NÃO invente. Peça esclarecimentos.

### ✍️ MARKETING
- **Tom:** Profissional, Autoritário, focado em Conversão.
- **Técnicas:** Gatilhos de escassez, prova social e autoridade.

### 🛡️ SEGURANÇA E DADOS
- **OWASP:** Aplique Top 10 rigorosamente.
- **Zero-Storage:** Dados sensíveis apenas com criptografia Laravel.
- **Validação:** Valide RIGOROSAMENTE todo input no servidor. Use FormRequests ou `request->validate()`.
- **Integridade:** Sempre verifique se os IDs/registros de entrada existem no banco de dados e pertencem ao contexto correto antes de processar.
- **Autorização:** Verifique SEMPRE se o usuário autenticado tem permissão explícita para executar a ação solicitada.
- **Segredos:** Apenas em `.env`.
- **Transações:** Use `DB::transaction` em TODA operação de backend que envolva alteração em múltiplas tabelas ou lógica complexa de escrita para garantir a atomicidade e integridade dos dados.

### 🏗️ ARQUITETURA
- **Modularidade:** Componentes reutilizáveis (SOLID, DRY).