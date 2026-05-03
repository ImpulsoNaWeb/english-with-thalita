@php
    $_nomeSite = \App\Models\Configuracao::get('nome_site', 'AdminPro');
    $_logo = \App\Models\Configuracao::get('logo_site');
    if (is_array($_logo)) $_logo = $_logo[0] ?? null;
    if ($_logo && !str_starts_with($_logo, 'configuracoes/')) $_logo = 'configuracoes/' . $_logo;
    $_currentPath = request()->path();
@endphp

<style>
    /* ── Nav Compartilhado ── */
    .site-header {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 50;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        box-shadow: 0 1px 12px rgba(0, 0, 0, 0.06);
        transition: padding 0.3s, box-shadow 0.3s;
    }
    .site-header.scrolled {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
    }
    .site-header__inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
    }
    /* Logo */
    .site-header__brand {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        color: #0f172a;
        flex-shrink: 0;
    }
    .site-header__logo-icon {
        width: 38px; height: 38px;
        border-radius: 12px;
        background: var(--color-primary-600, #0ea5e9);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px color-mix(in srgb, var(--color-primary-600, #0ea5e9) 30%, transparent);
        transition: transform 0.3s;
    }
    .site-header__brand:hover .site-header__logo-icon { transform: rotate(12deg); }
    .site-header__logo-icon svg { width: 18px; height: 18px; color: white; }
    .site-header__site-name { font-size: 1.2rem; font-weight: 700; letter-spacing: -0.02em; }
    /* Nav links */
    .site-header__nav {
        display: flex;
        align-items: center;
        gap: 2rem;
        font-weight: 500;
        font-size: 0.95rem;
    }
    .site-header__nav a {
        text-decoration: none;
        color: #475569;
        transition: color 0.2s;
        position: relative;
    }
    .site-header__nav a:hover { color: var(--color-primary-600, #0ea5e9); }
    .site-header__nav a.nav-active { color: var(--color-primary-600, #0ea5e9); font-weight: 600; }
    /* CTA buttons */
    .site-header__actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }
    .btn-nav-ghost {
        padding: 0.5rem 1.1rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        color: #0f172a;
        background: white;
        transition: background 0.2s, border-color 0.2s;
    }
    .btn-nav-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }
    .btn-nav-primary {
        padding: 0.5rem 1.1rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        color: white;
        background: var(--color-primary-600, #0ea5e9);
        box-shadow: 0 4px 14px color-mix(in srgb, var(--color-primary-600, #0ea5e9) 35%, transparent);
        transition: background 0.2s, transform 0.2s;
    }
    .btn-nav-primary:hover {
        background: var(--color-primary-700, #0284c7);
        transform: translateY(-1px);
    }
    /* Mobile: esconde links */
    @media (max-width: 767px) {
        .site-header__nav { display: none; }
        .btn-nav-primary { display: none; }
    }
</style>

<header class="site-header" id="site-header">
    <div class="site-header__inner">
        <!-- Marca / Logo -->
        <a href="/" class="site-header__brand">
            @if($_logo)
                <img src="{{ asset('storage/' . $_logo) }}" style="height: 36px; width: auto;" alt="{{ $_nomeSite }}">
            @else
                <div class="site-header__logo-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            @endif
            <span class="site-header__site-name">{{ $_nomeSite }}</span>
        </a>

        <!-- Links de navegação -->
        <nav class="site-header__nav">
            <a href="/" @if($_currentPath === '/') class="nav-active" @endif>Início</a>
            <a href="/#servicos">Planos de Estudo</a>
            <a href="/#catalogo">Produtos</a>
            <a href="/#depoimentos">Depoimentos</a>
            <a href="/blog" @if(str_starts_with($_currentPath, 'blog')) class="nav-active" @endif>Blog</a>
        </nav>

        <!-- Ações -->
        <div class="site-header__actions">
            <a href="/admin/login" class="btn-nav-ghost">Painel</a>
            <a href="/#contato" class="btn-nav-primary">Começar</a>
        </div>
    </div>
</header>

<script>
    (function () {
        const hdr = document.getElementById('site-header');
        if (!hdr) return;
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                hdr.classList.add('scrolled');
            } else {
                hdr.classList.remove('scrolled');
            }
        }, { passive: true });
    })();
</script>
