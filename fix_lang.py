import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

php_block = """@php
    $c = \App\Models\Configuracao::all()->keyBy('chave');
    $diferenciais = $c->has('diferenciais') ? $c['diferenciais']->valor : [];
    if (is_string($diferenciais)) $diferenciais = json_decode($diferenciais, true) ?? [];
    
    $servicos = \App\Models\Servico::where('esta_ativo', true)->orderBy('ordem')->get();
    $depoimentos = \App\Models\Depoimento::where('esta_ativo', true)->get();

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
    
    $difs_pt = json_decode($c['diferenciais']->getTranslation('valor', 'pt_BR') ?? '[]', true) ?? [];
    $difs_en = json_decode($c['diferenciais']->getTranslation('valor', 'en') ?? '[]', true) ?? [];
    foreach($diferenciais as $index => $dif) {
        $dbTranslations['pt']['dif_titulo_' . $index] = $difs_pt[$index]['titulo'] ?? '';
        $dbTranslations['en']['dif_titulo_' . $index] = $difs_en[$index]['titulo'] ?? '';
        $dbTranslations['pt']['dif_desc_' . $index] = $difs_pt[$index]['descricao'] ?? '';
        $dbTranslations['en']['dif_desc_' . $index] = $difs_en[$index]['descricao'] ?? '';
    }

    foreach($servicos as $index => $servico) {
        $dbTranslations['pt']['serv_titulo_' . $index] = $servico->getTranslation('titulo', 'pt_BR') ?? '';
        $dbTranslations['en']['serv_titulo_' . $index] = $servico->getTranslation('titulo', 'en') ?? '';
        $dbTranslations['pt']['serv_desc_' . $index] = $servico->getTranslation('descricao', 'pt_BR') ?? '';
        $dbTranslations['en']['serv_desc_' . $index] = $servico->getTranslation('descricao', 'en') ?? '';
    }

    foreach($depoimentos as $index => $depo) {
        $dbTranslations['pt']['depo_nome_' . $index] = $depo->nome_autor;
        $dbTranslations['en']['depo_nome_' . $index] = $depo->nome_autor;
        $dbTranslations['pt']['depo_cargo_' . $index] = $depo->getTranslation('cargo_autor', 'pt_BR') ?? '';
        $dbTranslations['en']['depo_cargo_' . $index] = $depo->getTranslation('cargo_autor', 'en') ?? '';
        $dbTranslations['pt']['depo_conteudo_' . $index] = '"' . ($depo->getTranslation('conteudo', 'pt_BR') ?? '') . '"';
        $dbTranslations['en']['depo_conteudo_' . $index] = '"' . ($depo->getTranslation('conteudo', 'en') ?? '') . '"';
    }
@endphp"""

# Replace PHP block
content = re.sub(r'@php.*?@endphp', php_block, content, count=1, flags=re.DOTALL)

js_block = """        // Apenas textos estáticos que não estão no banco
        const staticTranslations = {
            'pt': {
                'nav_sobre': 'Sobre',
                'nav_planos': 'Planos de Aula',
                'nav_depoimentos': 'Depoimentos',
                'nav_contato': 'Contato',
                'nav_cta': 'Agendar Aula',
                'mob_nav_cta': 'Fale no WhatsApp',
                'hero_swipe': 'deslize para me conhecer <i class="fa-solid fa-arrow-down"></i>',
                'serv_badge': 'Planos de Estudo',
                'serv_title': 'A solução ideal para você',
                'serv_desc': 'Escolha o programa que mais se adequa à sua necessidade atual e vamos acelerar o seu aprendizado.',
                'card_btn': 'Consultar Valores',
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
                'depo_desc': 'Resultados reais de quem decidiu destravar o inglês de uma vez por todas.'
            },
            'en': {
                'nav_sobre': 'About',
                'nav_planos': 'Study Plans',
                'nav_depoimentos': 'Testimonials',
                'nav_contato': 'Contact',
                'nav_cta': 'Book Class',
                'mob_nav_cta': 'Contact on WhatsApp',
                'hero_swipe': 'swipe to get to know me <i class="fa-solid fa-arrow-down"></i>',
                'serv_badge': 'Study Plans',
                'serv_title': 'The ideal solution for you',
                'serv_desc': "Choose the program that best suits your current needs and let's accelerate your learning.",
                'card_btn': 'Check Prices',
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
                'depo_desc': 'Real results from those who decided to unlock their English once and for all.'
            }
        };

        const dbTranslations = {!! json_encode($dbTranslations) !!};
        const translations = {
            'pt': { ...staticTranslations['pt'], ...dbTranslations['pt'] },
            'en': { ...staticTranslations['en'], ...dbTranslations['en'] }
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

        updateLanguageUI();

        if (langToggleBtn) {
            langToggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let newLang = currentLang === 'pt' ? 'en' : 'pt_BR';
                
                // Fetch in background to set session
                fetch('/lang/' + newLang).catch(err => console.error(err));
                
                // Update UI without reload
                currentLang = newLang === 'en' ? 'en' : 'pt';
                updateLanguageUI();
            });
        }"""

content = re.sub(r'// Apenas textos estáticos que não estão no banco.*?langToggleBtn\.addEventListener\(\'click\', \(e\) => \{.*?\n\s*\}\);\n\s*\}', js_block, content, flags=re.DOTALL)

# Now we need to manually add data-i18n to all $c tags, depoimentos, and servicos
# This is a bit complex using regex, but we can do some simple replacements:
content = re.sub(r'<title data-i18n="page_title">\{\{ \$c\[\'seo_titulo\'\]->valor \?\? \'[^\']+\' \}\}</title>', r'<title data-i18n="c_seo_titulo">{{ $c[\'seo_titulo\']->valor ?? \'English with Thalita\' }}</title>', content)
content = re.sub(r'<meta name="description" content="\{\{ \$c\[\'seo_descricao\'\]->valor \?\? \'[^\']+\' \}\}">', r'<meta name="description" data-i18n="c_seo_descricao" content="{{ $c[\'seo_descricao\']->valor ?? \'Professora de inglês para quem quer se comunicar com confiança e fluência real.\' }}">', content)

# I'll let the Python script handle the HTML replacements in another pass if needed.
# For now let's just write the script to update the JS and PHP.

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
