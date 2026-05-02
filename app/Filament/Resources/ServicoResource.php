<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicoResource\Pages;
use App\Models\Servico;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class ServicoResource extends Resource
{
    protected static ?string $model = Servico::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $modelLabel = 'Serviço';
    protected static ?string $pluralModelLabel = 'Serviços';
    protected static string | \UnitEnum | null $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Informações do Serviço')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('descricao')
                            ->label('Descrição')
                            ->required(),
                        Forms\Components\TextInput::make('icone')
                            ->label('Ícone (opcional)')
                            ->placeholder('fa-solid fa-star'),
                        Forms\Components\TextInput::make('badge')
                            ->label('Badge (ex: Mais procurado)'),
                        Forms\Components\TextInput::make('badge_cor')
                            ->label('Cor do Badge (ex: text-brand-accent)'),
                        Forms\Components\FileUpload::make('imagem')
                            ->label('Imagem de Capa')
                            ->image()
                            ->directory('servicos'),
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
                            ->directory('seo'),
                    ])
                    ->collapsed()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagem')
                    ->label('Imagem'),
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Serviço')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('esta_ativo')
                    ->label('Ativo'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y'),
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
            'index' => Pages\ListarServicos::route('/'),
            'create' => Pages\CriarServico::route('/create'),
            'edit' => Pages\EditarServico::route('/{record}/edit'),
        ];
    }
}
