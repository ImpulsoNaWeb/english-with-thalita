<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracao;
use App\Models\Servico;
use App\Models\Depoimento;

class ConteudoSeeder extends Seeder
{
    public function run(): void
    {
        // Configurações Gerais e Cores
        Configuracao::updateOrCreate(['chave' => 'nome_site'], [
            'valor' => ['pt_BR' => 'English with Thalita', 'en' => 'English with Thalita'],
            'grupo' => 'geral'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'cor_primaria'], [
            'valor' => ['pt_BR' => '#1d8985', 'en' => '#1d8985'],
            'grupo' => 'geral'
        ]);
        
        // Hero
        Configuracao::updateOrCreate(['chave' => 'titulo_hero'], [
            'valor' => ['pt_BR' => "English\nwith\nThalita", 'en' => "English\nwith\nThalita"],
            'grupo' => 'hero'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'subtitulo_hero'], [
            'valor' => [
                'pt_BR' => 'Professora de inglês para quem quer se comunicar com confiança e fluência real',
                'en' => 'English teacher for those who want to communicate with confidence and real fluency'
            ],
            'grupo' => 'hero'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'texto_botao_hero'], [
            'valor' => ['pt_BR' => 'Quero Aprender', 'en' => 'I Want to Learn'],
            'grupo' => 'hero'
        ]);
        
        // Sobre
        Configuracao::updateOrCreate(['chave' => 'sobre_badge'], [
            'valor' => ['pt_BR' => 'Por que escolher as aulas?', 'en' => 'Why choose these classes?'],
            'grupo' => 'sobre'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'sobre_titulo'], [
            'valor' => [
                'pt_BR' => 'Inglês focado na sua comunicação real',
                'en' => 'English focused on your real communication'
            ],
            'grupo' => 'sobre'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'sobre_descricao'], [
            'valor' => [
                'pt_BR' => 'Diga adeus aos métodos engessados. Minhas aulas são desenvolvidas para destravar a sua fala, focando exatamente nos seus objetivos de curto e longo prazo. Seja para o mercado de trabalho, viagens ou certificações internacionais.',
                'en' => 'Say goodbye to rigid methods. My classes are designed to unlock your speech, focusing exactly on your short and long-term goals. Whether for the job market, travel, or international certifications.'
            ],
            'grupo' => 'sobre'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'foto_sobre'], [
            'valor' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'grupo' => 'sobre'
        ]);
        
        // Diferenciais
        $difs_pt = [
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
        ];

        $difs_en = [
            [
                'titulo' => 'Certifications and International Experience',
                'descricao' => 'Certified teacher with international experience, bringing real fluency and the cultural background of someone who lived the language in practice.',
                'icone' => 'fa-solid fa-earth-americas',
                'cor' => 'bg-brand-orange'
            ],
            [
                'titulo' => '100% Personalized Classes',
                'descricao' => 'Content adapted to what you really need to learn right now.',
                'icone' => 'fa-solid fa-crosshairs',
                'cor' => 'bg-brand-card'
            ],
            [
                'titulo' => 'Total Focus on Conversation',
                'descricao' => 'Intensive speaking practice from the first class to lose the fear of making mistakes.',
                'icone' => 'fa-regular fa-comments',
                'cor' => 'bg-brand-accent'
            ],
        ];

        Configuracao::updateOrCreate(['chave' => 'diferenciais'], [
            'valor' => [
                'pt_BR' => $difs_pt,
                'en' => $difs_en
            ],
            'grupo' => 'sobre'
        ]);

        // Contato
        Configuracao::updateOrCreate(['chave' => 'contato_titulo'], [
            'valor' => [
                'pt_BR' => 'Pronto para dar o próximo passo no seu inglês?',
                'en' => 'Ready to take the next step in your English?'
            ],
            'grupo' => 'contato'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'contato_descricao'], [
            'valor' => [
                'pt_BR' => 'Não deixe para amanhã a fluência que você pode começar a construir hoje. Entre em contato pelo WhatsApp e vamos montar o seu plano.',
                'en' => 'Don\'t leave for tomorrow the fluency you can start building today. Get in touch via WhatsApp and let\'s set up your plan.'
            ],
            'grupo' => 'contato'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'contato_caixa_titulo'], [
            'valor' => ['pt_BR' => 'Fale Comigo', 'en' => 'Talk to Me'],
            'grupo' => 'contato'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'contato_caixa_descricao'], [
            'valor' => [
                'pt_BR' => 'Tire dúvidas, verifique disponibilidade de horários e receba os valores atualizados.',
                'en' => 'Ask questions, check schedule availability, and receive updated prices.'
            ],
            'grupo' => 'contato'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'contato_botao'], [
            'valor' => ['pt_BR' => 'Iniciar Conversa', 'en' => 'Start Conversation'],
            'grupo' => 'contato'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'whatsapp_contato'], [
            'valor' => ['pt_BR' => '5519997799589', 'en' => '5519997799589'],
            'grupo' => 'contato'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'contato_email'], [
            'valor' => ['pt_BR' => 'koppthalita@gmail.com', 'en' => 'koppthalita@gmail.com'],
            'grupo' => 'contato'
        ]);

        // SEO
        Configuracao::updateOrCreate(['chave' => 'seo_titulo'], [
            'valor' => [
                'pt_BR' => 'English with Thalita | Aulas de Inglês Online Personalizadas',
                'en' => 'English with Thalita | Personalized Online English Classes'
            ],
            'grupo' => 'seo'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'seo_descricao'], [
            'valor' => [
                'pt_BR' => 'Professora de inglês para quem quer se comunicar com confiança e fluência real.',
                'en' => 'English teacher for those who want to communicate with confidence and real fluency.'
            ],
            'grupo' => 'seo'
        ]);

        // Serviços (Planos)
        Servico::updateOrCreate(['icone' => 'fa-solid fa-fire'], [
            'nome' => ['pt_BR' => 'Conversação na Prática', 'en' => 'Conversation Practice'],
            'descricao' => [
                'pt_BR' => 'Já estuda há um tempo mas ainda trava na hora de falar? Ou já se vira bem, mas não atingiu a fluência que deseja? Nossas aulas são para todos os níveis, 100% personalizadas para o seu interesse e necessidade real.',
                'en' => 'Have you been studying for a while but still freeze when speaking? Or do you manage well but haven\'t reached the fluency you desire? Our classes are for all levels, 100% personalized for your real interest and needs.'
            ],
            'tabela_precos' => [
                'pt_BR' => '<h4>Aulas Particulares (1:1)</h4><ul><li><strong>1x por semana (1h):</strong><ul><li>Mensal: R$600 (R$150/h)</li><li>Trimestral: R$520/mês (R$130/h)</li></ul></li><li><strong>2x por semana (1h cada):</strong><ul><li>Mensal: R$1.120 (R$140/h)</li><li>Trimestral: R$960/mês (R$120/h)</li></ul></li></ul><h4 class="mt-4">Aulas em Grupo (4–6 alunos)</h4><ul><li><strong>1x por semana (1h):</strong><ul><li>Mensal: R$340</li><li>Trimestral: R$300/mês</li></ul></li><li><strong>2x por semana (1h cada):</strong><ul><li>Mensal: R$640</li><li>Trimestral: R$560/mês</li></ul></li></ul>',
                'en' => '<h4>Private Classes (1:1)</h4><ul><li><strong>1x per week (1h):</strong><ul><li>Monthly: R$600 (R$150/h)</li><li>Quarterly: R$520/mo (R$130/h)</li></ul></li><li><strong>2x per week (1h each):</strong><ul><li>Monthly: R$1,120 (R$140/h)</li><li>Quarterly: R$960/mo (R$120/h)</li></ul></li></ul><h4 class="mt-4">Group Classes (4–6 students)</h4><ul><li><strong>1x per week (1h):</strong><ul><li>Monthly: R$340</li><li>Quarterly: R$300/mo</li></ul></li><li><strong>2x per week (1h each):</strong><ul><li>Monthly: R$640</li><li>Quarterly: R$560/mo</li></ul></li></ul>'
            ],
            'badge' => ['pt_BR' => 'Mais procurado', 'en' => 'Most popular'],
            'badge_cor' => 'bg-brand-alert',
            'imagem' => 'seed/servico_conversacao_v2.png',
            'ordem' => 1,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['icone' => 'fa-solid fa-briefcase'], [
            'nome' => ['pt_BR' => 'Business English', 'en' => 'Business English'],
            'descricao' => [
                'pt_BR' => 'Destaque-se no mercado de trabalho. Prepare-se para reuniões, apresentações, entrevistas e negociações com vocabulário corporativo de alto nível.',
                'en' => 'Stand out in the job market. Prepare for meetings, presentations, interviews, and negotiations with high-level corporate vocabulary.'
            ],
            'tabela_precos' => [
                'pt_BR' => '<h4>Aulas particulares (1:1)</h4><ul><li><strong>1x por semana (1h):</strong><ul><li>Mensal: R$760 (R$190/h)</li><li>Trimestral: R$720/mês (R$180/h)</li></ul></li><li><strong>2x por semana (1h cada):</strong><ul><li>Mensal: R$1.400 (R$175/h)</li><li>Trimestral: R$1.320/mês (R$165/h)</li></ul></li></ul>',
                'en' => '<h4>Private classes (1:1)</h4><ul><li><strong>1x per week (1h):</strong><ul><li>Monthly: R$760 (R$190/h)</li><li>Quarterly: R$720/mo (R$180/h)</li></ul></li><li><strong>2x per week (1h each):</strong><ul><li>Monthly: R$1,400 (R$175/h)</li><li>Quarterly: R$1,320/mo (R$165/h)</li></ul></li></ul>'
            ],
            'badge' => ['pt_BR' => 'Carreira', 'en' => 'Career'],
            'badge_cor' => 'bg-brand-orange text-white',
            'imagem' => 'seed/servico_business_v2.png',
            'ordem' => 2,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['icone' => 'fa-solid fa-earth-americas'], [
            'nome' => ['pt_BR' => 'Sobrevivência para Viagens', 'en' => 'Travel Survival'],
            'descricao' => [
                'pt_BR' => 'Aprenda o essencial para se comunicar em aeroportos, hotéis, restaurantes, interações sociais e situações de emergência durante suas viagens.',
                'en' => 'Learn the essentials to communicate in airports, hotels, restaurants, social interactions, and emergency situations during your travels.'
            ],
            'tabela_precos' => [
                'pt_BR' => '<h4>Grupos (até 6 pessoas)</h4><ul><li>Curso de 6 semanas (1h/semana)</li><li>R$570 total por aluno</li><li><strong>Primeiros inscritos: R$470</strong></li></ul><h4 class="mt-4">Intensivo Individual</h4><ul><li>2 semanas (3x/semana - 6 aulas)</li><li>R$1.350 total</li></ul>',
                'en' => '<h4>Groups (up to 6 people)</h4><ul><li>6-week course (1h/week)</li><li>R$570 total per student</li><li><strong>Early bird: R$470</strong></li></ul><h4 class="mt-4">Individual Intensive</h4><ul><li>2 weeks (3x/week - 6 classes)</li><li>R$1,350 total</li></ul>'
            ],
            'badge' => ['pt_BR' => 'Foco Prático', 'en' => 'Practical Focus'],
            'badge_cor' => 'bg-[#7ca7f4]',
            'imagem' => 'seed/servico_viagens_v2.png',
            'ordem' => 3,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['icone' => 'fa-solid fa-gem'], [
            'nome' => ['pt_BR' => 'Inglês Pela Cidade (Presencial)', 'en' => 'English Around the City (In-person)'],
            'descricao' => [
                'pt_BR' => 'Fuja das salas de aula e aprenda inglês onde a vida acontece. Pratique conversação em ambientes reais com suporte total para o seu dia a dia.',
                'en' => 'Escape the classroom and learn English where life happens. Practice conversation in real environments with full support for your daily life.'
            ],
            'tabela_precos' => [
                'pt_BR' => '<h4>Grupo (até 5 pessoas)</h4><ul><li>R$130 por pessoa / encontro</li></ul><h4 class="mt-4">Grupos maiores</h4><ul><li>R$70 – R$100 por pessoa (sob consulta)</li></ul>',
                'en' => '<h4>Group (up to 5 people)</h4><ul><li>R$130 per person / meeting</li></ul><h4 class="mt-4">Larger groups</h4><ul><li>R$70 – R$100 per person (on request)</li></ul>'
            ],
            'badge' => ['pt_BR' => 'VIP', 'en' => 'VIP'],
            'badge_cor' => 'bg-brand-red text-white',
            'imagem' => 'seed/servico_cidade_v2.png',
            'ordem' => 4,
            'esta_ativo' => true,
        ]);

        Servico::updateOrCreate(['icone' => 'fa-solid fa-building'], [
            'nome' => ['pt_BR' => 'Inglês para Empresas', 'en' => 'English for Companies'],
            'descricao' => [
                'pt_BR' => 'Treinamento prático para equipes que atendem clientes em inglês. Conteúdo adaptado à realidade da empresa e acessível para diferentes níveis.',
                'en' => 'Practical training for teams serving customers in English. Content adapted to the company\'s reality and accessible for different levels.'
            ],
            'tabela_precos' => [
                'pt_BR' => '<h4>Consultoria / Diagnóstico Inicial</h4><ul><li>R$570 (abatido caso feche contrato)</li></ul><h4 class="mt-4">Treinamento em Grupo (1x/semana - 8 ou 12 semanas)</h4><ul><li><strong>ONLINE:</strong><ul><li>8 semanas - R$2.300 por grupo</li><li>12 semanas - R$3.300 por grupo</li></ul></li><li><strong>PRESENCIAL:</strong> Treinamentos presenciais podem incluir taxa adicional referente a deslocamento e logística, definida conforme localização da empresa e formato do treinamento.</li></ul><h4 class="mt-4">Workshop Corporativo</h4><ul><li>2 a 3 horas: A partir de R$1.200</li></ul><div class="mt-4"><p class="font-bold">Valor final definido conforme:</p><ul><li>número de participantes</li><li>nível de personalização</li><li>duração</li><li>deslocamento (se presencial)</li></ul></div>',
                'en' => '<h4>Consultancy / Initial Diagnosis</h4><ul><li>R$570 (deducted if contract is closed)</li></ul><h4 class="mt-4">Group Training (1x/week - 8 or 12 weeks)</h4><ul><li><strong>ONLINE:</strong><ul><li>8 weeks - R$2,300 per group</li><li>12 weeks - R$3,300 per group</li></ul></li><li><strong>IN-PERSON:</strong> In-person training may include an additional fee for travel and logistics, defined according to company location and training format.</li></ul><h4 class="mt-4">Corporate Workshop</h4><ul><li>2 to 3 hours: From R$1,200</li></ul><div class="mt-4"><p class="font-bold">Final value defined according to:</p><ul><li>number of participants</li><li>level of customization</li><li>duration</li><li>travel (if in-person)</li></ul></div>'
            ],
            'badge' => ['pt_BR' => 'Corporativo', 'en' => 'Corporate'],
            'badge_cor' => 'bg-brand-accent text-white',
            'imagem' => 'seed/servico_empresas_v2.png',
            'ordem' => 5,
            'esta_ativo' => true,
        ]);

        // Depoimentos
        $depoimentos = [
            [
                'nome' => 'Mariana Silva, 22',
                'cargo' => ['pt_BR' => 'Estudante Universitária', 'en' => 'University Student'],
                'conteudo' => [
                    'pt_BR' => '"Eu travava completamente na hora de falar. Em poucos meses com a Thalita, perdi o medo e consegui a pontuação que precisava no TOEFL para meu intercâmbio!"',
                    'en' => '"I completely froze when speaking. In just a few months with Thalita, I lost the fear and got the TOEFL score I needed for my exchange!"'
                ],
                'avatar' => 'seed/depo_mariana_v2.png'
            ],
            [
                'nome' => 'Carlos Eduardo, 34',
                'cargo' => ['pt_BR' => 'Desenvolvedor Sênior', 'en' => 'Senior Developer'],
                'conteudo' => [
                    'pt_BR' => '"As aulas focadas em Business English mudaram minha carreira. Hoje conduzo reuniões com a equipe gringa sem suar frio. Metodologia muito prática e direto ao ponto."',
                    'en' => '"Business English focused classes changed my career. Today I lead meetings with the international team without breaking a sweat. Very practical and straight-to-the-point methodology."'
                ],
                'avatar' => 'seed/depo_carlos_v2.png'
            ],
            [
                'nome' => 'Fernanda Costa, 45',
                'cargo' => ['pt_BR' => 'Empresária', 'en' => 'Businesswoman'],
                'conteudo' => [
                    'pt_BR' => '"Sempre achei que estava velha para aprender inglês do zero. A Thalita teve tanta paciência e montou um material tão voltado para minhas viagens que hoje me viro super bem sozinha."',
                    'en' => '"I always thought I was too old to learn English from scratch. Thalita had so much patience and put together material so focused on my travels that today I manage very well on my own."'
                ],
                'avatar' => 'seed/depo_fernanda_v2.png'
            ],
            [
                'nome' => 'Amanda Reis, 28',
                'cargo' => ['pt_BR' => 'Designer UX/UI', 'en' => 'UX/UI Designer'],
                'conteudo' => [
                    'pt_BR' => '"O foco em comunicação real faz toda a diferença. Eu sabia gramática mas não falava. Em poucas aulas já estava me expressando muito melhor do que anos em cursinho."',
                    'en' => '"The focus on real communication makes all the difference. I knew grammar but didn\'t speak. In just a few classes, I was already expressing myself much better than years in a language school."'
                ],
                'avatar' => 'seed/depo_amanda_v2.png'
            ],
            [
                'nome' => 'Roberto Alves, 52',
                'cargo' => ['pt_BR' => 'Gerente Comercial', 'en' => 'Sales Manager'],
                'conteudo' => [
                    'pt_BR' => '"Precisava melhorar o inglês para uma promoção. A flexibilidade de horários e as aulas personalizadas foram essenciais para conciliar com minha rotina corrida."',
                    'en' => '"I needed to improve my English for a promotion. The flexible schedule and personalized classes were essential to balance with my busy routine."'
                ],
                'avatar' => 'seed/depo_roberto_v2.png'
            ],
            [
                'nome' => 'Lucas Mendes, 18',
                'cargo' => ['pt_BR' => 'Estudante de Ensino Médio', 'en' => 'High School Student'],
                'conteudo' => [
                    'pt_BR' => '"As aulas não são chatas como na escola. Falamos de assuntos atuais e práticos. Sinto que estou aprendendo o inglês que realmente se usa no dia a dia e na internet."',
                    'en' => '"Classes aren\'t boring like in school. We talk about current and practical topics. I feel like I\'m learning the English that\'s actually used in daily life and on the internet."'
                ],
                'avatar' => 'seed/depo_lucas_v2.png'
            ],
        ];

        Depoimento::query()->forceDelete();
        $index_depo = 1;
        foreach ($depoimentos as $depo) {
            Depoimento::updateOrCreate(['nome_autor' => $depo['nome']], [
                'cargo_autor' => $depo['cargo'],
                'conteudo' => $depo['conteudo'],
                'avatar_autor' => $depo['avatar'],
                'nota' => 5,
                'ordem' => $index_depo++,
                'esta_ativo' => true,
            ]);
        }
    }
}
