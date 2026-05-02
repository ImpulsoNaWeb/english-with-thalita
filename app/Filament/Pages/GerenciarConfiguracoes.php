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
        $this->dados = Configuracao::all()->pluck('valor', 'chave')->toArray();
        
        // Garantir que campos de arquivo sejam sempre arrays para o Filament
        foreach (['logo_site', 'favicon_site'] as $campo) {
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
                                TextInput::make('titulo_hero')->label('Título do Hero')->default('English with Thalita'),
                                Textarea::make('subtitulo_hero')->label('Subtítulo do Hero'),
                                TextInput::make('texto_botao_hero')->label('Botão do Hero')->default('Quero Aprender'),
                            ]),
                        Tabs\Tab::make('Sobre')
                            ->schema([
                                TextInput::make('sobre_badge')->label('Badge')->default('Por que escolher as aulas?'),
                                TextInput::make('sobre_titulo')->label('Título')->default('Inglês focado na sua comunicação real'),
                                Textarea::make('sobre_descricao')->label('Descrição'),
                                Repeater::make('diferenciais')
                                    ->label('Diferenciais')
                                    ->schema([
                                        TextInput::make('titulo')->label('Título'),
                                        Textarea::make('descricao')->label('Descrição'),
                                        TextInput::make('icone')->label('Classe do Ícone (ex: fa-earth-americas)')->default('fa-solid fa-star'),
                                        TextInput::make('cor')->label('Classe de Cor (ex: bg-brand-orange)')->default('bg-brand-orange'),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(3),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                TextInput::make('seo_titulo')->label('Título SEO'),
                                TextInput::make('seo_descricao')->label('Descrição SEO'),
                                TagsInput::make('seo_keywords')->label('Palavras-chave SEO'),
                            ]),
                        Tabs\Tab::make('Contato')
                            ->schema([
                                TextInput::make('contato_titulo')->label('Título do Bloco'),
                                Textarea::make('contato_descricao')->label('Descrição do Bloco'),
                                TextInput::make('contato_caixa_titulo')->label('Título da Caixa Interna'),
                                Textarea::make('contato_caixa_descricao')->label('Descrição da Caixa Interna'),
                                TextInput::make('contato_botao')->label('Texto do Botão'),
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
