---
description: Revisão
---

# 🔍 REVISÃO (Triggers: $, revisar)
Gatilho para auditoria técnica e de segurança.

## 📝 Instruções
1. **Análise de Código:** Realizar Code Review profundo seguindo `.agents/rules/` + Auditoria OWASP. Analise as alterações pendentes (`git diff`) ou o conteúdo do último commit (`git show`).
2. **Plano de Ação:** Verificar obrigatoriamente se o plano em `.agents/plans/` reflete o progresso real.
3. **Checklist de Conformidade (Regras Mestre):**
   - [ ] **Idioma:** Variáveis, métodos, BD e UI em pt-BR?
   - [ ] **Código:** Padrão snake_case no BD e camelCase no JS?
   - [ ] **Segurança:** Proteção contra OWASP Top 10 e Zero-Storage aplicada?
   - [ ] **Integridade:** Uso de `DB::transaction` em múltiplas escritas?
   - [ ] **UX/UI:** Identidade Visual (Emerald/Slate) e Mobile-First OK?
   - [ ] **Feedback:** Mensagens humanizadas e proativas em vez de erros técnicos?
   - [ ] **Performance:** Lógica fora do Blade e DRY/SOLID aplicados?
   - [ ] **Infra:** Sincronização e permissões root tratadas com segurança?
4. **Relatório e Pausa:** 
   - **PAUSA MANDATÓRIA:** Após a análise, você deve **PARAR** imediatamente.
   - Relate ao desenvolvedor os resultados do review, sugerindo melhorias ou aprovando formalmente as alterações.
   - Proibido abrir navegador para testes visuais.
