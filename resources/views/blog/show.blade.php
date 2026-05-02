<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $nomeSite    = \App\Models\Configuracao::get('nome_site', 'AdminPro');
        $corPrimariaH = \App\Models\Configuracao::get('cor_primaria', '#0ea5e9');
        $palette     = \Filament\Support\Colors\Color::hex($corPrimariaH);
        $primaryColor = $palette[600] ?? $corPrimariaH;
        $primaryDark  = $palette[700] ?? $corPrimariaH;
        $primaryLight = $palette[50]  ?? '#f0f9ff';

        $favicon = \App\Models\Configuracao::get('favicon_site');
        if (is_array($favicon)) $favicon = $favicon[0] ?? null;
        if ($favicon && !str_starts_with($favicon, 'configuracoes/')) $favicon = 'configuracoes/' . $favicon;

        $logo = \App\Models\Configuracao::get('logo_site');
        if (is_array($logo)) $logo = $logo[0] ?? null;
        if ($logo && !str_starts_with($logo, 'configuracoes/')) $logo = 'configuracoes/' . $logo;

        $seoTitulo    = $pagina->seo_titulo_efetivo . ' | ' . $nomeSite;
        $seoDescricao = $pagina->seo_descricao_efetiva;
        $ogImage      = $pagina->imagem_capa_url ?? '';
        $canonicalUrl = route('blog.show', $pagina->slug);
    @endphp

    <!-- SEO Primário -->
    <title>{{ $seoTitulo }}</title>
    <meta name="description" content="{{ $seoDescricao }}">
    @if($pagina->seo_keywords)
        <meta name="keywords" content="{{ $pagina->seo_keywords }}">
    @endif
    <meta name="author" content="{{ $pagina->autor ?? $nomeSite }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $seoTitulo }}">
    <meta property="og:description" content="{{ $seoDescricao }}">
    @if($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endif
    <meta property="og:site_name" content="{{ $nomeSite }}">
    @if($pagina->publicado_em)
        <meta property="article:published_time" content="{{ $pagina->publicado_em->toIso8601String() }}">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitulo }}">
    <meta name="twitter:description" content="{{ $seoDescricao }}">
    @if($ogImage)<meta name="twitter:image" content="{{ $ogImage }}">@endif

    <!-- Schema.org Article -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ addslashes($pagina->titulo) }}",
        "description": "{{ addslashes($seoDescricao) }}",
        "url": "{{ $canonicalUrl }}",
        @if($ogImage)"image": "{{ $ogImage }}",@endif
        @if($pagina->publicado_em)"datePublished": "{{ $pagina->publicado_em->toIso8601String() }}",@endif
        @if($pagina->atualizado_em)"dateModified": "{{ $pagina->atualizado_em->toIso8601String() }}",@endif
        "author": {"@type": "Person", "name": "{{ $pagina->autor ?? $nomeSite }}"},
        "publisher": {"@type": "Organization", "name": "{{ $nomeSite }}"}
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {"@type":"ListItem","position":1,"name":"Início","item":"{{ url('/') }}"},
            {"@type":"ListItem","position":2,"name":"Blog","item":"{{ route('blog.index') }}"},
            {"@type":"ListItem","position":3,"name":"{{ addslashes($pagina->titulo) }}","item":"{{ $canonicalUrl }}"}
        ]
    }
    </script>

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

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        /* ── Capa do artigo ── */
        .article-cover {
            margin-top: 65px;
            position: relative;
            height: 380px;
            overflow: hidden;
        }
        .article-cover img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .article-cover .cover-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.75) 0%, rgba(15,23,42,0.2) 60%, transparent 100%);
        }
        .article-cover-bar {
            margin-top: 65px;
            height: 8px;
            background: linear-gradient(90deg, {{ $primaryColor }}, {{ $primaryDark }});
        }

        /* ── Layout principal ── */
        .article-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1.5rem 5rem;
            position: relative;
        }

        /* ── Card do artigo ── */
        .article-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 8px 48px rgba(0,0,0,0.10);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            margin-top: -60px;
        }
        .article-header { padding: 2.5rem 2.5rem 0; }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .breadcrumb a { text-decoration: none; color: #94a3b8; transition: color 0.2s; }
        .breadcrumb a:hover { color: {{ $primaryColor }}; }
        .breadcrumb .sep { color: #cbd5e1; }
        .breadcrumb .current { color: #475569; font-weight: 500; }

        /* Tipo badge */
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: {{ $primaryLight }};
            color: {{ $primaryColor }};
            margin-bottom: 1.25rem;
        }

        /* Título */
        .article-title {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 700;
            line-height: 1.25;
            margin: 0 0 1.25rem;
            color: #0f172a;
        }

        /* Resumo */
        .article-lead {
            font-size: 1.15rem;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            padding-left: 1.25rem;
            border-left: 4px solid {{ $primaryColor }};
        }

        /* Meta */
        .article-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1.25rem;
            font-size: 0.875rem;
            color: #64748b;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .meta-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .meta-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: {{ $primaryLight }};
            color: {{ $primaryColor }};
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.875rem;
        }
        .meta-item { display: flex; align-items: center; gap: 0.35rem; }
        .meta-item svg { width: 15px; height: 15px; color: #94a3b8; }
        .share-group { display: flex; align-items: center; gap: 0.5rem; margin-left: auto; }
        .share-group span { font-size: 0.8rem; font-weight: 500; color: #94a3b8; }
        .share-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s;
            text-decoration: none;
        }
        .share-btn:hover { opacity: 0.85; }
        .share-btn svg { width: 15px; height: 15px; }

        /* ── Conteúdo do artigo ── */
        .article-content {
            padding: 2.5rem 2.5rem;
        }
        .prose-blog h2 {
            font-size: 1.65rem; font-weight: 700;
            margin: 2.5rem 0 1rem; color: #0f172a; line-height: 1.3;
        }
        .prose-blog h3 {
            font-size: 1.3rem; font-weight: 600;
            margin: 2rem 0 0.75rem; color: #1e293b;
        }
        .prose-blog p {
            font-size: 1.075rem; line-height: 1.85;
            color: #334155; margin-bottom: 1.5rem;
        }
        .prose-blog a { color: {{ $primaryColor }}; text-decoration: underline; text-underline-offset: 3px; }
        .prose-blog ul, .prose-blog ol {
            padding-left: 1.5rem; margin-bottom: 1.5rem;
            color: #334155; font-size: 1.05rem; line-height: 1.8;
        }
        .prose-blog li { margin-bottom: 0.5rem; }
        .prose-blog blockquote {
            border-left: 4px solid {{ $primaryColor }};
            padding: 1rem 1.5rem;
            background: {{ $primaryLight }};
            margin: 2rem 0;
            border-radius: 0 1rem 1rem 0;
            font-style: italic; color: #475569;
        }
        .prose-blog pre {
            background: #0f172a; color: #e2e8f0;
            border-radius: 12px; padding: 1.5rem;
            overflow-x: auto; margin-bottom: 1.5rem;
        }
        .prose-blog code {
            background: #f1f5f9; color: #0f172a;
            border-radius: 4px; padding: 0.15em 0.4em;
            font-size: 0.9em;
        }
        .prose-blog pre code { background: transparent; color: #e2e8f0; padding: 0; }
        .prose-blog img {
            border-radius: 12px; margin: 2rem 0;
            max-width: 100%; box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        }
        .prose-blog strong { color: #0f172a; font-weight: 700; }
        .prose-blog hr { border: none; border-top: 1px solid #e2e8f0; margin: 2.5rem 0; }
        .prose-blog table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; border-radius: 12px; overflow: hidden; }
        .prose-blog th { background: {{ $primaryColor }}; color: white; padding: 0.75rem 1rem; text-align: left; }
        .prose-blog td { padding: 0.75rem 1rem; border-bottom: 1px solid #e2e8f0; }
        .prose-blog tr:last-child td { border-bottom: none; }
        .prose-blog tr:nth-child(even) td { background: #f8fafc; }

        /* ── Footer do artigo ── */
        .article-footer {
            padding: 1.5rem 2.5rem 2.5rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .article-footer .back-link {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.6rem 1.25rem;
            background: #f1f5f9;
            color: #475569;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .article-footer .back-link:hover { background: {{ $primaryLight }}; color: {{ $primaryColor }}; }
        .article-footer .author-info p { font-size: 0.85rem; color: #64748b; margin: 0; }

        /* ── Artigos relacionados ── */
        .related-section {
            max-width: 900px;
            margin: 3rem auto 0;
            padding: 0 1.5rem;
        }
        .related-section h2 {
            font-size: 1.5rem; font-weight: 700;
            margin-bottom: 1.5rem; color: #0f172a;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
        }
        .related-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            text-decoration: none;
            display: flex; flex-direction: column;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .related-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.10); transform: translateY(-2px); }
        .related-card .thumb {
            height: 130px; overflow: hidden;
        }
        .related-card .thumb img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.4s;
        }
        .related-card:hover .thumb img { transform: scale(1.05); }
        .related-card .thumb-placeholder {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, {{ $primaryColor }}, {{ $primaryDark }});
            display: flex; align-items: center; justify-content: center;
        }
        .related-card .thumb-placeholder svg { width: 36px; height: 36px; color: rgba(255,255,255,0.3); }
        .related-card .info { padding: 1rem; flex: 1; display: flex; flex-direction: column; }
        .related-card h3 {
            font-size: 0.925rem; font-weight: 700;
            color: #0f172a; line-height: 1.4;
            margin: 0 0 auto;
        }
        .related-card .date {
            font-size: 0.75rem; color: #94a3b8;
            margin-top: 0.75rem;
        }

        /* ── Progress bar ── */
        #progress-bar {
            position: fixed; top: 0; left: 0;
            height: 3px; width: 0%;
            background: linear-gradient(90deg, {{ $primaryColor }}, {{ $primaryDark }});
            z-index: 100;
            transition: width 0.1s linear;
        }

        /* ── Footer ── */
        .blog-footer {
            background: #0f172a; color: white;
            padding: 3rem 1.5rem; margin-top: 3rem;
        }
        .blog-footer .inner {
            max-width: 1280px; margin: 0 auto;
            display: flex; flex-direction: column;
            align-items: center; gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .blog-footer .inner { flex-direction: row; justify-content: space-between; }
        }
        .footer-brand { display: flex; align-items: center; gap: 0.75rem; font-weight: 700; }
        .footer-nav { display: flex; gap: 1.5rem; }
        .footer-nav a { color: #94a3b8; text-decoration: none; font-size: 0.9rem; transition: color 0.2s; }
        .footer-nav a:hover { color: white; }
        .footer-nav a.active { color: {{ $primaryColor }}; font-weight: 600; }
        .footer-copy { color: #64748b; font-size: 0.85rem; }

        @media (max-width: 767px) {
            .article-header, .article-content, .article-footer { padding-left: 1.25rem; padding-right: 1.25rem; }
            .article-cover { height: 240px; }
            .article-card { margin-top: -30px; }
            .share-group { display: none; }
        }
    </style>
</head>
<body>

    <!-- Progress bar de leitura -->
    <div id="progress-bar"></div>

    @include('partials.nav')

    <!-- Imagem de capa -->
    @if($pagina->imagem_capa)
        <div class="article-cover">
            <img src="{{ asset('storage/' . $pagina->imagem_capa) }}" alt="{{ $pagina->titulo }}">
            <div class="cover-overlay"></div>
        </div>
    @else
        <div class="article-cover-bar"></div>
    @endif

    <!-- Layout principal -->
    <main class="article-wrapper">
        <div class="article-card">

            <!-- Cabeçalho -->
            <header class="article-header">
                <!-- Breadcrumb -->
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="/">Início</a>
                    <span class="sep">›</span>
                    <a href="/blog">Blog</a>
                    <span class="sep">›</span>
                    <span class="current">{{ \Illuminate\Support\Str::limit($pagina->titulo, 40) }}</span>
                </nav>

                <!-- Tipo badge -->
                <div class="type-badge">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    {{ ucfirst($pagina->tipo) }}
                </div>

                <h1 class="article-title">{{ $pagina->titulo }}</h1>

                @if($pagina->resumo)
                    <p class="article-lead">{{ $pagina->resumo }}</p>
                @endif

                <!-- Meta -->
                <div class="article-meta">
                    @if($pagina->autor)
                        <div class="meta-author">
                            <div class="meta-avatar">{{ strtoupper(substr($pagina->autor, 0, 1)) }}</div>
                            <span style="font-weight:600;color:#0f172a;">{{ $pagina->autor }}</span>
                        </div>
                    @endif

                    @if($pagina->publicado_em)
                        <div class="meta-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <time datetime="{{ $pagina->publicado_em->toIso8601String() }}">
                                {{ $pagina->publicado_em->format('d/m/Y') }}
                            </time>
                        </div>
                    @endif

                    <div class="meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $pagina->tempo_leitura }} min de leitura</span>
                    </div>

                    <div class="meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ number_format($pagina->visualizacoes) }}</span>
                    </div>

                    <!-- Compartilhar -->
                    <div class="share-group">
                        <span>Compartilhar:</span>
                        <a href="https://wa.me/?text={{ urlencode($pagina->titulo . ' — ' . $canonicalUrl) }}" target="_blank" rel="noopener" class="share-btn" style="background:#25D366;" title="WhatsApp">
                            <svg fill="white" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.996-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.143c1.589.943 3.147 1.416 4.674 1.417 5.432 0 9.851-4.419 9.854-9.851.002-2.63-1.023-5.105-2.887-6.97s-4.341-2.889-6.972-2.89c-5.433 0-9.854 4.42-9.856 9.852-.001 1.916.536 3.731 1.554 5.275l-1.016 3.71 3.849-1.009z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($canonicalUrl) }}" target="_blank" rel="noopener" class="share-btn" style="background:#0A66C2;" title="LinkedIn">
                            <svg fill="white" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 23.999 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Conteúdo -->
            <div class="article-content">
                <div class="prose-blog">
                    {!! $pagina->conteudo !!}
                </div>
            </div>

            <!-- Footer do artigo -->
            <div class="article-footer">
                <div class="author-info">
                    @if($pagina->autor)
                        <p>Escrito por <strong>{{ $pagina->autor }}</strong></p>
                    @endif
                    @if($pagina->atualizado_em && $pagina->atualizado_em != $pagina->criado_em)
                        <p style="font-size:0.8rem;color:#94a3b8;">Atualizado em {{ $pagina->atualizado_em->format('d/m/Y') }}</p>
                    @endif
                </div>
                <a href="/blog" class="back-link">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Voltar ao Blog
                </a>
            </div>
        </div>

        <!-- Artigos relacionados -->
        @if($recentes->isNotEmpty())
            <section class="related-section">
                <h2>Mais artigos para você</h2>
                <div class="related-grid">
                    @foreach($recentes as $post)
                        <a href="{{ route('blog.show', $post->slug) }}" class="related-card">
                            <div class="thumb">
                                @if($post->imagem_capa)
                                    <img src="{{ asset('storage/' . $post->imagem_capa) }}" alt="{{ $post->titulo }}" loading="lazy">
                                @else
                                    <div class="thumb-placeholder">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="info">
                                <h3>{{ $post->titulo }}</h3>
                                @if($post->publicado_em)
                                    <span class="date">{{ $post->publicado_em->format('d/m/Y') }} · {{ $post->tempo_leitura }} min</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
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

    <script>
        // Progress bar de leitura
        const bar = document.getElementById('progress-bar');
        window.addEventListener('scroll', () => {
            const prose = document.querySelector('.prose-blog');
            if (!prose) return;
            const rect  = prose.getBoundingClientRect();
            const total = prose.offsetHeight;
            const scrolled = Math.max(0, -rect.top);
            const pct = Math.min(100, (scrolled / total) * 100);
            bar.style.width = pct + '%';
        });
    </script>
</body>
</html>
