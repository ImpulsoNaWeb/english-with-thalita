<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracao;
use App\Models\Servico;
use App\Models\Produto;
use App\Models\Depoimento;
use App\Models\Categoria;
use App\Models\Marca;

class ConteudoSeeder extends Seeder
{
    public function run(): void
    {
        // Configurações Gerais e Cores
        Configuracao::updateOrCreate(['chave' => 'nome_site'], ['valor' => 'English with Thalita', 'grupo' => 'geral']);
        Configuracao::updateOrCreate(['chave' => 'cor_primaria'], ['valor' => '#1d8985', 'grupo' => 'geral']);
        
        // Hero
        Configuracao::updateOrCreate(['chave' => 'titulo_hero'], ['valor' => 'English with Thalita', 'grupo' => 'hero']);
        Configuracao::updateOrCreate(['chave' => 'subtitulo_hero'], ['valor' => 'Professora de inglês para quem quer se comunicar com confiança e fluência real', 'grupo' => 'hero']);
        Configuracao::updateOrCreate(['chave' => 'texto_botao_hero'], ['valor' => 'Quero Aprender', 'grupo' => 'hero']);
        
        // Sobre
        Configuracao::updateOrCreate(['chave' => 'sobre_badge'], ['valor' => 'Por que escolher as aulas?', 'grupo' => 'sobre']);
        Configuracao::updateOrCreate(['chave' => 'sobre_titulo'], ['valor' => 'Inglês focado na sua comunicação real', 'grupo' => 'sobre']);
        Configuracao::updateOrCreate(['chave' => 'sobre_descricao'], ['valor' => 'Diga adeus aos métodos engessados. Minhas aulas são desenvolvidas para destravar a sua fala, focando exatamente nos seus objetivos de curto e longo prazo. Seja para o mercado de trabalho, viagens ou certificações internacionais.', 'grupo' => 'sobre']);
        
        Configuracao::updateOrCreate(['chave' => 'diferenciais'], ['valor' => [
            [
                'titulo' => 'Certificações e Vivência Exterior',
                'descricao' => 'Professora certificada com experiência internacional, trazendo a fluência real e a bagagem cultural de quem viveu o idioma na prática.',
                'icone' => 'fa-solid fa-earth-americas',
                'cor' => 'bg-brand-orange'
            ],
            [
                'titulo' => 'Aulas 100% Personalizadas',
                'descricao' => 'Conteúdo adaptado para o que você realmente precisa aprender no momento.',
                'icone' => 'fa-solid fa-crosshairs',
                'cor' => 'bg-brand-card'
            ],
            [
                'titulo' => 'Foco Total em Conversação',
                'descricao' => 'Prática intensiva de speaking desde a primeira aula para perder o medo de errar.',
                'icone' => 'fa-regular fa-comments',
                'cor' => 'bg-brand-accent'
            ],
        ], 'grupo' => 'sobre']);

        // Contato
        Configuracao::updateOrCreate(['chave' => 'contato_titulo'], ['valor' => 'Pronto para dar o próximo passo no seu inglês?', 'grupo' => 'contato']);
        Configuracao::updateOrCreate(['chave' => 'contato_descricao'], ['valor' => 'Não deixe para amanhã a fluência que você pode começar a construir hoje. Entre em contato pelo WhatsApp e vamos montar o seu plano.', 'grupo' => 'contato']);
        Configuracao::updateOrCreate(['chave' => 'contato_caixa_titulo'], ['valor' => 'Fale Comigo', 'grupo' => 'contato']);
        Configuracao::updateOrCreate(['chave' => 'contato_caixa_descricao'], ['valor' => 'Tire dúvidas, verifique disponibilidade de horários e receba os valores atualizados.', 'grupo' => 'contato']);
        Configuracao::updateOrCreate(['chave' => 'contato_botao'], ['valor' => 'Iniciar Conversa', 'grupo' => 'contato']);
        Configuracao::updateOrCreate(['chave' => 'whatsapp_contato'], ['valor' => '5519997799589', 'grupo' => 'contato']);
        Configuracao::updateOrCreate(['chave' => 'contato_email'], ['valor' => 'koppthalita@gmail.com', 'grupo' => 'contato']);

        // SEO
        Configuracao::updateOrCreate(['chave' => 'seo_titulo'], ['valor' => 'English with Thalita | Aulas de Inglês Online Personalizadas', 'grupo' => 'seo']);
        Configuracao::updateOrCreate(['chave' => 'seo_descricao'], ['valor' => 'Professora de inglês para quem quer se comunicar com confiança e fluência real.', 'grupo' => 'seo']);

        // Serviços (Planos)
        Servico::updateOrCreate(['nome' => 'Foco na Conversação'], [
            'descricao' => 'Já estuda há um tempo mas ainda trava na hora de falar? Ou já se vira bem, mas não atingiu a fluência que deseja? Nossas aulas são para todos os níveis, 100% personalizadas para o seu interesse e necessidade real.',
            'badge' => 'Mais procurado',
            'badge_cor' => 'bg-brand-alert',
            'icone' => 'fa-solid fa-fire',
            'ordem' => 1,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['nome' => 'Business English'], [
            'descricao' => 'Destaque-se no mercado de trabalho. Prepare-se para reuniões, apresentações, entrevistas e negociações com vocabulário corporativo de alto nível.',
            'badge' => 'Carreira',
            'badge_cor' => 'bg-brand-orange text-white',
            'icone' => 'fa-solid fa-briefcase',
            'ordem' => 2,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['nome' => 'Sobrevivência para Viagens'], [
            'descricao' => 'Aprenda o essencial para se comunicar em aeroportos, hotéis, restaurantes, interações sociais e situações de emergência durante suas viagens.',
            'badge' => 'Foco Prático',
            'badge_cor' => 'bg-[#7ca7f4]',
            'icone' => 'fa-solid fa-earth-americas',
            'ordem' => 3,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['nome' => 'Inglês Pela Cidade (Presencial)'], [
            'descricao' => 'Fuja das salas de aula e aprenda inglês onde a vida acontece. Pratique conversação em ambientes reais com suporte total para o seu dia a dia.',
            'badge' => 'VIP',
            'badge_cor' => 'bg-brand-red text-white',
            'icone' => 'fa-solid fa-gem',
            'ordem' => 4,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['nome' => 'Inglês para Empresas'], [
            'descricao' => 'Treinamento prático para equipes que atendem clientes em inglês. Conteúdo adaptado à realidade da empresa e acessível para diferentes níveis.',
            'badge' => 'Corporativo',
            'badge_cor' => 'bg-brand-accent text-white',
            'icone' => 'fa-solid fa-building',
            'ordem' => 5,
            'esta_ativo' => true,
        ]);

        // Depoimentos
        $depoimentos = [
            ['Mariana Silva, 22', 'Estudante Universitária', '"Eu travava completamente na hora de falar. Em poucos meses com a Thalita, perdi o medo e consegui a pontuação que precisava no TOEFL para meu intercâmbio!"'],
            ['Carlos Eduardo, 34', 'Desenvolvedor Sênior', '"As aulas focadas em Business English mudaram minha carreira. Hoje conduzo reuniões com a equipe gringa sem suar frio. Metodologia muito prática e direto ao ponto."'],
            ['Fernanda Costa, 45', 'Empresária', '"Sempre achei que estava velha para aprender inglês do zero. A Thalita teve tanta paciência e montou um material tão voltado para minhas viagens que hoje me viro super bem sozinha."'],
            ['Amanda Reis, 28', 'Designer UX/UI', '"O foco em comunicação real faz toda a diferença. Eu sabia gramática mas não falava. Em poucas aulas já estava me expressando muito melhor do que anos em cursinho."'],
            ['Roberto Alves, 52', 'Gerente Comercial', '"Precisava melhorar o inglês para uma promoção. A flexibilidade de horários e as aulas personalizadas foram essenciais para conciliar com minha rotina corrida."'],
            ['Lucas Mendes, 18', 'Estudante de Ensino Médio', '"As aulas não são chatas como na escola. Falamos de assuntos atuais e práticos. Sinto que estou aprendendo o inglês que realmente se usa no dia a dia e na internet."'],
        ];

        foreach ($depoimentos as $depo) {
            Depoimento::updateOrCreate(['nome_autor' => $depo[0]], [
                'cargo_autor' => $depo[1],
                'conteudo' => $depo[2],
                'nota' => 5,
                'esta_ativo' => true,
            ]);
        }
    }
}
