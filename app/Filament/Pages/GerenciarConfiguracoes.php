<?php

namespace App\Filament\Pages;

use App\Models\Configuracao;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Tabs;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\WithFileUploads;

class GerenciarConfiguracoes extends Page implements HasSchemas
{
    use InteractsWithSchemas;
    use WithFileUploads;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configurações do Site';
    protected static string | \UnitEnum | null $navigationGroup = 'Site';
    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'Configurações do Site';
    protected static ?string $slug = 'configuracoes';
    protected string $view = 'filament.pages.gerenciar-configuracoes';

    public ?array $dados = [];

    public function mount(): void
    {
        $this->dados = [];
        foreach (Configuracao::all() as $config) {
            $this->dados[$config->chave] = $config->getTranslations('valor');
            
            // Se for um campo que não usa abas no form, pegamos o valor atual
            if (in_array($config->chave, ['nome_site', 'cor_primaria', 'whatsapp_contato', 'contato_email', 'contato_telefone', 'social_instagram', 'social_facebook', 'logo_site', 'favicon_site', 'foto_sobre', 'foto_hero'])) {
                $this->dados[$config->chave] = $config->valor;
            }
        }
        
        // Garantir que campos de arquivo sejam sempre arrays para o Filament
        foreach (['logo_site', 'favicon_site', 'foto_sobre', 'foto_hero'] as $campo) {
            $valor = $this->dados[$campo] ?? null;
            if ($valor) {
                $this->dados[$campo] = is_array($valor) ? $valor : [$valor];
            }
        }
        
        $this->form->fill($this->dados);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Configurações')
                    ->tabs([
                        Tabs\Tab::make('Geral')
                            ->schema([
                                TextInput::make('nome_site')->label('Nome do Site'),
                                FileUpload::make('logo_site')
                                    ->label('Logo')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public'),
                                FileUpload::make('favicon_site')
                                    ->label('Favicon')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public'),
                                ColorPicker::make('cor_primaria')->label('Cor Primária'),
                            ]),
                        Tabs\Tab::make('Hero')
                            ->schema([
                                Tabs::make('Idiomas Hero')
                                    ->tabs([
                                        Tabs\Tab::make('Português')
                                            ->schema([
                                                TextInput::make('titulo_hero.pt_BR')->label('Título do Hero (PT)')->default('English with Thalita'),
                                                Textarea::make('subtitulo_hero.pt_BR')->label('Subtítulo do Hero (PT)'),
                                                TextInput::make('texto_botao_hero.pt_BR')->label('Botão do Hero (PT)')->default('Quero Aprender'),
                                            ]),
                                        Tabs\Tab::make('Inglês')
                                            ->schema([
                                                TextInput::make('titulo_hero.en')->label('Título do Hero (EN)'),
                                                Textarea::make('subtitulo_hero.en')->label('Subtítulo do Hero (EN)'),
                                                TextInput::make('texto_botao_hero.en')->label('Botão do Hero (EN)'),
                                            ]),
                                    ]),
                                FileUpload::make('foto_hero')
                                    ->label('Foto de Fundo do Hero (Opcional)')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public'),
                            ]),
                        Tabs\Tab::make('Sobre')
                            ->schema([
                                FileUpload::make('foto_sobre')
                                    ->label('Foto da Thalita (Seção Sobre)')
                                    ->helperText('Esta é a foto principal que aparece ao lado do texto "Por que escolher as aulas?"')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public')
                                    ->columnSpanFull(),
                                Tabs::make('Idiomas Sobre')
                                    ->tabs([
                                        Tabs\Tab::make('Português')
                                            ->schema([
                                                TextInput::make('sobre_badge.pt_BR')->label('Badge (PT)')->default('Por que escolher as aulas?'),
                                                TextInput::make('sobre_titulo.pt_BR')->label('Título (PT)')->default('Inglês focado na sua comunicação real'),
                                                Textarea::make('sobre_descricao.pt_BR')->label('Descrição (PT)'),
                                                Repeater::make('diferenciais.pt_BR')
                                                    ->label('Diferenciais (PT)')
                                                    ->schema([
                                                        TextInput::make('titulo')->label('Título'),
                                                        Textarea::make('descricao')->label('Descrição'),
                                                        TextInput::make('icone')->label('Classe do Ícone (ex: fa-earth-americas)')->default('fa-solid fa-star'),
                                                        TextInput::make('cor')->label('Classe de Cor (ex: bg-brand-orange)')->default('bg-brand-orange'),
                                                    ])
                                                    ->columns(2)
                                                    ->defaultItems(3),
                                            ]),
                                        Tabs\Tab::make('Inglês')
                                            ->schema([
                                                TextInput::make('sobre_badge.en')->label('Badge (EN)'),
                                                TextInput::make('sobre_titulo.en')->label('Título (EN)'),
                                                Textarea::make('sobre_descricao.en')->label('Descrição (EN)'),
                                                Repeater::make('diferenciais.en')
                                                    ->label('Diferenciais (EN)')
                                                    ->schema([
                                                        TextInput::make('titulo')->label('Título'),
                                                        Textarea::make('descricao')->label('Descrição'),
                                                        TextInput::make('icone')->label('Classe do Ícone (ex: fa-earth-americas)')->default('fa-solid fa-star'),
                                                        TextInput::make('cor')->label('Classe de Cor (ex: bg-brand-orange)')->default('bg-brand-orange'),
                                                    ])
                                                    ->columns(2)
                                                    ->defaultItems(3),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Planos de Estudo')
                            ->schema([
                                Tabs::make('Idiomas Planos')
                                    ->tabs([
                                        Tabs\Tab::make('Português')
                                            ->schema([
                                                TextInput::make('secao_planos_badge.pt_BR')->label('Badge da Seção (PT)'),
                                                TextInput::make('secao_planos_titulo.pt_BR')->label('Título da Seção (PT)'),
                                                Textarea::make('secao_planos_descricao.pt_BR')->label('Descrição da Seção (PT)'),
                                                TextInput::make('texto_whatsapp_modal.pt_BR')->label('Botão do Modal WhatsApp (PT)'),
                                                TextInput::make('whatsapp_mensagem_plano.pt_BR')->label('Template de Mensagem WhatsApp (PT)')->helperText('Use [PLAN] para o nome do plano.'),
                                            ]),
                                        Tabs\Tab::make('Inglês')
                                            ->schema([
                                                TextInput::make('secao_planos_badge.en')->label('Badge da Seção (EN)'),
                                                TextInput::make('secao_planos_titulo.en')->label('Título da Seção (EN)'),
                                                Textarea::make('secao_planos_descricao.en')->label('Descrição da Seção (EN)'),
                                                TextInput::make('texto_whatsapp_modal.en')->label('Botão do Modal WhatsApp (EN)'),
                                                TextInput::make('whatsapp_mensagem_plano.en')->label('Template de Mensagem WhatsApp (EN)')->helperText('Use [PLAN] para o nome do plano.'),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Depoimentos')
                            ->schema([
                                Tabs::make('Idiomas Depoimentos')
                                    ->tabs([
                                        Tabs\Tab::make('Português')
                                            ->schema([
                                                TextInput::make('secao_depoimentos_badge.pt_BR')->label('Badge da Seção (PT)'),
                                                TextInput::make('secao_depoimentos_titulo.pt_BR')->label('Título da Seção (PT)'),
                                                Textarea::make('secao_depoimentos_descricao.pt_BR')->label('Descrição da Seção (PT)'),
                                            ]),
                                        Tabs\Tab::make('Inglês')
                                            ->schema([
                                                TextInput::make('secao_depoimentos_badge.en')->label('Badge da Seção (EN)'),
                                                TextInput::make('secao_depoimentos_titulo.en')->label('Título da Seção (EN)'),
                                                Textarea::make('secao_depoimentos_descricao.en')->label('Descrição da Seção (EN)'),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Footer')
                            ->schema([
                                Tabs::make('Idiomas Footer')
                                    ->tabs([
                                        Tabs\Tab::make('Português')
                                            ->schema([
                                                Textarea::make('footer_descricao.pt_BR')->label('Descrição do Rodapé (PT)'),
                                            ]),
                                        Tabs\Tab::make('Inglês')
                                            ->schema([
                                                Textarea::make('footer_descricao.en')->label('Descrição do Rodapé (EN)'),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Tabs::make('Idiomas SEO')
                                    ->tabs([
                                        Tabs\Tab::make('Português')
                                            ->schema([
                                                TextInput::make('seo_titulo.pt_BR')->label('Título SEO (PT)'),
                                                TextInput::make('seo_descricao.pt_BR')->label('Descrição SEO (PT)'),
                                                TagsInput::make('seo_keywords.pt_BR')->label('Palavras-chave SEO (PT)'),
                                            ]),
                                        Tabs\Tab::make('Inglês')
                                            ->schema([
                                                TextInput::make('seo_titulo.en')->label('Título SEO (EN)'),
                                                TextInput::make('seo_descricao.en')->label('Descrição SEO (EN)'),
                                                TagsInput::make('seo_keywords.en')->label('Palavras-chave SEO (EN)'),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Contato')
                            ->schema([
                                Tabs::make('Idiomas Contato')
                                    ->tabs([
                                        Tabs\Tab::make('Português')
                                            ->schema([
                                                TextInput::make('contato_titulo.pt_BR')->label('Título do Bloco (PT)'),
                                                Textarea::make('contato_descricao.pt_BR')->label('Descrição do Bloco (PT)'),
                                                TextInput::make('contato_caixa_titulo.pt_BR')->label('Título da Caixa Interna (PT)'),
                                                Textarea::make('contato_caixa_descricao.pt_BR')->label('Descrição da Caixa Interna (PT)'),
                                                TextInput::make('contato_botao.pt_BR')->label('Texto do Botão (PT)'),
                                            ]),
                                        Tabs\Tab::make('Inglês')
                                            ->schema([
                                                TextInput::make('contato_titulo.en')->label('Título do Bloco (EN)'),
                                                Textarea::make('contato_descricao.en')->label('Descrição do Bloco (EN)'),
                                                TextInput::make('contato_caixa_titulo.en')->label('Título da Caixa Interna (EN)'),
                                                Textarea::make('contato_caixa_descricao.en')->label('Descrição da Caixa Interna (EN)'),
                                                TextInput::make('contato_botao.en')->label('Texto do Botão (EN)'),
                                            ]),
                                    ]),
                                TextInput::make('whatsapp_contato')->label('WhatsApp'),
                                TextInput::make('contato_email')->label('E-mail'),
                                TextInput::make('contato_telefone')->label('Telefone'),
                            ]),
                        Tabs\Tab::make('Redes Sociais')
                            ->schema([
                                TextInput::make('social_instagram')->label('Instagram (URL)'),
                                TextInput::make('social_facebook')->label('Facebook (URL)'),
                            ])
                    ])
            ])
            ->statePath('dados');
    }

    public function salvar(): void
    {
        $dados = $this->form->getState();
 
        foreach ($dados as $chave => $valor) {
            Configuracao::updateOrCreate(['chave' => $chave], ['valor' => $valor]);
        }
 
        Notification::make()->title('Configurações salvas!')->success()->send();
    }
}
