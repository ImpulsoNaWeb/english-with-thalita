import re

with open('resources/views/welcome.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

replacements = [
    ('<meta name="description" content=', '<meta name="description" data-i18n="c_seo_descricao" content='),
    ('{{ $c[\'nome_site\']->valor ?? \'English with Thalita\' }}', '<span data-i18n="c_nome_site">{{ $c[\'nome_site\']->valor ?? \'English with Thalita\' }}</span>'),
    ('<h1\n                            class="text-5xl md:text-7xl lg:text-[80px] font-black text-brand-dark leading-[1.1] tracking-tight">',
     '<h1 data-i18n="c_titulo_hero"\n                            class="text-5xl md:text-7xl lg:text-[80px] font-black text-brand-dark leading-[1.1] tracking-tight">'),
    ('<p data-i18n="hero_subtitle"', '<p data-i18n="c_subtitulo_hero"'),
    ('<span data-i18n="hero_cta"', '<span data-i18n="c_texto_botao_hero"'),
    ('<span data-i18n="sobre_badge"', '<span data-i18n="c_sobre_badge"'),
    ('<h2 data-i18n="sobre_title"', '<h2 data-i18n="c_sobre_titulo"'),
    ('<p data-i18n="sobre_desc"', '<p data-i18n="c_sobre_descricao"'),
    ('{{ $dif[\'titulo\'] }}', '<span data-i18n="dif_titulo_{{ $index }}">{{ $dif[\'titulo\'] }}</span>'),
    ('{{ $dif[\'descricao\'] }}', '<span data-i18n="dif_desc_{{ $index }}">{{ $dif[\'descricao\'] }}</span>'),
    ('{{ $servico->titulo }}', '<span data-i18n="serv_titulo_{{ $index }}">{{ $servico->titulo }}</span>'),
    ('{{ $servico->descricao }}', '<span data-i18n="serv_desc_{{ $index }}">{{ $servico->descricao }}</span>'),
    ('{{ $depo->nome_autor }}', '<span data-i18n="depo_nome_{{ $index }}">{{ $depo->nome_autor }}</span>'),
    ('{{ $depo->cargo_autor }}', '<span data-i18n="depo_cargo_{{ $index }}">{{ $depo->cargo_autor }}</span>'),
    ('"{{ $depo->conteudo }}"', '<span data-i18n="depo_conteudo_{{ $index }}">"{{ $depo->conteudo }}"</span>'),
    ('<h2 data-i18n="contato_title"', '<h2 data-i18n="c_contato_titulo"'),
    ('<p data-i18n="contato_desc"', '<p data-i18n="c_contato_descricao"'),
    ('<span data-i18n="contato_btn">{{ $c[\'contato_botao\'] ?? \'Iniciar Conversa\' }}</span>', '<span data-i18n="c_contato_botao">{{ $c[\'contato_botao\']->valor ?? \'Iniciar Conversa\' }}</span>'),
    ('<h3 data-i18n="contato_box_title"', '<h3 data-i18n="c_contato_caixa_titulo"'),
    ('<p data-i18n="contato_box_desc"', '<p data-i18n="c_contato_caixa_descricao"')
]

for old, new in replacements:
    content = content.replace(old, new)

with open('resources/views/welcome.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
