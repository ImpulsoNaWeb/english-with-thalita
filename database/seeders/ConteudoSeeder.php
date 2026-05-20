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
        
        Configuracao::updateOrCreate(['chave' => 'foto_hero'], [
            'valor' => null,
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
            'valor' => 'seed/sobre_thalita.jpg',
            'grupo' => 'sobre'
        ]);
        
        Configuracao::updateOrCreate(['chave' => 'filosofia_ensino'], [
            'valor' => [
                'pt_BR' => 'Quero que meus alunos sintam que eu acredito neles, que quero ajudá-los a enxergar do que são capazes e mostrar que aprender inglês pode ser divertido, significativo e inspirador.',
                'en' => 'I want my students to feel that I believe in them, want to help them see what they are capable of, and show them that learning English can be fun, meaningful, and inspiring.'
            ],
            'grupo' => 'sobre'
        ]);
        
        $principios_pt = [
            ['texto' => 'Construir confiança vem antes da perfeição.'],
            ['texto' => 'A comunicação vem antes da gramática.'],
            ['texto' => 'A curiosidade é mais importante do que a memorização.'],
            ['texto' => 'Os erros fazem parte do processo.'],
            ['texto' => 'Todo aluno é mais capaz do que imagina.'],
            ['texto' => 'O inglês é uma ferramenta de expressão pessoal.'],
            ['texto' => 'Aprender deve ser algo significativo e prazeroso.'],
            ['texto' => 'Grandes professores ajudam seus alunos a acreditarem em si mesmos.'],
        ];

        $principios_en = [
            ['texto' => 'Build confidence before perfection.'],
            ['texto' => 'Communication comes before grammar.'],
            ['texto' => 'Curiosity is more important than memorization.'],
            ['texto' => 'Mistakes are part of the process.'],
            ['texto' => 'Every student is more capable than they think.'],
            ['texto' => 'English is a tool for self-expression.'],
            ['texto' => 'Learning should feel meaningful and enjoyable.'],
            ['texto' => 'Great teachers help students believe in themselves.'],
        ];

        Configuracao::updateOrCreate(['chave' => 'principios_aulas'], [
            'valor' => [
                'pt_BR' => $principios_pt,
                'en' => $principios_en
            ],
            'grupo' => 'sobre'
        ]);

        Configuracao::updateOrCreate(['chave' => 'secao_principios_badge'], [
            'valor' => [
                'pt_BR' => 'Princípios Fundamentais',
                'en' => 'Core Principles'
            ],
            'grupo' => 'sobre'
        ]);

        Configuracao::updateOrCreate(['chave' => 'secao_principios_titulo'], [
            'valor' => [
                'pt_BR' => 'Como funcionam as minhas aulas',
                'en' => 'How my classes work'
            ],
            'grupo' => 'sobre'
        ]);

        Configuracao::updateOrCreate(['chave' => 'secao_principios_descricao'], [
            'valor' => [
                'pt_BR' => 'Pilares que transformam o aprendizado de inglês em uma experiência leve, prática e transformadora.',
                'en' => 'Pillars that transform English learning into a light, practical, and life-changing experience.'
            ],
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

        // Textos das Seções
        Configuracao::updateOrCreate(['chave' => 'secao_planos_badge'], [
            'valor' => ['pt_BR' => 'Planos de Estudo', 'en' => 'Study Plans'],
            'grupo' => 'planos'
        ]);
        Configuracao::updateOrCreate(['chave' => 'secao_planos_titulo'], [
            'valor' => ['pt_BR' => 'A solução ideal para você', 'en' => 'The ideal solution for you'],
            'grupo' => 'planos'
        ]);
        Configuracao::updateOrCreate(['chave' => 'secao_planos_descricao'], [
            'valor' => [
                'pt_BR' => 'Escolha o programa que mais se adequa à sua necessidade atual e vamos acelerar o seu aprendizado.',
                'en' => 'Choose the program that best suits your current needs and let\'s accelerate your learning.'
            ],
            'grupo' => 'planos'
        ]);

        Configuracao::updateOrCreate(['chave' => 'secao_depoimentos_badge'], [
            'valor' => ['pt_BR' => 'Histórias de Sucesso', 'en' => 'Success Stories'],
            'grupo' => 'depoimentos'
        ]);
        Configuracao::updateOrCreate(['chave' => 'secao_depoimentos_titulo'], [
            'valor' => ['pt_BR' => 'O que dizem os alunos', 'en' => 'What students say'],
            'grupo' => 'depoimentos'
        ]);
        Configuracao::updateOrCreate(['chave' => 'secao_depoimentos_descricao'], [
            'valor' => [
                'pt_BR' => 'Resultados reais de quem decidiu destravar o inglês de uma vez por todas.',
                'en' => 'Real results from those who decided to unlock their English once and for all.'
            ],
            'grupo' => 'depoimentos'
        ]);

        Configuracao::updateOrCreate(['chave' => 'footer_descricao'], [
            'valor' => [
                'pt_BR' => 'Transformando o seu inglês de um obstáculo para uma ponte que conecta você ao mundo.',
                'en' => 'Transforming your English from an obstacle into a bridge that connects you to the world.'
            ],
            'grupo' => 'footer'
        ]);

        Configuracao::updateOrCreate(['chave' => 'texto_whatsapp_modal'], [
            'valor' => ['pt_BR' => 'Falar com a Thalita no WhatsApp', 'en' => 'Talk to Thalita on WhatsApp'],
            'grupo' => 'planos'
        ]);

        Configuracao::updateOrCreate(['chave' => 'whatsapp_mensagem_plano'], [
            'valor' => [
                'pt_BR' => 'Olá, vi os detalhes do plano [PLAN] e gostaria de conversar!',
                'en' => 'Hi, I saw the details for the [PLAN] plan and would like to talk!'
            ],
            'grupo' => 'planos'
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
                'nome' => 'Fernanda Rodrigues',
                'conteudo' => [
                    'pt_BR' => 'A professora Thalita é incrível! Suas aulas são muito dinâmicas, criativas e informativas. Eu adorei conhecê-la e ter a oportunidade de melhorar meu inglês com ela. Ela incentiva seus alunos de forma natural a falar e praticar durante as aulas. Obrigada, professora Thalita, por todo o seu esforço e dedicação conosco.',
                    'en' => 'Teacher Thalita is amazing! Her classes are so dynamic, creative, and informative. I really liked meeting her to improve my English. She naturally encourages her students to speak and practice during classes. Thank you, teacher Thalita, for your effort and dedication to us.'
                ]
            ],
            [
                'nome' => 'Sara França',
                'conteudo' => [
                    'pt_BR' => 'O que eu mais gosto nas aulas da Thalita é que ela vai além da gramática e do inglês dos livros. Por ter experiência real com a língua e com a cultura, sinto que estou aprendendo o tipo de inglês que as pessoas realmente usam no dia a dia. As aulas dela me ajudaram a me sentir mais confortável para falar em inglês e mais confiante para usar o idioma de forma natural.',
                    'en' => 'What I like most about Thalita’s classes is that she teaches beyond grammar and textbook English. Because of her real experience with the language and the culture, I feel like I’m learning the kind of English people actually use in real life. Her classes have helped me feel more comfortable speaking English and more confident using the language naturally.'
                ]
            ],
            [
                'nome' => 'Andressa Couto',
                'conteudo' => [
                    'pt_BR' => 'A Thalita é uma professora incrível! Estudar inglês com ela torna o aprendizado uma experiência realmente prazerosa. Não se trata apenas de gramática e comunicação: ela cria um ambiente acolhedor e seguro, que nos ajuda a perder a timidez e o medo de cometer erros.',
                    'en' => 'Thalita is an amazing teacher! Studying English with her makes learning a truly enjoyable experience. It\'s not just about the grammar and communication skills: she creates a safe environment that helps us overcome shyness and the fear of making mistakes.'
                ]
            ],
            [
                'nome' => 'Bryan Sheldon',
                'conteudo' => [
                    'pt_BR' => 'Comecei as aulas com um pouco de ceticismo, mas logo percebi ótimos resultados. As aulas são totalmente personalizadas, com temas do meu interesse e aplicações reais para a minha profissão. Aprender falando sobre assuntos que gosto tornou o processo muito mais divertido e contribuiu bastante para expandir meu vocabulário. Isso me ajudou a destravar o inglês, e continuo fazendo aulas de conversação para manter o idioma afiado.',
                    'en' => 'I started my classes with a bit of skepticism, but I quickly noticed great results. The lessons are fully personalized, with topics that match my interests and real-life applications for my profession. Learning by talking about subjects I enjoy made the process much more fun and helped me expand my vocabulary significantly. It helped me become much more comfortable speaking English, and I continue taking conversation classes to keep my skills sharp.'
                ]
            ],
            [
                'nome' => 'Fernando de Medeiros',
                'conteudo' => [
                    'pt_BR' => 'A Thalita é extremamente compreensiva e se dedica a ajudar você a evoluir na pronúncia e na gramática. O melhor de tudo é que ela não corrige como uma professora formal, ela conversa com você como uma falante nativa. Ela realmente entende o que você está tentando dizer e apenas ajusta os detalhes para que sua comunicação flua de forma natural. A experiência se parece muito mais com uma mentoria do que com uma aula tradicional e rígida.',
                    'en' => 'Thalita is incredibly understanding and puts so much effort into helping you level up your pronunciation and grammar. The best part is that she doesn’t just correct you like a formal teacher; she talks to you like a natural speaker. She really gets what you’re trying to say and just fine-tunes the details to make your conversation flow naturally. It feels more like a mentorship than a rigid usual class.'
                ]
            ],
            [
                'nome' => 'Beatriz Zulini',
                'conteudo' => [
                    'pt_BR' => 'A teacher Thalita é uma professora incrível, ensina muito bem, é engraçada e divertida tornando as aulas mais leves! Eu senti que melhorei muito com as aulas dela, principalmente porque ela não usa muito português durante as aulas, então a gente tem que se virar no inglês e isso nos ajuda muito! Eu super indico 😍',
                    'en' => 'Teacher Thalita is an amazing teacher. She explains things very well and is funny and engaging, which makes her classes feel light and enjoyable. I feel that I improved a lot with her classes, especially because she uses very little Portuguese, so we have to express ourselves in English, and that helps us tremendously. I highly recommend her classes! 😍'
                ]
            ]
        ];

        Depoimento::query()->forceDelete();
        $index_depo = 1;
        foreach ($depoimentos as $depo) {
            Depoimento::updateOrCreate(['nome_autor' => $depo['nome']], [
                'cargo_autor' => ['pt_BR' => '', 'en' => ''],
                'conteudo' => $depo['conteudo'],
                'avatar_autor' => '',
                'nota' => 5,
                'ordem' => $index_depo++,
                'esta_ativo' => true,
            ]);
        }
    }
}
