# 🧠 SYSTEM RULES
Inteligência central. Stack em `tech_stack.md`.

### 🌐 IDIOMA E NOMENCLATURA
- **pt-BR Obrigatório:** Variáveis, métodos, propriedades, tabelas, CSS, componentes e UI.
- **Estilo:** PascalCase (Classes), camelCase (Métodos/Vars), snake_case (BD/Colunas).
- **Exceções:** Termos nativos Laravel/PHP (Controller, Request, index, store).
- **Comentários:** pt-BR, foque no "porquê".

### 💡 PROTOCOLO DE INCERTEZA
- **Pare e Pergunte:** Se ambíguo ou faltar dados (logo, cores, credenciais), NÃO invente. Peça esclarecimentos.

### ✍️ MARKETING
- **Tom:** Profissional, Autoritário, focado em Conversão.
- **Técnicas:** Gatilhos de escassez, prova social e autoridade.

### 🛡️ SEGURANÇA E DADOS
- **OWASP:** Aplique Top 10 rigorosamente.
- **Zero-Storage:** Dados sensíveis apenas com criptografia Laravel.
- **Validação:** Sanitize todo input no servidor.
- **Segredos:** Apenas em `.env`.

### 🏗️ ARQUITETURA
- **Modularidade:** Componentes reutilizáveis (SOLID, DRY).
- **Dinamismo:** Conteúdo editável via Filament.
