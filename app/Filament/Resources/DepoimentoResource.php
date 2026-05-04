<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepoimentoResource\Pages;
use App\Models\Depoimento;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class DepoimentoResource extends Resource
{
    protected static ?string $model = Depoimento::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $modelLabel = 'Depoimento';
    protected static ?string $pluralModelLabel = 'Depoimentos';
    protected static string | \UnitEnum | null $navigationGroup = 'Site';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Depoimento')
                    ->schema([
                        Forms\Components\TextInput::make('nome_autor')
                            ->label('Nome do Autor')
                            ->required(),
                        \Filament\Schemas\Components\Tabs::make('Idiomas')
                            ->tabs([
                                \Filament\Schemas\Components\Tabs\Tab::make('Português')
                                    ->schema([
                                        Forms\Components\TextInput::make('cargo_autor.pt_BR')
                                            ->label('Cargo/Empresa (PT)'),
                                        Forms\Components\Textarea::make('conteudo.pt_BR')
                                            ->label('Comentário (PT)')
                                            ->required(),
                                    ]),
                                \Filament\Schemas\Components\Tabs\Tab::make('Inglês')
                                    ->schema([
                                        Forms\Components\TextInput::make('cargo_autor.en')
                                            ->label('Cargo/Empresa (EN)'),
                                        Forms\Components\Textarea::make('conteudo.en')
                                            ->label('Comentário (EN)'),
                                    ]),
                            ]),
                        Forms\Components\Select::make('nota')
                            ->label('Avaliação')
                            ->options([
                                5 => '5 Estrelas',
                                4 => '4 Estrelas',
                                3 => '3 Estrelas',
                                2 => '2 Estrelas',
                                1 => '1 Estrela',
                            ])
                            ->default(5),
                        Forms\Components\FileUpload::make('avatar_autor')
                            ->label('Foto do Autor')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('depoimentos'),
                        Forms\Components\Toggle::make('esta_ativo')
                            ->label('Ativo')
                            ->default(true),
                    ]),
                \Filament\Schemas\Components\Section::make('SEO Meta')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO'),
                        Forms\Components\Textarea::make('seo_description')
                            ->label('Descrição SEO'),
                        Forms\Components\FileUpload::make('seo_image')
                            ->label('Imagem Open Graph')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('seo'),
                    ])
                    ->collapsed()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_autor')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('nome_autor')
                    ->label('Autor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nota')
                    ->label('Nota')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('esta_ativo')
                    ->label('Ativo'),
            ])
            ->filters([])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListarDepoimentos::route('/'),
            'create' => Pages\CriarDepoimento::route('/create'),
            'edit' => Pages\EditarDepoimento::route('/{record}/edit'),
        ];
    }
}
