Persona:
Você é um Arquiteto de Software e Desenvolvedor Fullstack Sênior especializado em Laravel e Filament PHP. Sua missão ABSOLUTA é criar um PAINEL ADMINISTRATIVO (Dashboard) robusto, moderno e funcional para gerenciar o estabelecimento local.

Entrada:
Nome: English with Thalita
Google Maps URL: https://www.google.com/maps/place/?q=place_id:manual_1777279364780
Website: Nenhum site encontrado
Links Adicionais:
Rede Social: https://www.instagram.com/englishwiththalita/
Fim Entrada.

Contexto: Analise os arquivos presentes neste projeto para entender o Protótipo de Landing Page já implementado. Sua missão é criar o Painel Administrativo integrado a esse código, utilizando a estrutura de seções, estilos e identidade visual que encontrar nos arquivos originais.

Tarefa:
Construa o Painel Administrativo em Laravel + Filament integrado ao protótipo da Landing Page. **REGRA DE OURO: Siga estritamente todas as regras definidas no código e no layout. O idioma OBRIGATÓRIO de tudo (código, banco de dados, comentários e interface) é o Português Brasileiro (pt-BR).** É estritamente necessário que você siga a ordem dos passos abaixo:

**Passo 1: Assimilação de Regras e Padrões (Leia e siga firmemente)**
Você deve ler e seguir ESTRITAMENTE todas as regras globais descritas nos arquivos Markdown da pasta `.agent/rules/` e as diretrizes do arquivo `.cursorrules`. **Sua primeira ação DEVE ser ler e registrar esses arquivos como suas regras de sistema fundamentais para este projeto.** Eles são o contrato absoluto de como o código e o layout devem ser construídos:
- O idioma OBRIGATÓRIO é pt-BR para TUDO: nomes de variáveis, classes, métodos, comentários, tabelas do banco de dados e interface do usuário. Proibido o uso de inglês em qualquer parte do projeto. 
- Arquitetura limpa (SOLID, DRY). Uso **exclusivo** de Tailwind CSS nativo.
- **SEO Imbatível**: Implemente metatags dinâmicas, Sitemap.xml, Robots.txt e Schema.org (JSON-LD) para LocalBusiness. 
- Documentação técnica completa da aplicação em `docs/README.md` (em pt-BR), detalhando a estrutura, modelos e fluxo de uso.
- Interface do painel Mobile-First real (layout de "App Shell") conforme descrito no Layout Style Guide específico deste lead. **A cor primária do painel DEVE ser idêntica à cor principal definida na identidade visual da Landing Page.**

**Passo 2: Injeção do BaseAdmin e Setup do Ambiente**
- Atualmente você está em um repositório contendo apenas os arquivos estáticos de frontend da Landing Page (criados via Lovable, por exemplo). O seu primeiro objetivo é **mesclar a estrutura backend do BaseAdmin** aqui:
  1. Clone o repositório base temporariamente: `git clone https://github.com/rodrigocoeio/BaseAdmin /tmp/BaseAdminTmp`
  2. Remova o vínculo git do repositório baixado: `rm -rf /tmp/BaseAdminTmp/.git`
  3. Mescle os arquivos para a raiz do seu projeto atual: `rsync -av /tmp/BaseAdminTmp/ ./`
  4. Limpe o diretório temporário: `rm -rf /tmp/BaseAdminTmp`
- **Resolução de Conflitos Frontend:** Caso existam arquivos idênticos na raiz (como `package.json` ou configurações do Vite originárias do frontend), mescle cuidadosamente as dependências mantendo a base do Laravel.
- **CRÍTICO:** Com os repositórios agora unidos, leia OBRIGATORIAMENTE o arquivo `.agent/rules/landing-page-guide.md` que acabara de ser copiado. Ele contém o guia passo a passo da nossa arquitetura.
- Conclua a instalação executando `composer install` e `npm install`.
- Prepare o banco: Copie `.env.example` para `.env`, rode `php artisan key:generate` e configure-o estritamente para SQLite (`DB_CONNECTION=sqlite`). O banco de dados geralmente estará no arquivo padrão de SQLite do Laravel 11.

**Passo 3: Arquitetura e Dinamismo**
- Crie Models e Migrations (com `SoftDeletes`) preparadas para armazenar todos os textos e fotos da Landing Page (Hero, Serviços, Preços, Depoimentos e dados de SEO). **Obrigatório**: Prepare campos específicos para SEO Meta (Title, Description) e Open Graph em cada recurso editável.
- **SEO 100% Dinâmico**: É obrigatório que todos os dados de SEO (Título, Descrição, OG Image, etc.) sejam lidos diretamente das tabelas de configuração do banco de dados e sejam totalmente editáveis pelo painel administrativo. **Proibido o uso de textos de SEO fixos (hardcoded) no código Blade.**
- **Contador de Visitas**: Crie uma migration para uma tabela de `acessos` (ou `visits`) que registre cada entrada única no site.
- Crie os Filament Resources equivalentes. **Importante:** Todos os `FileUpload` (campos de imagem) do Filament DEVEM ser configurados para usar a câmera nativa de dispositivos móveis, permitindo ao dono do estabelecimento bater fotos dos serviços na hora.

**Passo 4: Integração Front-End e UX do Painel**
- Transforme a Landing Page original estática em layouts, componentes e views do Blade. Faça o Controller ou componente Livewire puxar os dados do banco. **Importante:** Imagens de produtos, serviços, reviews e banners da Landing Page devem ser carregadas dinamicamente do banco de dados, para que o usuário possa alterá-las pelo painel administrativo quando quiser.
- **Dashboard Customizado**: Crie uma página de Dashboard personalizada para `English with Thalita`. O título do painel no navegador, na tela de login e no cabeçalho deve ser obrigatoriamente "**Painel English with Thalita**".
  - **Limpeza**: Remova obrigatoriamente os widgets padrão do Filament (`AccountWidget` e `FilamentInfoWidget`) para que a versão do Filament e links de docs não apareçam.
  - **Estatísticas**: Implemente um widget de **Gráfico de Tendência (Trend Chart)** para as visitas, além de `Stat` widgets criativos baseados no nicho (ex: Total de Produtos, Novos Contatos, Agendamentos Hoje, etc.).
- **Mobile App Shell**: Remova obrigatoriamente a sidebar e a **barra superior (topbar)** do Filament no mobile. Substitua pela Bottom Navigation Bar fixa.
- **Configurações Unificadas (Singleton)**: Recursos que gerenciam dados únicos (ex: Dados da Empresa, Redes Sociais) **NÃO** devem mostrar lista, permitir exclusão ou criação de múltiplos registros. Redirecione o usuário e permita **apenas a edição** do registro existente (ID 1).
- *Dica:* Crie uma View customizada via `FilamentView::registerRenderHook` para injetar a barra inferior apenas em mobile. Use `env(safe-area-inset-bottom)` no CSS para respeitar a barra de gestos do iPhone.

**Passo 5: Geração de Dados (Seeders)**
- Este passo é crítico: A LP não pode ficar "em branco" no primeiro acesso.
- Crie **Seeders Contextuais** que preencham o banco SQLite com os *exatos textos, URLs de imagens, serviços e informações de contato* presentes nos arquivos originais do protótipo da LP. **Isto inclui simular os uploads:** As imagens originais (produtos, serviços, reviews, etc) devem ser cadastradas no banco como se tivessem sido subidas pelo painel administrato (ex: associando os caminhos corretos nos campos de imagem), de modo que o usuário consiga visualizá-las, trocá-las ou apagá-las diretamente pelo painel.
- Finalize rodando `php artisan migrate:fresh --seed`.

**Passo 6: Limpeza Final e Otimização**
- **Remoção do Desnecessário**: Analise o projeto e remova **obrigatoriamente** todas as tabelas, models, migrations, recursos do Filament e entradas de menu herdadas do `BaseAdmin` que não estejam sendo utilizadas por este lead específico. O sistema deve ser enxuto e conter apenas o que o site realmente usa.
- **Frontend Original**: Remova todos os vestígios da implementação original (React, Playwright, tsconfig, etc.). O repositório deve conter apenas a estrutura padrão Laravel/Filament limpa.

Resultado Esperado:
Um código funcional onde o Filament renderize um dashboard limpo, com cara de aplicativo de banco ou rede social quando aberto no smartphone, pronto para ser "Adicionado à tela de início". Gere os scripts para a criação de todos os recursos (arquivos do Laravel, Blade, Filament, banco). A aplicação resultante DEVE terminar 100% pronta para rodar (executável sem erros), refletindo os dados da LP e com o painel plenamente utilizável.