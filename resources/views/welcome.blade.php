@php
    $c = \App\Models\Configuracao::pluck('valor', 'chave')->toArray();
    $diferenciais = $c['diferenciais'] ?? [];
    $servicos = \App\Models\Servico::where('esta_ativo', true)->orderBy('ordem')->get();
    $depoimentos = \App\Models\Depoimento::where('esta_ativo', true)->get();
@endphp
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-i18n="page_title">{{ $c['seo_titulo'] ?? 'English with Thalita' }}</title>
    <meta name="description" content="{{ $c['seo_descricao'] ?? 'Professora de inglês para quem quer se comunicar com confiança e fluência real.' }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                            accent: '{{ $c['cor_primaria'] ?? '#1d8985' }}', // Dinâmico do Banco
                            accentHover: '{{ $c['cor_primaria'] ?? '#1d8985' }}',
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

<body
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
                        {{ $c['nome_site'] ?? 'English with Thalita' }}
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
                    <button id="lang-toggle"
                        class="font-bold text-brand-dark bg-brand-bg py-2 px-3 rounded-xl border-2 border-brand-dark shadow-retro-sm hover:bg-brand-card transition-all active:scale-95 flex items-center gap-1 text-xs uppercase tracking-wider cursor-pointer"
                        aria-label="Mudar idioma">
                        <span id="lang-indicator-pt" class="text-brand-accent pointer-events-none">PT</span>
                        <span class="text-brand-dark/30 mx-1 pointer-events-none">/</span>
                        <span id="lang-indicator-en" class="text-brand-dark/50 pointer-events-none">EN</span>
                    </button>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['whatsapp_contato'] ?? '5519997799589') }}?text=Ol%C3%A1,%20gostaria%20de%20agendar%20uma%20aula!" target="_blank" rel="noopener noreferrer"
                        class="bg-brand-accent text-white font-black py-2.5 px-6 rounded-xl border-2 border-brand-dark shadow-retro hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-retro-sm transition-all active:scale-95 flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span data-i18n="nav_cta">Agendar Aula</span>
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
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
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">

                <div class="max-w-sm md:max-w-md text-left">
                    <!-- Retro Title Card -->
                    <div
                        class="bg-brand-card border-[3px] border-brand-dark rounded-3xl shadow-retro-lg py-8 px-10 md:py-12 md:px-16 inline-block mb-10 transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                        <h1
                            class="text-5xl md:text-7xl lg:text-[80px] font-black text-brand-dark leading-[1.1] tracking-tight">
                            {!! nl2br(e($c['titulo_hero'] ?? "English\nwith\nThalita")) !!}
                        </h1>
                    </div>

                    <p data-i18n="hero_subtitle"
                        class="text-2xl md:text-3xl font-bold text-brand-dark mb-10 leading-snug">
                        {{ $c['subtitulo_hero'] ?? 'Professora de inglês para quem quer se comunicar com confiança e fluência real' }}
                    </p>

                    <div class="flex flex-row gap-4 justify-start items-center">
                        <a href="#contato"
                            class="whitespace-nowrap bg-[#25D366] text-brand-dark font-black py-4 px-8 rounded-2xl border-[3px] border-brand-dark shadow-retro hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-retro-sm transition-all text-xl flex items-center justify-center gap-3">
                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                            <span data-i18n="hero_cta">{{ $c['texto_botao_hero'] ?? 'Quero Aprender' }}</span>
                        </a>
                        <span
                            class="whitespace-nowrap font-bold text-brand-dark text-base flex items-center gap-2 cursor-default animate-bounce"
                            data-i18n="hero_swipe">
                            deslize <i class="fa-solid fa-arrow-down"></i>
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
                        <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Thalita ensinando"
                            class="w-full h-auto object-cover rounded-3xl border-[3px] border-brand-dark relative z-10 grayscale-[20%] sepia-[20%]">
                    </div>

                    <div
                        class="order-1 lg:order-2 bg-brand-cardLight border-[3px] border-brand-dark rounded-3xl shadow-retro-lg p-8 md:p-12 relative z-10">
                        <span data-i18n="sobre_badge"
                            class="inline-block bg-brand-alert text-brand-dark font-black text-sm uppercase tracking-widest py-1 px-3 border-2 border-brand-dark rounded-full mb-6 transform -rotate-2">
                            {{ $c['sobre_badge'] ?? 'Por que escolher as aulas?' }}
                        </span>

                        <h2 data-i18n="sobre_title"
                            class="text-3xl md:text-4xl font-black text-brand-dark mb-6 leading-tight">
                            {{ $c['sobre_titulo'] ?? 'Inglês focado na sua comunicação real' }}
                        </h2>

                        <p data-i18n="sobre_desc" class="text-brand-dark/80 text-lg mb-8 font-medium">
                            {{ $c['sobre_descricao'] ?? 'Diga adeus aos métodos engessados. Minhas aulas são desenvolvidas para destravar a sua fala, focando exatamente nos seus objetivos de curto e longo prazo. Seja para o mercado de trabalho, viagens ou certificações internacionais.' }}
                        </p>

                        <div class="space-y-6">
                            @foreach($diferenciais as $dif)
                            <div class="flex gap-4 items-start">
                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-xl {{ $dif['cor'] ?? 'bg-brand-orange' }} border-2 border-brand-dark shadow-retro-sm flex items-center justify-center text-white mt-1">
                                    <i class="{{ $dif['icone'] ?? 'fa-solid fa-star' }} text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-brand-dark font-black text-xl mb-1">
                                        {{ $dif['titulo'] }}</h3>
                                    <p class="text-brand-dark/70 font-medium">{{ $dif['descricao'] }}</p>
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
                    <span data-i18n="serv_badge"
                        class="inline-block bg-brand-red text-white font-black text-sm uppercase tracking-widest py-1 px-3 border-2 border-brand-dark rounded-full mb-4 transform rotate-2">
                        Planos de Estudo
                    </span>
                    <h2 data-i18n="serv_title" class="text-4xl md:text-5xl font-black text-brand-dark mb-4">A solução
                        ideal para você</h2>
                    <p data-i18n="serv_desc" class="text-xl font-medium text-brand-dark/80">Escolha o programa que mais
                        se adequa à sua
                        necessidade atual e vamos acelerar o seu aprendizado.</p>
                </div>

                <div class="flex flex-wrap justify-center gap-8 relative z-10">
                    @foreach($servicos as $servico)
                    <div
                        class="w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-2rem)] md:min-h-[600px] bg-brand-cardLight border-[3px] border-brand-dark rounded-3xl shadow-retro-lg overflow-hidden flex flex-col h-full transform hover:-translate-y-2 transition-transform duration-300 relative">
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
                                <i class="{{ $servico->icone ?? 'fa-solid fa-star' }} mr-1"></i> <span>{{ $servico->badge }}</span>
                            </div>
                            @endif
                            <h3 class="text-2xl font-black text-brand-dark mb-3">{{ $servico->nome }}</h3>
                            <p class="text-brand-dark/80 font-medium mb-8 flex-grow">
                                {{ $servico->descricao }}
                            </p>
                            <a href="#contato"
                                class="w-full block text-center bg-brand-dark text-brand-bg font-black py-3 px-4 rounded-xl border-2 border-brand-dark hover:bg-brand-card hover:text-brand-dark transition-colors shadow-retro-sm">
                                Consultar Valores
                            </a>
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
                    <span data-i18n="depo_badge"
                        class="inline-block bg-brand-card text-brand-dark font-black text-sm uppercase tracking-widest py-1 px-3 border-2 border-brand-dark rounded-full mb-4 transform -rotate-2">
                        Histórias de Sucesso
                    </span>
                    <h2 data-i18n="depo_title" class="text-4xl md:text-5xl font-black text-white mb-4">O que dizem os
                        alunos</h2>
                    <p data-i18n="depo_desc" class="text-xl font-medium text-brand-bg/80">Resultados reais de quem
                        decidiu destravar o inglês de uma vez por todas.</p>
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
                                <h4 class="font-black text-brand-dark text-lg">{{ $depo->nome_autor }}</h4>
                                <p class="text-brand-dark/70 text-sm font-bold">{{ $depo->cargo_autor }}</p>
                            </div>
                        </div>
                        <div class="flex text-brand-alert mb-4 text-sm">
                            @for($i=0; $i<$depo->nota; $i++)
                            <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-brand-dark font-medium italic">"{{ $depo->conteudo }}"</p>
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
                        <h2 data-i18n="contato_title"
                            class="text-4xl md:text-5xl font-black text-white mb-6 leading-tight drop-shadow-[2px_2px_0_rgba(73,75,70,1)]">
                            {{ $c['contato_titulo'] ?? 'Pronto para dar o próximo passo no seu inglês?' }}
                        </h2>
                        <p data-i18n="contato_desc" class="text-xl text-brand-bg font-bold mb-10 max-w-2xl mx-auto">
                            {{ $c['contato_descricao'] ?? 'Não deixe para amanhã a fluência que você pode começar a construir hoje. Entre em contato pelo WhatsApp e vamos montar o seu plano.' }}
                        </p>

                        <div
                            class="bg-brand-bg border-[3px] border-brand-dark p-8 rounded-3xl shadow-retro max-w-md mx-auto transform transition-all hover:scale-[1.02] rotate-1">
                            <div
                                class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#25D366] text-white w-16 h-16 rounded-full flex items-center justify-center text-3xl border-[3px] border-brand-dark shadow-retro-sm">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>

                            <h3 data-i18n="contato_box_title" class="text-2xl font-black text-brand-dark mb-2 mt-6">{{ $c['contato_caixa_titulo'] ?? 'Fale Comigo' }}</h3>
                            <p data-i18n="contato_box_desc" class="text-brand-dark/80 font-medium mb-8">{{ $c['contato_caixa_descricao'] ?? 'Tire dúvidas, verifique disponibilidade de horários e receba os valores atualizados.' }}</p>

                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['whatsapp_contato'] ?? '5519997799589') }}?text=Olá,%20gostaria%20de%20saber%20mais%20sobre%20as%20aulas%20de%20inglês!"
                                target="_blank" rel="noopener noreferrer"
                                class="block w-full bg-[#25D366] text-brand-dark font-black py-4 px-6 rounded-xl border-[3px] border-brand-dark shadow-retro hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-retro-sm transition-all active:scale-95 text-lg flex items-center justify-center gap-3">
                                <i class="fa-brands fa-whatsapp text-2xl"></i>
                                <span data-i18n="contato_btn">{{ $c['contato_botao'] ?? 'Iniciar Conversa' }}</span>
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
                <p data-i18n="footer_desc" class="text-brand-bg/70 font-medium mb-6">
                    Transformando o seu inglês de um obstáculo para uma ponte que conecta você ao mundo.
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
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c['whatsapp_contato'] ?? '5519997799589') }}?text=Ol%C3%A1,%20gostaria%20de%20saber%20mais%20sobre%20as%20aulas!" target="_blank" rel="noopener noreferrer" 
                           class="group flex items-center gap-3 justify-center md:justify-start hover:text-brand-accent transition-all transform hover:-translate-y-1">
                            <div class="w-10 h-10 rounded-full bg-brand-bg/10 group-hover:bg-brand-accent/20 flex items-center justify-center text-brand-card group-hover:text-brand-accent transition-colors">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <span>+{{ preg_replace('/^(\d{2})(\d{2})(\d{4,5})(\d{4})$/', '$1 $2 $3-$4', preg_replace('/[^0-9]/', '', $c['whatsapp_contato'] ?? '5519997799589')) }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $c['contato_email'] ?? 'koppthalita@gmail.com' }}" target="_blank" rel="noopener noreferrer" 
                           class="group flex items-center gap-3 justify-center md:justify-start hover:text-brand-accent transition-all transform hover:-translate-y-1">
                            <div class="w-10 h-10 rounded-full bg-brand-bg/10 group-hover:bg-brand-accent/20 flex items-center justify-center text-brand-card group-hover:text-brand-accent transition-colors">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <span>{{ $c['contato_email'] ?? 'koppthalita@gmail.com' }}</span>
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
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Close mobile menu on link click
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });

        // Header Scroll Effect
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                header.style.background = 'rgba(242, 235, 205, 0.98)';
                header.classList.add('shadow-retro-sm');
            } else {
                header.style.background = 'rgba(242, 235, 205, 0.95)';
                header.classList.remove('shadow-retro-sm');
            }
        });

        // Language Toggle Logic
        let currentLang = 'pt';
        const langToggleBtn = document.getElementById('lang-toggle');
        const langIndicatorPt = document.getElementById('lang-indicator-pt');
        const langIndicatorEn = document.getElementById('lang-indicator-en');

        const translations = {
            'pt': {
                'page_title': 'English with Thalita | Aulas de Inglês Online Personalizadas',
                'nav_sobre': 'Sobre',
                'nav_planos': 'Planos de Aula',
                'nav_depoimentos': 'Depoimentos',
                'nav_contato': 'Contato',
                'nav_cta': 'Agendar Aula',
                'mob_nav_cta': 'Fale no WhatsApp',
                'hero_subtitle': 'Professora de inglês para quem quer se comunicar com confiança e fluência real',
                'hero_cta': 'Quero Aprender',
                'hero_swipe': 'deslize para me conhecer <i class="fa-solid fa-arrow-down"></i>',
                'sobre_badge': 'Por que escolher as aulas?',
                'sobre_title': 'Inglês focado na sua comunicação real',
                'sobre_desc': 'Diga adeus aos métodos engessados. Minhas aulas são desenvolvidas para destravar a sua fala, focando exatamente nos seus objetivos de curto e longo prazo. Seja para o mercado de trabalho, viagens ou certificações internacionais.',
                'sobre_feat1_title': 'Aulas 100% Personalizadas',
                'sobre_feat1_desc': 'Conteúdo adaptado para o que você realmente precisa aprender no momento.',
                'sobre_feat2_title': 'Foco Total em Conversação',
                'sobre_feat2_desc': 'Prática intensiva de speaking desde a primeira aula para perder o medo de errar.',
                'sobre_feat3_title': 'Certificações e Vivência Exterior',
                'sobre_feat3_desc': 'Professora certificada com experiência internacional, trazendo a fluência real e a bagagem cultural de quem viveu o idioma na prática.',
                'serv_badge': 'Planos de Estudo',
                'serv_title': 'A solução ideal para você',
                'serv_desc': 'Escolha o programa que mais se adequa à sua necessidade atual e vamos acelerar o seu aprendizado.',
                'card1_badge': 'Mais procurado',
                'card1_title': 'Foco na Conversação',
                'card1_desc': 'Já estuda há um tempo mas ainda trava na hora de falar? Ou já se vira bem, mas não atingiu a fluência que deseja? Nossas aulas são para todos os níveis, 100% personalizadas para o seu interesse e necessidade real.',
                'card_biz_badge': 'Carreira',
                'card_biz_title': 'Business English',
                'card_biz_desc': 'Destaque-se no mercado de trabalho. Prepare-se para reuniões, apresentações, entrevistas e negociações com vocabulário corporativo de alto nível.',
                'card_btn': 'Consultar Valores',
                'card4_badge': 'Foco Prático',
                'card4_title': 'Sobrevivência para Viagens',
                'card4_desc': 'Aprenda o essencial para se comunicar em aeroportos, hotéis, restaurantes, interações sociais e situações de emergência durante suas viagens.',
                'card6_badge': 'VIP',
                'card6_title': 'Inglês Pela Cidade (Presencial)',
                'card6_desc': 'Fuja das salas de aula e aprenda inglês onde a vida acontece. Pratique conversação em ambientes reais com suporte total para o seu dia a dia.',
                'card_corp_badge': 'Corporativo',
                'card_corp_title': 'Inglês para Empresas',
                'card_corp_desc': 'Treinamento prático para equipes que atendem clientes em inglês. Conteúdo adaptado à realidade da empresa e acessível para diferentes níveis.',
                'contato_title': 'Pronto para dar o próximo passo no seu inglês?',
                'contato_desc': 'Não deixe para amanhã a fluência que você pode começar a construir hoje. Entre em contato pelo WhatsApp e vamos montar o seu plano.',
                'contato_box_title': 'Fale Comigo',
                'contato_box_desc': 'Tire dúvidas, verifique disponibilidade de horários e receba os valores atualizados.',
                'contato_btn': 'Iniciar Conversa',
                'footer_desc': 'Transformando o seu inglês de um obstáculo para uma ponte que conecta você ao mundo.',
                'footer_nav_title': 'Navegação',
                'footer_nav_sobre': 'Sobre o Método',
                'footer_nav_planos': 'Planos de Aula',
                'footer_nav_depo': 'O que dizem os alunos',
                'footer_nav_contato': 'Contato e Valores',
                'footer_contato_title': 'Contato Direto',
                'footer_rights': '&copy; 2026 English with Thalita. Todos os direitos reservados.',
                'footer_dev': 'Desenvolvido por',
                'depo_badge': 'Histórias de Sucesso',
                'depo_title': 'O que dizem os alunos',
                'depo_desc': 'Resultados reais de quem decidiu destravar o inglês de uma vez por todas.',
                'depo1_name': 'Mariana Silva, 22',
                'depo1_role': 'Estudante Universitária',
                'depo1_text': '"Eu travava completamente na hora de falar. Em poucos meses com a Thalita, perdi o medo e consegui a pontuação que precisava no TOEFL para meu intercâmbio!"',
                'depo2_name': 'Carlos Eduardo, 34',
                'depo2_role': 'Desenvolvedor Sênior',
                'depo2_text': '"As aulas focadas em Business English mudaram minha carreira. Hoje conduzo reuniões com a equipe gringa sem suar frio. Metodologia muito prática e direto ao ponto."',
                'depo3_name': 'Fernanda Costa, 45',
                'depo3_role': 'Empresária',
                'depo3_text': '"Sempre achei que estava velha para aprender inglês do zero. A Thalita teve tanta paciência e montou um material tão voltado para minhas viagens que hoje me viro super bem sozinha."',
                'depo4_name': 'Amanda Reis, 28',
                'depo4_role': 'Designer UX/UI',
                'depo4_text': '"O foco em comunicação real faz toda a diferença. Eu sabia gramática mas não falava. Em poucas aulas já estava me expressando muito melhor do que anos em cursinho."',
                'depo5_name': 'Roberto Alves, 52',
                'depo5_role': 'Gerente Comercial',
                'depo5_text': '"Precisava melhorar o inglês para uma promoção. A flexibilidade de horários e as aulas personalizadas foram essenciais para conciliar com minha rotina corrida."',
                'depo6_name': 'Lucas Mendes, 18',
                'depo6_role': 'Estudante de Ensino Médio',
                'depo6_text': '"As aulas não são chatas como na escola. Falamos de assuntos atuais e práticos. Sinto que estou aprendendo o inglês que realmente se usa no dia a dia e na internet."'
            },
            'en': {
                'page_title': 'English with Thalita | Personalized Online English Classes',
                'nav_sobre': 'About',
                'nav_planos': 'Study Plans',
                'nav_depoimentos': 'Testimonials',
                'nav_contato': 'Contact',
                'nav_cta': 'Book Class',
                'mob_nav_cta': 'Contact on WhatsApp',
                'hero_subtitle': 'English teacher for those who want to communicate with confidence and real fluency',
                'hero_cta': 'I Want to Learn',
                'hero_swipe': 'swipe to get to know me <i class="fa-solid fa-arrow-down"></i>',
                'sobre_badge': 'Why choose my classes?',
                'sobre_title': 'English focused on your real communication',
                'sobre_desc': 'Say goodbye to rigid methods. My classes are designed to unlock your speaking, focusing exactly on your short and long-term goals. Whether for the job market, travel, or international certifications.',
                'sobre_feat1_title': '100% Personalized Classes',
                'sobre_feat1_desc': 'Content adapted to what you really need to learn right now.',
                'sobre_feat2_title': 'Total Focus on Conversation',
                'sobre_feat2_desc': 'Intensive speaking practice from the very first class to lose the fear of making mistakes.',
                'sobre_feat3_title': 'Certifications & International Experience',
                'sobre_feat3_desc': 'Certified teacher with international experience, bringing real fluency and the cultural background of someone who lived the language in practice.',
                'serv_badge': 'Study Plans',
                'serv_title': 'The ideal solution for you',
                'serv_desc': "Choose the program that best suits your current needs and let's accelerate your learning.",
                'card1_badge': 'Most popular',
                'card1_title': 'Focus on Conversation',
                'card1_desc': 'Have you been studying for a while but still freeze when speaking? Or do you get by, but haven\'t reached true fluency? Our classes are for all levels, 100% personalized to your interests and real needs.',
                'card_biz_badge': 'Career',
                'card_biz_title': 'Business English',
                'card_biz_desc': 'Stand out in the job market. Prepare for meetings, presentations, interviews, and negotiations with high-level corporate vocabulary.',
                'card_btn': 'Check Prices',
                'card4_badge': 'Practical Focus',
                'card4_title': 'Travel Survival',
                'card4_desc': 'Learn the essentials to communicate in airports, hotels, restaurants, social interactions, and emergency situations during your travels.',
                'card6_badge': 'VIP',
                'card6_title': 'English Around Town (In Person)',
                'card6_desc': 'Escape the classroom and learn English where life happens. Practice conversation in real-world settings with full support for your daily life.',
                'card_corp_badge': 'Corporate',
                'card_corp_title': 'English for Companies',
                'card_corp_desc': 'Practical training for teams serving English-speaking clients. Content adapted to the company\'s reality and accessible for different levels.',
                'contato_title': 'Ready to take the next step in your English?',
                'contato_desc': "Don't leave for tomorrow the fluency you can start building today. Contact me via WhatsApp and let's create your plan.",
                'contato_box_title': 'Talk to Me',
                'contato_box_desc': 'Ask questions, check schedule availability, and get the updated prices.',
                'contato_btn': 'Start Conversation',
                'footer_desc': 'Transforming your English from an obstacle into a bridge that connects you to the world.',
                'footer_nav_title': 'Navigation',
                'footer_nav_sobre': 'About the Method',
                'footer_nav_planos': 'Study Plans',
                'footer_nav_depo': 'What students say',
                'footer_nav_contato': 'Contact and Prices',
                'footer_contato_title': 'Direct Contact',
                'footer_rights': '&copy; 2026 English with Thalita. All rights reserved.',
                'footer_dev': 'Developed by',
                'depo_badge': 'Success Stories',
                'depo_title': 'What students say',
                'depo_desc': 'Real results from those who decided to unlock their English once and for all.',
                'depo1_name': 'Mariana Silva, 22',
                'depo1_role': 'University Student',
                'depo1_text': '"I used to completely freeze when speaking. In just a few months with Thalita, I lost my fear and got the TOEFL score I needed for my exchange program!"',
                'depo2_name': 'Carlos Eduardo, 34',
                'depo2_role': 'Senior Developer',
                'depo2_text': '"The classes focused on Business English changed my career. Today I lead meetings with the foreign team without breaking a sweat. Very practical and straight-to-the-point methodology."',
                'depo3_name': 'Fernanda Costa, 45',
                'depo3_role': 'Business Owner',
                'depo3_text': '"I always thought I was too old to learn English from scratch. Thalita was so patient and created material so tailored for my trips that today I get by perfectly on my own."',
                'depo4_name': 'Amanda Reis, 28',
                'depo4_role': 'UX/UI Designer',
                'depo4_text': '"The focus on real communication makes all the difference. I knew grammar but couldn\'t speak. In just a few classes I was already expressing myself much better than years in a regular course."',
                'depo5_name': 'Roberto Alves, 52',
                'depo5_role': 'Sales Manager',
                'depo5_text': '"I needed to improve my English for a promotion. The flexible schedule and personalized classes were essential to fit into my busy routine."',
                'depo6_name': 'Lucas Mendes, 18',
                'depo6_role': 'High School Student',
                'depo6_text': '"The classes aren\'t boring like at school. We talk about current and practical topics. I feel like I\'m learning the English that is actually used in everyday life and on the internet."'
            }
        };

        function updateLanguageUI() {
            if (currentLang === 'pt') {
                langIndicatorPt.classList.add('text-brand-accent');
                langIndicatorPt.classList.remove('text-brand-dark/50');
                langIndicatorEn.classList.add('text-brand-dark/50');
                langIndicatorEn.classList.remove('text-brand-accent');
            } else {
                langIndicatorEn.classList.add('text-brand-accent');
                langIndicatorEn.classList.remove('text-brand-dark/50');
                langIndicatorPt.classList.add('text-brand-dark/50');
                langIndicatorPt.classList.remove('text-brand-accent');
            }

            document.querySelectorAll('[data-i18n]').forEach(element => {
                const key = element.getAttribute('data-i18n');
                if (translations[currentLang] && translations[currentLang][key]) {
                    if (element.tagName === 'TITLE') {
                        document.title = translations[currentLang][key];
                    } else {
                        element.innerHTML = translations[currentLang][key];
                    }
                }
            });

            document.documentElement.lang = currentLang === 'pt' ? 'pt-BR' : 'en-US';
        }

        if (langToggleBtn) {
            langToggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                currentLang = currentLang === 'pt' ? 'en' : 'pt';
                updateLanguageUI();
            });
        }
    </script>
</body>

</html>