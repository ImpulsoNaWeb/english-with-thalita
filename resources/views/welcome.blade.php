@php
    $c = \App\Models\Configuracao::all()->keyBy('chave');
    $diferenciais = $c->has('diferenciais') ? $c['diferenciais']->valor : [];
    if (is_string($diferenciais)) $diferenciais = json_decode($diferenciais, true) ?? [];
    
    $servicos = \App\Models\Servico::where('esta_ativo', true)->orderBy('ordem')->get();
    $depoimentos = \App\Models\Depoimento::where('esta_ativo', true)->orderBy('ordem')->get();

    $dbTranslations = ['pt' => [], 'en' => []];
    foreach($c as $key => $model) {
        if ($key === 'titulo_hero') {
            $dbTranslations['pt']['c_' . $key] = nl2br(e($model->getTranslation('valor', 'pt_BR') ?? "English\\nwith\\nThalita"));
            $dbTranslations['en']['c_' . $key] = nl2br(e($model->getTranslation('valor', 'en') ?? "English\\nwith\\nThalita"));
        } else {
            $dbTranslations['pt']['c_' . $key] = $model->getTranslation('valor', 'pt_BR') ?? '';
            $dbTranslations['en']['c_' . $key] = $model->getTranslation('valor', 'en') ?? '';
        }
    }
    
    if ($c->has('diferenciais')) {
        $val_pt = $c['diferenciais']->getTranslation('valor', 'pt_BR') ?? '[]';
        $difs_pt = is_string($val_pt) ? json_decode($val_pt, true) : $val_pt;
        if (!is_array($difs_pt)) $difs_pt = [];

        $val_en = $c['diferenciais']->getTranslation('valor', 'en') ?? '[]';
        $difs_en = is_string($val_en) ? json_decode($val_en, true) : $val_en;
        if (!is_array($difs_en)) $difs_en = [];

        foreach($diferenciais as $index => $dif) {
            $dbTranslations['pt']['dif_titulo_' . $index] = $difs_pt[$index]['titulo'] ?? '';
            $dbTranslations['en']['dif_titulo_' . $index] = $difs_en[$index]['titulo'] ?? '';
            $dbTranslations['pt']['dif_desc_' . $index] = $difs_pt[$index]['descricao'] ?? '';
            $dbTranslations['en']['dif_desc_' . $index] = $difs_en[$index]['descricao'] ?? '';
        }
    }

    foreach($servicos as $index => $servico) {
        $dbTranslations['pt']['serv_titulo_' . $index] = $servico->getTranslation('nome', 'pt_BR') ?? '';
        $dbTranslations['en']['serv_titulo_' . $index] = $servico->getTranslation('nome', 'en') ?? '';
        $dbTranslations['pt']['serv_desc_' . $index] = $servico->getTranslation('descricao', 'pt_BR') ?? '';
        $dbTranslations['en']['serv_desc_' . $index] = $servico->getTranslation('descricao', 'en') ?? '';
        $dbTranslations['pt']['serv_badge_' . $index] = $servico->getTranslation('badge', 'pt_BR') ?? '';
        $dbTranslations['en']['serv_badge_' . $index] = $servico->getTranslation('badge', 'en') ?? '';
        $dbTranslations['pt']['serv_precos_' . $index] = $servico->getTranslation('tabela_precos', 'pt_BR') ?? '';
        $dbTranslations['en']['serv_precos_' . $index] = $servico->getTranslation('tabela_precos', 'en') ?? '';
    }

    foreach($depoimentos as $index => $depo) {
        $dbTranslations['pt']['depo_nome_' . $index] = $depo->nome_autor;
        $dbTranslations['en']['depo_nome_' . $index] = $depo->nome_autor;
        $dbTranslations['pt']['depo_cargo_' . $index] = $depo->getTranslation('cargo_autor', 'pt_BR') ?? '';
        $dbTranslations['en']['depo_cargo_' . $index] = $depo->getTranslation('cargo_autor', 'en') ?? '';
        $dbTranslations['pt']['depo_conteudo_' . $index] = '"' . ($depo->getTranslation('conteudo', 'pt_BR') ?? '') . '"';
        $dbTranslations['en']['depo_conteudo_' . $index] = '"' . ($depo->getTranslation('conteudo', 'en') ?? '') . '"';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="page_title">{{ $c['seo_titulo']->valor ?? 'English with Thalita' }}</title>
    <meta name="description" data-i18n="c_seo_descricao" content="{{ $c['seo_descricao']->valor ?? 'Professora de inglês para quem quer se comunicar com confiança e fluência real.' }}">
    
    @if($c->has('favicon_site') && $c['favicon_site']->valor)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . (is_array($c['favicon_site']->valor) ? $c['favicon_site']->valor[0] : $c['favicon_site']->valor)) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            bg: '#f2ebcd', // Fundo cream
                            dark: '#494b46', // Texto cinza/marrom escuro
                            card: '#f4c07c', // Pêssego/Laranja claro
                            cardLight: '#ffffff', // Branco
                            accent: '{{ $c['cor_primaria']->valor ?? '#1d8985' }}', // Dinâmico do Banco
                            accentHover: '{{ $c['cor_primaria']->valor ?? '#1d8985' }}',
                            alert: '#e59a35', // Mostarda
                            red: '#954942', // Vermelho escuro
                            orange: '#cc5b33' // Laranja escuro
                        }
                    },
                    boxShadow: {
                        'retro': '4px 4px 0 0 #494b46',
                        'retro-lg': '8px 8px 0 0 #494b46',
                        'retro-sm': '2px 2px 0 0 #494b46',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-nav {
            background: rgba(242, 235, 205, 0.95);
            backdrop-filter: blur(12px);
        }

        /* Retro Waves Decoration */
        .retro-waves {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 300px;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .wave-line {
            position: absolute;
            left: -50px;
            bottom: -50px;
            width: 150px;
            height: 100%;
            border-radius: 100px;
            transform: rotate(20deg);
        }
    </style>
</head>

<body x-data="{ modalOpen: false, modalTitle: '', modalContent: '' }"
    class="bg-brand-bg text-brand-dark antialiased selection:bg-brand-accent selection:text-white flex flex-col min-h-screen relative overflow-x-hidden">

    <!-- Retro Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -left-32 -top-32 w-96 h-96 bg-brand-red rounded-[100px] rotate-12 opacity-80"></div>
        <div class="absolute -right-10 top-20 w-64 h-64 bg-brand-alert rounded-[80px] -rotate-12 opacity-80"></div>

        <!-- Retro lines -->
        <div
            class="absolute left-10 bottom-0 h-3/4 w-8 bg-brand-accent rounded-t-full rotate-[-15deg] origin-bottom -translate-x-10">
        </div>
        <div
            class="absolute left-24 bottom-0 h-2/3 w-8 bg-brand-red rounded-t-full rotate-[-15deg] origin-bottom -translate-x-10">
        </div>
        <div
            class="absolute left-36 bottom-0 h-1/2 w-8 bg-brand-alert rounded-t-full rotate-[-15deg] origin-bottom -translate-x-10">
        </div>
    </div>

    <!-- Header / Nav -->
    <header class="fixed w-full top-0 z-50 glass-nav border-b-2 border-brand-dark transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="#"
                        class="text-2xl font-black tracking-tighter text-brand-dark hover:text-brand-accent transition-colors">
                        @php
                            $logoPath = $c->has('logo_site') ? $c['logo_site']->valor : null;
                            if (is_array($logoPath)) $logoPath = $logoPath[0] ?? null;
                        @endphp

                        @if($logoPath)
                            <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $c['nome_site']->valor ?? 'Logo' }}" class="h-10 w-auto">
                        @else
                            <span data-i18n="c_nome_site">{{ $c['nome_site']->valor ?? 'English with Thalita' }}</span>
                        @endif
                    </a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#sobre" data-i18n="nav_sobre"
                        class="text-sm font-bold text-brand-dark hover:text-brand-accent transition-colors">Sobre</a>
                    <a href="#servicos" data-i18n="nav_planos"
                        class="text-sm font-bold text-brand-dark hover:text-brand-accent transition-colors">Planos de
                        Aula</a>
                    <a href="#depoimentos" data-i18n="nav_depoimentos"
                        class="text-sm font-bold text-brand-dark hover:text-brand-accent transition-colors">Depoimentos</a>
                    <a href="#contato" data-i18n="nav_contato"
                        class="text-sm font-bold text-brand-dark hover:text-brand-accent transition-colors">Contato</a>
                </nav>
                <div class="hidden md:flex items-center gap-4">
                    <button class="lang-toggle font-bold text-brand-dark bg-brand-bg py-2 px-3 rounded-xl border-2 border-brand-dark shadow-retro-sm hover:bg-brand-card transition-all active:scale-95 flex items-center gap-1 text-xs uppercase tracking-wider cursor-pointer"
                        aria-label="Mudar idioma">
                        <span class="lang-indicator-pt text-brand-accent pointer-events-none">PT</span>
                        <span class="text-brand-dark/30 mx-1 pointer-events-none">/</span>
                        <span class="lang-indicator-en text-brand-dark/50 pointer-events-none">EN</span>
                    </button>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['whatsapp_contato']->valor ?? '5519997799589') }}?text=Ol%C3%A1,%20gostaria%20de%20agendar%20uma%20aula!" target="_blank" rel="noopener noreferrer"
                        class="bg-brand-accent text-white font-black py-2.5 px-6 rounded-xl border-2 border-brand-dark shadow-retro hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-retro-sm transition-all active:scale-95 flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span data-i18n="nav_cta">Agendar Aula</span>
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center gap-3">
                    <button class="lang-toggle font-bold text-brand-dark bg-brand-bg py-1.5 px-2 rounded-lg border-2 border-brand-dark shadow-retro-sm hover:bg-brand-card transition-all active:scale-95 flex items-center gap-1 text-[10px] uppercase tracking-wider cursor-pointer"
                        aria-label="Mudar idioma">
                        <span class="lang-indicator-pt text-brand-accent pointer-events-none">PT</span>
                        <span class="text-brand-dark/30 pointer-events-none">/</span>
                        <span class="lang-indicator-en text-brand-dark/50 pointer-events-none">EN</span>
                    </button>
                    <button id="mobile-menu-btn"
                        class="text-brand-dark hover:text-brand-accent focus:outline-none p-2 border-2 border-brand-dark rounded-lg shadow-retro-sm">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-brand-bg border-b-2 border-brand-dark absolute w-full left-0 top-20">
            <div class="px-4 pt-2 pb-6 space-y-2 flex flex-col">
                <a href="#sobre" data-i18n="nav_sobre"
                    class="block px-3 py-3 rounded-md text-base font-bold text-brand-dark hover:bg-brand-card transition-colors border-2 border-transparent hover:border-brand-dark hover:shadow-retro-sm">Sobre</a>
                <a href="#servicos" data-i18n="nav_planos"
                    class="block px-3 py-3 rounded-md text-base font-bold text-brand-dark hover:bg-brand-card transition-colors border-2 border-transparent hover:border-brand-dark hover:shadow-retro-sm">Planos
                    de Aula</a>
                <a href="#depoimentos" data-i18n="nav_depoimentos"
                    class="block px-3 py-3 rounded-md text-base font-bold text-brand-dark hover:bg-brand-card transition-colors border-2 border-transparent hover:border-brand-dark hover:shadow-retro-sm">Depoimentos</a>
                <a href="#contato" data-i18n="nav_contato"
                    class="block px-3 py-3 rounded-md text-base font-bold text-brand-dark hover:bg-brand-card transition-colors border-2 border-transparent hover:border-brand-dark hover:shadow-retro-sm">Contato</a>
                <a href="https://wa.me/5519997799589?text=Ol%C3%A1,%20gostaria%20de%20agendar%20uma%20aula!" target="_blank" rel="noopener noreferrer" data-i18n="mob_nav_cta"
                    class="mt-4 block text-center bg-brand-accent text-white font-black py-3 px-4 rounded-xl border-2 border-brand-dark shadow-retro active:translate-x-[2px] active:translate-y-[2px] active:shadow-retro-sm transition-all">
                    Fale no WhatsApp
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow pt-20 relative z-10">
        <!-- Hero Section -->
        <section class="relative pt-16 pb-20 lg:pt-32 lg:pb-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">

                <div class="max-w-sm md:max-w-2xl flex flex-col items-center text-center">
                    <!-- Retro Title Card -->
                    <div
                        class="bg-brand-card border-[3px] border-brand-dark rounded-3xl shadow-retro-lg py-8 px-10 md:py-12 md:px-16 inline-block mb-10 transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                        <h1 data-i18n="c_titulo_hero"
                            class="text-5xl md:text-7xl lg:text-[80px] font-black text-brand-dark leading-[1.1] tracking-tight">
                            {!! nl2br(e($c['titulo_hero']->valor ?? "English\nwith\nThalita")) !!}
                        </h1>
                    </div>

                    <p data-i18n="c_subtitulo_hero"
                        class="text-xl md:text-2xl font-bold text-brand-dark mb-10 leading-snug max-w-2xl text-balance">
                        {{ $c['subtitulo_hero']->valor ?? 'Professora de inglês para quem quer se comunicar com confiança e fluência real' }}
                    </p>

                    <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
                        <a href="#contato"
                            class="whitespace-nowrap bg-[#25D366] text-brand-dark font-black py-4 px-8 rounded-2xl border-[3px] border-brand-dark shadow-retro hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-retro-sm transition-all text-xl flex items-center justify-center gap-3">
                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                            <span data-i18n="c_texto_botao_hero">{{ $c['texto_botao_hero']->valor ?? 'Quero Aprender' }}</span>
                        </a>
                        <span
                            class="font-bold text-brand-dark text-base flex items-center gap-2 cursor-default animate-bounce whitespace-nowrap"
                            data-i18n="hero_swipe">
                            deslize para me conhecer <i class="fa-solid fa-arrow-down"></i>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sobre / Diferenciais -->
        <section id="sobre" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="order-2 lg:order-1 relative">
                        <div
                            class="absolute inset-0 bg-brand-orange rounded-3xl transform translate-x-4 translate-y-4 border-[3px] border-brand-dark">
                        </div>
                        @php
                            $fotoSobre = $c['foto_sobre']->valor ?? 'https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                            if (is_array($fotoSobre)) $fotoSobre = $fotoSobre[0] ?? null;
                            $fotoUrl = (str_starts_with($fotoSobre, 'http')) ? $fotoSobre : asset('storage/' . $fotoSobre);
                        @endphp
                        <img src="{{ $fotoUrl }}"
                            alt="{{ $c['sobre_titulo']->valor ?? 'Thalita ensinando' }}"
                            class="w-full h-auto object-cover rounded-3xl border-[3px] border-brand-dark relative z-10 grayscale-[20%] sepia-[20%]">
                    </div>

                    <div
                        class="order-1 lg:order-2 bg-brand-cardLight border-[3px] border-brand-dark rounded-3xl shadow-retro-lg p-8 md:p-12 relative z-10">
                        <span data-i18n="c_sobre_badge"
                            class="inline-block bg-brand-alert text-brand-dark font-black text-sm uppercase tracking-widest py-1 px-3 border-2 border-brand-dark rounded-full mb-6 transform -rotate-2">
                            {{ $c['sobre_badge']->valor ?? 'Por que escolher as aulas?' }}
                        </span>

                        <h2 data-i18n="c_sobre_titulo"
                            class="text-3xl md:text-4xl font-black text-brand-dark mb-6 leading-tight">
                            {{ $c['sobre_titulo']->valor ?? 'Inglês focado na sua comunicação real' }}
                        </h2>

                        <p data-i18n="c_sobre_descricao" class="text-brand-dark/80 text-lg mb-8 font-medium">
                            {{ $c['sobre_descricao']->valor ?? 'Diga adeus aos métodos engessados. Minhas aulas são desenvolvidas para destravar a sua fala, focando exatamente nos seus objetivos de curto e longo prazo. Seja para o mercado de trabalho, viagens ou certificações internacionais.' }}
                        </p>

                        <div class="space-y-6">
                            @foreach($diferenciais as $index => $dif)
                            <div class="flex gap-4 items-start">
                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-xl {{ $dif['cor'] ?? 'bg-brand-orange' }} border-2 border-brand-dark shadow-retro-sm flex items-center justify-center text-white mt-1">
                                    <i class="{{ $dif['icone'] ?? 'fa-solid fa-star' }} text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-brand-dark font-black text-xl mb-1">
                                        <span data-i18n="dif_titulo_{{ $index }}">{{ $dif['titulo'] }}</span></h3>
                                    <p class="text-brand-dark/70 font-medium"><span data-i18n="dif_desc_{{ $index }}">{{ $dif['descricao'] }}</span></p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Serviços / Planos -->
        <section id="servicos" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 relative z-10">
                    <span data-i18n="c_secao_planos_badge"
                        class="inline-block bg-brand-red text-white font-black text-sm uppercase tracking-widest py-1 px-3 border-2 border-brand-dark rounded-full mb-4 transform rotate-2">
                        {{ $c['secao_planos_badge']->valor ?? 'Planos de Estudo' }}
                    </span>
                    <h2 data-i18n="c_secao_planos_titulo" class="text-4xl md:text-5xl font-black text-brand-dark mb-4">
                        {{ $c['secao_planos_titulo']->valor ?? 'A solução ideal para você' }}
                    </h2>
                    <p data-i18n="c_secao_planos_descricao" class="text-xl font-medium text-brand-dark/80">
                        {{ $c['secao_planos_descricao']->valor ?? 'Escolha o programa que mais se adequa à sua necessidade atual e vamos acelerar o seu aprendizado.' }}
                    </p>
                </div>

                <div class="flex flex-wrap justify-center items-stretch gap-8 relative z-10">
                    @foreach($servicos as $index => $servico)
                    <div
                        class="w-full md:w-[calc(50%-1.5rem)] lg:w-[calc(33.333%-2rem)] bg-brand-cardLight border-[3px] border-brand-dark rounded-3xl shadow-retro-lg overflow-hidden flex flex-col transform hover:-translate-y-2 transition-transform duration-300 relative">
                        @if($servico->imagem)
                        <div class="h-48 overflow-hidden border-b-[3px] border-brand-dark">
                            <img src="{{ Storage::url($servico->imagem) }}"
                                alt="{{ $servico->nome }}" class="w-full h-full object-cover grayscale-[30%] sepia-[20%]">
                        </div>
                        @else
                        <div class="h-48 overflow-hidden border-b-[3px] border-brand-dark bg-brand-bg flex items-center justify-center">
                            <i class="{{ $servico->icone ?? 'fa-solid fa-star' }} text-5xl text-brand-dark/20"></i>
                        </div>
                        @endif
                        <div class="p-8 flex-grow flex flex-col">
                            @if($servico->badge)
                            <div
                                class="inline-block {{ $servico->badge_cor ?? 'bg-brand-alert text-brand-dark' }} text-xs font-black px-3 py-1 border-2 border-brand-dark rounded-full mb-4 self-start transform -rotate-2">
                                <i class="{{ $servico->icone ?? 'fa-solid fa-star' }} mr-1"></i> <span data-i18n="serv_badge_{{ $index }}">{{ $servico->badge }}</span>
                            </div>
                            @endif
                            <h3 class="text-2xl font-black text-brand-dark mb-3"><span data-i18n="serv_titulo_{{ $index }}">{{ $servico->nome }}</span></h3>
                            <p class="text-brand-dark/80 font-medium mb-8 flex-grow">
                                <span data-i18n="serv_desc_{{ $index }}">{{ $servico->descricao }}</span>
                            </p>
                            
                            <div class="space-y-3">
                                @if($servico->tabela_precos)
                                <button @click="modalTitle = translations[currentLang]['serv_titulo_{{ $index }}']; modalContent = translations[currentLang]['serv_precos_{{ $index }}']; modalOpen = true; document.body.style.overflow = 'hidden'"
                                    class="w-full block text-center bg-brand-accent text-white font-black py-3 px-4 rounded-xl border-2 border-brand-dark hover:bg-brand-orange transition-colors shadow-retro-sm">
                                    <span data-i18n="card_btn_details">Ver Detalhes e Preços</span>
                                </button>
                                @endif
                                <a href="#contato"
                                    class="w-full block text-center bg-brand-dark text-brand-bg font-black py-3 px-4 rounded-xl border-2 border-brand-dark hover:bg-brand-card hover:text-brand-dark transition-colors shadow-retro-sm">
                                    <span data-i18n="card_btn">Quero este plano</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Depoimentos -->
        <section id="depoimentos" class="py-24 relative bg-brand-dark overflow-hidden">
            <!-- Background element -->
            <div
                class="absolute -right-20 top-20 w-64 h-64 bg-brand-orange rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none">
            </div>
            <div
                class="absolute -left-20 bottom-20 w-64 h-64 bg-brand-accent rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span data-i18n="c_secao_depoimentos_badge"
                        class="inline-block bg-brand-card text-brand-dark font-black text-sm uppercase tracking-widest py-1 px-3 border-2 border-brand-dark rounded-full mb-4 transform -rotate-2">
                        {{ $c['secao_depoimentos_badge']->valor ?? 'Histórias de Sucesso' }}
                    </span>
                    <h2 data-i18n="c_secao_depoimentos_titulo" class="text-4xl md:text-5xl font-black text-white mb-4">
                        {{ $c['secao_depoimentos_titulo']->valor ?? 'O que dizem os alunos' }}
                    </h2>
                    <p data-i18n="c_secao_depoimentos_descricao" class="text-xl font-medium text-brand-bg/80">
                        {{ $c['secao_depoimentos_descricao']->valor ?? 'Resultados reais de quem decidiu destravar o inglês de uma vez por todas.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($depoimentos as $index => $depo)
                    <div
                        class="{{ $index % 2 == 0 ? 'bg-brand-bg' : 'bg-brand-cardLight' }} border-[3px] border-brand-dark rounded-3xl shadow-retro p-8 transform hover:-translate-y-2 transition-transform duration-300 {{ $index == 1 ? 'relative top-0 lg:top-8' : ($index == 3 ? 'lg:-top-8 relative' : ($index == 5 ? 'relative lg:-top-8' : '')) }}">
                        <div class="flex items-center gap-4 mb-6">
                            @if($depo->avatar_autor)
                            <img src="{{ Storage::url($depo->avatar_autor) }}"
                                alt="{{ $depo->nome_autor }}"
                                class="w-16 h-16 rounded-full border-2 border-brand-dark object-cover grayscale-[20%]">
                            @else
                            <div class="w-16 h-16 rounded-full border-2 border-brand-dark bg-brand-accent flex items-center justify-center text-white text-2xl font-black">
                                {{ substr($depo->nome_autor, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <h4 class="font-black text-brand-dark text-lg"><span data-i18n="depo_nome_{{ $index }}">{{ $depo->nome_autor }}</span></h4>
                                <p class="text-brand-dark/70 text-sm font-bold"><span data-i18n="depo_cargo_{{ $index }}">{{ $depo->cargo_autor }}</span></p>
                            </div>
                        </div>
                        <div class="flex text-brand-alert mb-4 text-sm">
                            @for($i=0; $i<$depo->nota; $i++)
                            <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-brand-dark font-medium italic"><span data-i18n="depo_conteudo_{{ $index }}">"{{ $depo->conteudo }}"</span></p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CTA / Contato -->
        <section id="contato" class="py-24 relative z-10">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

                <div
                    class="bg-brand-accent border-[3px] border-brand-dark p-10 md:p-16 rounded-[40px] shadow-retro-lg relative overflow-hidden">
                    <!-- Decor inside card -->
                    <div
                        class="absolute -right-10 -bottom-10 w-40 h-40 bg-brand-card rounded-full border-[3px] border-brand-dark">
                    </div>
                    <div
                        class="absolute -left-10 -top-10 w-32 h-32 bg-brand-alert rounded-full border-[3px] border-brand-dark">
                    </div>

                    <div class="relative z-10">
                        <h2 data-i18n="c_contato_titulo"
                            class="text-4xl md:text-5xl font-black text-white mb-6 leading-tight drop-shadow-[2px_2px_0_rgba(73,75,70,1)]">
                            {{ $c['contato_titulo']->valor ?? 'Pronto para dar o próximo passo no seu inglês?' }}
                        </h2>
                        <p data-i18n="c_contato_descricao" class="text-xl text-brand-bg font-bold mb-10 max-w-2xl mx-auto">
                            {{ $c['contato_descricao']->valor ?? 'Não deixe para amanhã a fluência que você pode começar a construir hoje. Entre em contato pelo WhatsApp e vamos montar o seu plano.' }}
                        </p>

                        <div
                            class="bg-brand-bg border-[3px] border-brand-dark p-8 rounded-3xl shadow-retro max-w-md mx-auto transform transition-all hover:scale-[1.02] rotate-1">
                            <div
                                class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#25D366] text-white w-16 h-16 rounded-full flex items-center justify-center text-3xl border-[3px] border-brand-dark shadow-retro-sm">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>

                            <h3 data-i18n="c_contato_caixa_titulo" class="text-2xl font-black text-brand-dark mb-2 mt-6">{{ $c['contato_caixa_titulo']->valor ?? 'Fale Comigo' }}</h3>
                            <p data-i18n="c_contato_caixa_descricao" class="text-brand-dark/80 font-medium mb-8">{{ $c['contato_caixa_descricao']->valor ?? 'Tire dúvidas, verifique disponibilidade de horários e receba os valores atualizados.' }}</p>

                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['whatsapp_contato']->valor ?? '5519997799589') }}?text=Olá,%20gostaria%20de%20saber%20mais%20sobre%20as%20aulas%20de%20inglês!"
                                target="_blank" rel="noopener noreferrer"
                                class="block w-full bg-[#25D366] text-brand-dark font-black py-4 px-6 rounded-xl border-[3px] border-brand-dark shadow-retro hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-retro-sm transition-all active:scale-95 text-lg flex items-center justify-center gap-3">
                                <i class="fa-brands fa-whatsapp text-2xl"></i>
                                <span data-i18n="c_contato_botao">{{ $c['contato_botao']->valor ?? 'Iniciar Conversa' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-brand-dark py-16 border-t-[3px] border-brand-dark text-center md:text-left relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <a href="#" class="text-3xl font-black tracking-tighter text-brand-bg inline-block mb-4">
                    English with <span class="text-brand-card">Thalita</span>
                </a>
                <p data-i18n="c_footer_descricao" class="text-brand-bg/70 font-medium mb-6">
                    {{ $c['footer_descricao']->valor ?? 'Transformando o seu inglês de um obstáculo para uma ponte que conecta você ao mundo.' }}
                </p>
                <div class="flex gap-4 justify-center md:justify-start">
                    <a href="https://www.instagram.com/englishwiththalita/" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-xl bg-brand-bg border-2 border-brand-dark flex items-center justify-center text-brand-dark hover:bg-brand-card shadow-retro-sm active:translate-x-1 active:translate-y-1 active:shadow-none transition-all text-xl">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/5519997799589" target="_blank" rel="noopener noreferrer"
                        class="w-12 h-12 rounded-xl bg-brand-bg border-2 border-brand-dark flex items-center justify-center text-brand-dark hover:bg-[#25D366] shadow-retro-sm active:translate-x-1 active:translate-y-1 active:shadow-none transition-all text-xl">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 data-i18n="footer_nav_title"
                    class="text-brand-card font-black mb-6 uppercase text-sm tracking-widest border-b-2 border-brand-card/30 pb-2 inline-block">
                    Navegação</h4>
                <ul class="space-y-3 font-medium text-brand-bg/80">
                    <li><a href="#sobre" data-i18n="footer_nav_sobre"
                            class="hover:text-brand-card transition-colors">Sobre o Método</a></li>
                    <li><a href="#servicos" data-i18n="footer_nav_planos"
                            class="hover:text-brand-card transition-colors">Planos de Aula</a></li>
                    <li><a href="#depoimentos" data-i18n="footer_nav_depo"
                            class="hover:text-brand-card transition-colors">O que dizem os alunos</a>
                    </li>
                    <li><a href="#contato" data-i18n="footer_nav_contato"
                            class="hover:text-brand-card transition-colors">Contato e Valores</a></li>
                </ul>
            </div>

            <div>
                <h4 data-i18n="footer_contato_title"
                    class="text-brand-card font-black mb-6 uppercase text-sm tracking-widest border-b-2 border-brand-card/30 pb-2 inline-block">
                    Contato Direto</h4>
                <ul class="space-y-4 font-bold text-brand-bg">
                    <li>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['whatsapp_contato']->valor ?? '5519997799589') }}?text=Ol%C3%A1,%20gostaria%20de%20saber%20mais%20sobre%20as%20aulas!" target="_blank" rel="noopener noreferrer" 
                           class="group flex items-center gap-3 justify-center md:justify-start hover:text-brand-accent transition-all transform hover:-translate-y-1">
                            <div class="w-10 h-10 rounded-full bg-brand-bg/10 group-hover:bg-brand-accent/20 flex items-center justify-center text-brand-card group-hover:text-brand-accent transition-colors">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <span>+{{ preg_replace('/^(\d{2})(\d{2})(\d{4,5})(\d{4})$/', '$1 $2 $3-$4', preg_replace('/[^0-9]/', '', $c['whatsapp_contato']->valor ?? '5519997799589')) }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $c['contato_email']->valor ?? 'koppthalita@gmail.com' }}" target="_blank" rel="noopener noreferrer" 
                           class="group flex items-center gap-3 justify-center md:justify-start hover:text-brand-accent transition-all transform hover:-translate-y-1">
                            <div class="w-10 h-10 rounded-full bg-brand-bg/10 group-hover:bg-brand-accent/20 flex items-center justify-center text-brand-card group-hover:text-brand-accent transition-colors">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <span>{{ $c['contato_email']->valor ?? 'koppthalita@gmail.com' }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 pt-8 border-t-2 border-brand-bg/10 text-center font-bold text-sm text-brand-bg/50">
            <p class="flex flex-col md:flex-row items-center justify-center gap-2 md:gap-4">
                <span data-i18n="footer_rights">&copy; 2026 English with Thalita. Todos os direitos reservados.</span>
                <span class="hidden md:block text-brand-bg/20">|</span>
                <span class="flex items-center gap-1">
                    <span data-i18n="footer_dev">Desenvolvido por</span>
                    <a href="https://impulsonaweb.com.br" target="_blank" rel="noopener noreferrer"
                        class="text-brand-card hover:text-brand-accent transition-colors font-black">Impulso na Web</a>
                </span>
            </p>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        // Menu Mobile Toggle
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu on link click
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
        }

        // Header Scroll Effect
        const header = document.querySelector('header');
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) {
                    header.style.background = 'rgba(242, 235, 205, 0.98)';
                    header.classList.add('shadow-retro-sm');
                } else {
                    header.style.background = 'rgba(242, 235, 205, 0.95)';
                    header.classList.remove('shadow-retro-sm');
                }
            });
        }

        // Tradução Dinâmica
        let currentLang = '{{ app()->getLocale() === 'en' ? 'en' : 'pt' }}';
        const langIndicatorsPt = document.querySelectorAll('.lang-indicator-pt');
        const langIndicatorsEn = document.querySelectorAll('.lang-indicator-en');
        const langToggles = document.querySelectorAll('.lang-toggle');

        // Apenas textos estáticos que não estão no banco
        const staticTranslations = {
            'pt': {
                'nav_sobre': 'Sobre',
                'nav_planos': 'Planos de Aula',
                'nav_depoimentos': 'Depoimentos',
                'nav_contato': 'Contato',
                'nav_cta': 'Agendar Aula',
                'mob_nav_cta': 'Fale no WhatsApp',
                'hero_swipe': 'deslize para me conhecer <i class="fa-solid fa-arrow-down"></i>',
                'card_btn': 'Quero este plano',
                'card_btn_details': 'Ver Detalhes e Preços',
                'footer_nav_title': 'Navegação',
                'footer_nav_sobre': 'Sobre o Método',
                'footer_nav_planos': 'Planos de Aula',
                'footer_nav_depo': 'O que dizem os alunos',
                'footer_nav_contato': 'Contato e Valores',
                'footer_contato_title': 'Contato Direto',
                'footer_rights': '&copy; 2026 English with Thalita. Todos os direitos reservados.',
                'footer_dev': 'Desenvolvido por',
                'whatsapp_plan_message': 'Olá, vi os detalhes do plano [PLAN] e gostaria de conversar!'
            },
            'en': {
                'nav_sobre': 'About',
                'nav_planos': 'Study Plans',
                'nav_depoimentos': 'Testimonials',
                'nav_contato': 'Contact',
                'nav_cta': 'Book Class',
                'mob_nav_cta': 'Contact on WhatsApp',
                'hero_swipe': 'swipe to get to know me <i class="fa-solid fa-arrow-down"></i>',
                'card_btn': 'I want this plan',
                'card_btn_details': 'View Details and Prices',
                'footer_nav_title': 'Navigation',
                'footer_nav_sobre': 'About the Method',
                'footer_nav_planos': 'Study Plans',
                'footer_nav_depo': 'What students say',
                'footer_nav_contato': 'Contact and Prices',
                'footer_contato_title': 'Direct Contact',
                'footer_rights': '&copy; 2026 English with Thalita. All rights reserved.',
                'footer_dev': 'Developed by',
                'whatsapp_plan_message': 'Hi, I saw the details for the [PLAN] plan and would like to talk!'
            }
        };

        const dbTranslations = {!! json_encode($dbTranslations) !!};
        const translations = {
            'pt': { ...staticTranslations['pt'], ...dbTranslations['pt'] },
            'en': { ...staticTranslations['en'], ...dbTranslations['en'] }
        };

        function updateLanguageUI() {
            if (currentLang === 'pt') {
                langIndicatorsPt.forEach(el => {
                    el.classList.add('text-brand-accent');
                    el.classList.remove('text-brand-dark/50');
                });
                langIndicatorsEn.forEach(el => {
                    el.classList.add('text-brand-dark/50');
                    el.classList.remove('text-brand-accent');
                });
            } else {
                langIndicatorsEn.forEach(el => {
                    el.classList.add('text-brand-accent');
                    el.classList.remove('text-brand-dark/50');
                });
                langIndicatorsPt.forEach(el => {
                    el.classList.add('text-brand-dark/50');
                    el.classList.remove('text-brand-accent');
                });
            }

            document.querySelectorAll('[data-i18n]').forEach(element => {
                const key = element.getAttribute('data-i18n');
                if (translations[currentLang] && translations[currentLang][key]) {
                    if (element.tagName === 'META') {
                        element.setAttribute('content', translations[currentLang][key]);
                    } else if (element.tagName === 'TITLE') {
                        element.innerText = translations[currentLang][key];
                    } else {
                        element.innerHTML = translations[currentLang][key];
                    }
                }
            });
            
            document.documentElement.lang = currentLang === 'pt' ? 'pt-BR' : 'en-US';
        }

        // Aplica tradução estática inicial
        updateLanguageUI();

        langToggles.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                let newLang = currentLang === 'pt' ? 'en' : 'pt_BR';
                
                // Fetch in background to set session
                fetch('/lang/' + newLang).catch(err => console.error(err));
                
                // Update UI without reload
                currentLang = newLang === 'en' ? 'en' : 'pt';
                updateLanguageUI();
            });
        });
    </script>
    <!-- Modal Detalhes Planos -->
    <div id="modal-planos" x-show="modalOpen" 
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-brand-dark/60 backdrop-blur-sm"
        x-cloak>
        <div @click.away="modalOpen = false; document.body.style.overflow = 'auto'"
            class="bg-brand-bg border-[3px] border-brand-dark rounded-[40px] shadow-retro-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto relative animate-modal-enter">
            <div class="sticky top-0 bg-brand-card border-b-[3px] border-brand-dark p-6 flex justify-between items-center z-10">
                <h3 x-text="modalTitle" class="text-2xl font-black text-brand-dark"></h3>
                <button @click="modalOpen = false; document.body.style.overflow = 'auto'" class="w-10 h-10 rounded-xl bg-brand-red text-white border-2 border-brand-dark shadow-retro-sm flex items-center justify-center transform transition-all hover:scale-110 active:scale-95">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-8 prose prose-brand max-w-none prose-headings:font-black prose-headings:text-brand-dark prose-p:font-medium prose-p:text-brand-dark/80 prose-li:font-medium prose-li:text-brand-dark/80">
                <div x-html="modalContent" class="modal-content"></div>
                
                <div class="mt-10 pt-8 border-t-[3px] border-brand-dark">
                    <a x-bind:href="'https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['whatsapp_contato']->valor ?? '5519997799589') }}?text=' + encodeURIComponent(translations[currentLang]['whatsapp_plan_message'].replace('[PLAN]', modalTitle))" 
                        target="_blank" rel="noopener noreferrer"
                        @click="modalOpen = false; document.body.style.overflow = 'auto'"
                        class="w-full block text-center bg-brand-accent text-white font-black py-4 px-6 rounded-2xl border-[3px] border-brand-dark shadow-retro hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-retro-sm transition-all text-xl"
                        data-i18n="c_texto_whatsapp_modal">
                        {{ $c['texto_whatsapp_modal']->valor ?? 'Falar com a Thalita no WhatsApp' }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        @keyframes modal-enter {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-modal-enter {
            animation: modal-enter 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        /* Custom Modal Typography */
        #modal-planos .modal-content h4 {
            font-size: 1.25rem;
            font-weight: 900;
            color: #494b46;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            border-left: 4px solid var(--brand-accent, #1d8985);
            padding-left: 0.75rem;
        }
        #modal-planos .modal-content ul {
            list-style-type: none;
            padding-left: 0.5rem;
        }
        #modal-planos .modal-content li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: rgba(73, 75, 70, 0.9);
        }
        #modal-planos .modal-content li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--brand-accent, #1d8985);
            font-weight: 900;
        }
        #modal-planos .modal-content ul ul {
            margin-top: 0.25rem;
            margin-bottom: 0.75rem;
            padding-left: 1rem;
            border-left: 2px dashed rgba(73, 75, 70, 0.2);
        }
        #modal-planos .modal-content ul ul li::before {
            content: '•';
        }
        #modal-planos .modal-content strong {
            font-weight: 800;
            color: #494b46;
        }
    </style>
</body>

</html>