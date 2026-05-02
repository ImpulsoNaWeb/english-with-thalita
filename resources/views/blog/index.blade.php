<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $nomeSite = \App\Models\Configuracao::get('nome_site', 'AdminPro');
        $corPrimariaH = \App\Models\Configuracao::get('cor_primaria', '#0ea5e9');
        $palette = \Filament\Support\Colors\Color::hex($corPrimariaH);
        $favicon = \App\Models\Configuracao::get('favicon_site');
        if (is_array($favicon)) $favicon = $favicon[0] ?? null;
        if ($favicon && !str_starts_with($favicon, 'configuracoes/')) $favicon = 'configuracoes/' . $favicon;
        $logo = \App\Models\Configuracao::get('logo_site');
        if (is_array($logo)) $logo = $logo[0] ?? null;
        if ($logo && !str_starts_with($logo, 'configuracoes/')) $logo = 'configuracoes/' . $logo;

        $primaryColor = $palette[600] ?? $corPrimariaH;
        $primaryDark  = $palette[700] ?? $corPrimariaH;
        $primaryLight = $palette[100] ?? '#e0f2fe';
        $primaryText  = $palette[600] ?? $corPrimariaH;
    @endphp

    <title>Blog | {{ $nomeSite }}</title>
    <meta name="description" content="Artigos, dicas e novidades do {{ $nomeSite }}. Fique por dentro das últimas publicações.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/blog') }}">
    <meta property="og:title" content="Blog | {{ $nomeSite }}">
    <meta property="og:description" content="Artigos, dicas e novidades do {{ $nomeSite }}.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/blog') }}">

    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            @foreach($palette as $weight => $val)
--color-primary-{{ $weight }}: {{ $val }};
            @endforeach
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        /* ── Hero ── */
        .blog-hero {
            margin-top: 65px;
            padding: 5rem 1.5rem 4rem;
            background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryDark }} 60%, #0f172a 100%);
            text-align: center;
            color: white;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            background: rgba(255,255,255,0.15);
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(4px);
        }
        .blog-hero h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            margin: 0 0 1rem;
            line-height: 1.2;
        }
        .blog-hero p {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.8);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }
        .search-form {
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }
        .search-form input {
            width: 100%;
            padding: 1rem 1.25rem;
            padding-right: 3.5rem;
            border-radius: 14px;
            border: none;
            font-size: 1rem;
            font-family: 'Outfit', sans-serif;
            box-shadow: 0 4px 24px rgba(0,0,0,0.15);
            outline: none;
            color: #0f172a;
        }
        .search-form button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 10px;
            border: none;
            background: {{ $primaryColor }};
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .search-form button:hover { background: {{ $primaryDark }}; }

        /* ── Container principal ── */
        .blog-main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 4rem 1.5rem;
        }
        .search-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            color: #475569;
            font-size: 0.95rem;
        }
        .search-info a { color: {{ $primaryColor }}; text-decoration: none; }
        .search-info a:hover { text-decoration: underline; }

        /* ── Estado vazio ── */
        .empty-state {
            text-align: center;
            padding: 6rem 1.5rem;
        }
        .empty-icon {
            width: 80px;
            height: 80px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .empty-state h2 { font-size: 1.5rem; font-weight: 700; color: #475569; margin-bottom: 0.75rem; }
        .empty-state p { color: #94a3b8; margin-bottom: 2rem; }
        .btn-primary {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: {{ $primaryColor }};
            color: white;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: {{ $primaryDark }}; }

        /* ── Grid de artigos ── */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .article-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: box-shadow 0.3s, transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        .article-card:hover {
            box-shadow: 0 16px 48px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }
        .card-image-wrap {
            display: block;
            height: 210px;
            overflow: hidden;
            text-decoration: none;
        }
        .card-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .article-card:hover .card-image-wrap img { transform: scale(1.05); }
        .card-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, {{ $primaryColor }}, {{ $primaryDark }});
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-placeholder svg { width: 60px; height: 60px; color: rgba(255,255,255,0.3); }

        .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .card-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #94a3b8;
            margin-bottom: 0.75rem;
        }
        .card-meta .dot { color: #cbd5e1; }
        .card-title {
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 0.75rem;
            flex: 1;
        }
        .card-title a {
            text-decoration: none;
            color: #0f172a;
            transition: color 0.2s;
        }
        .card-title a:hover { color: {{ $primaryColor }}; }
        .card-excerpt {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 1.25rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
            margin-top: auto;
        }
        .card-author { font-size: 0.8rem; font-weight: 600; color: #475569; }
        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: {{ $primaryColor }};
            text-decoration: none;
            transition: gap 0.2s;
        }
        .card-link:hover { gap: 0.5rem; }

        /* ── Paginação ── */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 4rem;
        }
        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .pagination a {
            background: white;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        .pagination a:hover {
            background: {{ $primaryLight }};
            border-color: {{ $primaryColor }};
            color: {{ $primaryColor }};
        }
        .pagination .page-current {
            background: {{ $primaryColor }};
            color: white;
            border: 1px solid {{ $primaryColor }};
        }
        .pagination .page-disabled {
            background: #f8fafc;
            color: #cbd5e1;
            border: 1px solid #e2e8f0;
            cursor: not-allowed;
        }

        /* ── Footer ── */
        .blog-footer {
            background: #0f172a;
            color: white;
            padding: 3rem 1.5rem;
            margin-top: 2rem;
        }
        .blog-footer .inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .blog-footer .inner {
                flex-direction: row;
                justify-content: space-between;
            }
        }
        .footer-brand { display: flex; align-items: center; gap: 0.75rem; font-weight: 700; font-size: 1.1rem; }
        .footer-nav { display: flex; align-items: center; gap: 1.5rem; }
        .footer-nav a { color: #94a3b8; text-decoration: none; font-size: 0.9rem; transition: color 0.2s; }
        .footer-nav a:hover { color: white; }
        .footer-nav a.active { color: {{ $primaryColor }}; font-weight: 600; }
        .footer-copy { color: #64748b; font-size: 0.85rem; }

        /* ── Mobile nav ── */
        @media (max-width: 767px) {
            .blog-hero { margin-top: 65px; }
        }
    </style>
</head>
<body>

    @include('partials.nav')

    <!-- Hero -->
    <section class="blog-hero">
        <div class="hero-badge">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            Blog & Conteúdo
        </div>

        <h1>Artigos & Insights</h1>
        <p>Conteúdo de qualidade para impulsionar seu negócio. Dicas, estratégias e novidades do nosso universo.</p>

        <form class="search-form" action="/blog" method="GET">
            <input
                type="text"
                name="busca"
                value="{{ $busca }}"
                placeholder="Buscar artigos..."
            >
            <button type="submit">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>
        </form>
    </section>

    <!-- Conteúdo principal -->
    <main class="blog-main">

        @if($busca)
            <div class="search-info">
                <span>
                    Resultados para <strong>"{{ $busca }}"</strong>
                    — {{ $paginas->total() }} {{ $paginas->total() === 1 ? 'artigo encontrado' : 'artigos encontrados' }}
                </span>
                <a href="/blog">Limpar busca</a>
            </div>
        @endif

        @if($paginas->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="40" height="40" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h2>Nenhum artigo encontrado</h2>
                <p>
                    @if($busca)
                        Tente outros termos de busca.
                    @else
                        Em breve teremos novos conteúdos. Fique ligado!
                    @endif
                </p>
                @if($busca)
                    <a href="/blog" class="btn-primary">Ver todos os artigos</a>
                @endif
            </div>
        @else
            <div class="articles-grid">
                @foreach($paginas as $post)
                    <article class="article-card">
                        <a href="{{ route('blog.show', $post->slug) }}" class="card-image-wrap">
                            @if($post->imagem_capa)
                                <img src="{{ asset('storage/' . $post->imagem_capa) }}" alt="{{ $post->titulo }}" loading="lazy">
                            @else
                                <div class="card-placeholder">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            @endif
                        </a>

                        <div class="card-body">
                            <div class="card-meta">
                                @if($post->publicado_em)
                                    <time datetime="{{ $post->publicado_em->toIso8601String() }}">
                                        {{ $post->publicado_em->format('d/m/Y') }}
                                    </time>
                                    <span class="dot">·</span>
                                @endif
                                <span>{{ $post->tempo_leitura }} min de leitura</span>
                                @if($post->visualizacoes > 0)
                                    <span class="dot">·</span>
                                    <span>{{ number_format($post->visualizacoes) }} visitas</span>
                                @endif
                            </div>

                            <div class="card-title">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->titulo }}</a>
                            </div>

                            @if($post->resumo)
                                <p class="card-excerpt">{{ $post->resumo }}</p>
                            @endif

                            <div class="card-footer">
                                <span class="card-author">{{ $post->autor ?? '' }}</span>
                                <a href="{{ route('blog.show', $post->slug) }}" class="card-link">
                                    Ler artigo
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Paginação -->
            @if($paginas->hasPages())
                <div class="pagination">
                    @if($paginas->onFirstPage())
                        <span class="page-disabled">← Anterior</span>
                    @else
                        <a href="{{ $paginas->previousPageUrl() }}">← Anterior</a>
                    @endif

                    @foreach($paginas->getUrlRange(max(1, $paginas->currentPage() - 2), min($paginas->lastPage(), $paginas->currentPage() + 2)) as $page => $url)
                        @if($page == $paginas->currentPage())
                            <span class="page-current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($paginas->hasMorePages())
                        <a href="{{ $paginas->nextPageUrl() }}">Próxima →</a>
                    @else
                        <span class="page-disabled">Próxima →</span>
                    @endif
                </div>
            @endif
        @endif
    </main>

    <!-- Footer -->
    <footer class="blog-footer">
        <div class="inner">
            <div class="footer-brand">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" style="height:28px;width:auto;filter:brightness(0) invert(1);" alt="Logo">
                @endif
                {{ $nomeSite }}
            </div>
            <nav class="footer-nav">
                <a href="/">Início</a>
                <a href="/blog" class="active">Blog</a>
                <a href="/#servicos">Serviços</a>
                <a href="/#contato">Contato</a>
            </nav>
            <span class="footer-copy">© {{ date('Y') }} {{ $nomeSite }}. Todos os direitos reservados.</span>
        </div>
    </footer>

</body>
</html>
