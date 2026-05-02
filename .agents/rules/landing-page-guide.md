# Guia de Implementação de Landing Pages (Para Antigravity)

Este documento dita as regras e o fluxo de trabalho obrigatórios para quando você, Antigravity, for solicitado a criar ou refatorar Landing Pages utilizando o BaseAdmin (Laravel + Filament).

## 1. Regras de Design e Estilo
- **Mobile-First e Alta Conversão:** A página deve parecer e se comportar como um App (PWA). Botões grandes, áreas de toque generosas (mínimo 48px), cantos arredondados (`rounded-xl` a `rounded-[2.5rem]`).
- **Tailwind CSS e Vanilla JS:** Toda a estilização deve ser feita usando utilitários do Tailwind CSS. Nenhuma folha de estilo customizada adicional a menos que extremamente necessário. A interatividade deve usar apenas Vanilla Javascript simples ao pé da página.
- **Aesthetic Premium e "Uau Factor":** Evitar templates chatos ou estáticos. Use sombras profundas (`shadow-2xl`, `shadow-primary-200`), blur effects do Tailwind (`backdrop-blur`, `glass`), gradientes e animações suaves (`transition-all duration-300`, `hover:-translate-y-1`, `hover:scale-105`).
- **Paleta Dinâmica Integrada (CRÍTICO):** A cor primária deve ser lida do modelo Configuracao. O arquivo `welcome.blade.php` deve renderizar no `<head>` a injeção da variável CSS baseada na escolha dinâmica:
  ```php
  @php
      $corPrimariaH = \App\Models\Configuracao::get('cor_primaria', '#0ea5e9');
      $palette = \Filament\Support\Colors\Color::hex($corPrimariaH);
  @endphp
  <style>
      :root {
          @foreach($palette as $weight => $val)
              --color-primary-{{ $weight }}: {{ $val }};
          @endforeach
      }
  </style>
  ```
  Isso permite que você use `text-primary-600`, `bg-primary-500` por toda a página.

## 2. Dynamic Content Binding (Conteúdo Dinâmico)
Nada deve ser estático. Todos os textos, logos e contatos devem vir do banco de dados na landing page, geralmente através do `welcome.blade.php`, para que o gestor possa alterar pelo Filament.
- **SEO & Meta Tags:** Puxar título, descrição e favicon da `\App\Models\Configuracao`. Exemplo: `<title>{{ \App\Models\Configuracao::get('seo_titulo', 'Nome Padrão') }}</title>`.
- **Assets (Logos e Imagens):** Sempre verificar e formatar as URIs corretamente usando o helper `asset()`. Cuidado para lidar com o Formato de array que o Filament às vezes produz para uploads (ex: `$logo[0]`).
- **Contatos e Rodapé:** Botões de WhatsApp, links de Instagram/Facebook, endereço e telefones também devem ser mapeados utilizando `\App\Models\Configuracao::get('...')`.

## 3. Estruturação e Componentização (One-Page Layout)
- O layout final geralmente é uma Single Page contendo ID's (`id="inicio"`, `id="servicos"`, `id="produtos"`, `id="contato"`) que correspondam à navegação dinâmica `<nav>`.
- **Componentização Blade é Obrigatória:** Nunca deixe um arquivo ser gigantesco (ex: `welcome.blade.php` com milhares de linhas). Isole e componentize de forma inteligente (ex: isole cabeçalho, hero, seções específicas de serviços, rodapé) colocando em pastas coerentes (como `resources/views/components/landing/`) e chame via `<x-landing.hero />` ou `@include('...')`.
- Renderizar seções dinâmicas iterando os modelos se existirem (ex: `@foreach(\App\Models\Servico::limit(3)->get() as $servico)`), caso contrário defina uma base estrutural limpa e adicione seeders de contexto.

## 4. Banco de Dados e Seeders (Context-Aware)
- O BaseAdmin frequentemente usa SQLite (configurado por padrão). Assegure a compatibilidade.
- **Seeders Profissionais em PT-BR:** Se for solicitado um novo negócio (ex: "Chaveiro", "Barbearia"), SEMPRE crie seeders automáticos e popule `Servicos`, `Produtos`, `Depoimentos` e `Configuracoes` base de SEO e layout de forma realista. 
- NADA de Lorem Ipsum. Utilize textos humanizados e focados em cópia de vendas.

## 5. Práticas de Código e Idioma da IA
- Toda a documentação e os comentários do código gerados por você devem ser em **Português do Brasil**.
- Evite placeholders de imagens quebradas: em protótipos, use `unsplash` (`https://images.unsplash.com/...`) ou `pravatar` com parâmetros claros se imagens provisórias forem aceitáveis/úteis.
- **Não prometa sem aprovação do usuário**, utilize tom neutro/profissional. (Consulte "user_global" rules). Nenhuma piada sobre "F5" ou "foguete 🚀" no encerramento das respostas.

## 6. Fluxo de Conversão de IAs Externas (Ex: Lovable)
- Frequentemente as telas e landings pages vêm desenhadas de IAs como o *Lovable* que geram código nativamente em **React (JSX/TSX)** combinado com Tailwind. 
- Quando um código React for fornecido: **Sua função é converter totalmente o JSX/TSX para HTML nativo com Blade (Laravel)**. Você deve extrair todas as classes do Tailwind e transpor para componentes do Laravel (Blade components), removendo estados do React (`useState`, `useEffect`), Hooks e substituindo as variações dinâmicas de estilo pelas lógicas do servidor Blade (`@if`, `@foreach`, injeção do modelo `Configuracao`, usando Alpine.js ou Vanilla JS em substituição a lógicas exclusivas do front-end apenas se for indispensável).
