<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class GerenciarLogs extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-magnifying-glass';
    protected static ?string $navigationLabel = 'Gerenciamento de Logs';
    protected static string | \UnitEnum | null $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 3;
    protected static ?string $title = 'Gerenciamento de Logs';
    protected static ?string $slug = 'logs';

    protected string $view = 'filament.pages.gerenciar-logs';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('configurarRetencao')
                ->label('Limpeza Automática')
                ->icon('heroicon-o-cog-8-tooth')
                ->color('gray')
                ->form([
                    \Filament\Forms\Components\Select::make('retencao_logs')
                        ->label('Tempo de Armazenamento')
                        ->options([
                            '7' => '7 dias',
                            '15' => '15 dias',
                            '30' => '30 dias',
                            '60' => '60 dias',
                            '90' => '90 dias',
                        ])
                        ->default(fn () => \App\Models\Configuracao::where('chave', 'retencao_logs')->value('valor') ?? '30')
                        ->required()
                        ->helperText('Logs mais antigos que o período selecionado serão excluídos permanentemente para liberar espaço em disco.')
                ])
                ->action(function (array $data) {
                    \App\Models\Configuracao::updateOrCreate(
                        ['chave' => 'retencao_logs'],
                        ['valor' => $data['retencao_logs']]
                    );
                    \Filament\Notifications\Notification::make()
                        ->title('Tempo de retenção atualizado com sucesso!')
                        ->success()
                        ->send();
                })
                ->modalHeading('Configurar Retenção de Logs')
                ->modalWidth('md')
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn () => $this->getAcessos())
            ->columns([
                TextColumn::make('horario')
                    ->label('Data e Hora')
                    ->fontFamily('mono')
                    ->state(fn ($record) => $this->formatarData($record['horario']))
                    ->description(fn ($record) => "ID Sessão: " . substr($record['sessao_id'], 0, 8))
                    ->sortable(),
                
                TextColumn::make('usuario')
                    ->label('Usuário')
                    ->description(fn ($record) => "IP: " . $record['ip']),

                TextColumn::make('navegador')
                    ->label('Navegador')
                    ->html()
                    ->state(fn ($record) => $this->renderBrowserCell($record['agent'])),

                TextColumn::make('acoes_count')
                    ->label('Ações Realizadas')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'info' : 'gray')
                    ->alignCenter(),
            ])
            ->actions([
                \Filament\Actions\Action::make('verAcoes')
                    ->label('Ver ações tomadas')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalHeading(fn ($record) => "Rastreamento de Atividades - Chave: {$record['chave']}")
                    ->modalWidth('4xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fechar')
                    ->modalContent(fn ($record) => view('filament.components.logs-acoes-modal', [
                        'acoes' => $this->getAcoes($record['sessao_id'])
                    ])),
            ])
            ->emptyStateHeading('Nenhum log de acesso disponível')
            ->emptyStateIcon('heroicon-o-document-text');
    }

    protected function renderBrowserCell(string $agent): string
    {
        $browser = 'Desconhecido';
        $icon = 'heroicon-o-globe-alt';

        if (str_contains($agent, 'Edg')) { $browser = 'Microsoft Edge'; $icon = 'heroicon-o-window'; }
        elseif (str_contains($agent, 'OPR') || str_contains($agent, 'Opera')) { $browser = 'Opera'; $icon = 'heroicon-o-variable'; }
        elseif (str_contains($agent, 'Chrome')) { $browser = 'Google Chrome'; $icon = 'heroicon-o-command-line'; }
        elseif (str_contains($agent, 'Firefox')) { $browser = 'Mozilla Firefox'; $icon = 'heroicon-o-fire'; }
        elseif (str_contains($agent, 'Safari')) { $browser = 'Apple Safari'; $icon = 'heroicon-o-compass'; }

        return "<div class=\"flex items-center gap-2 group cursor-help\" title=\"{$browser}\">
                    <div class=\"p-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500\">
                        <svg class=\"w-5 h-5\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\">
                             " . $this->getIconPath($icon) . "
                        </svg>
                    </div>
                    <span class=\"text-xs font-medium text-gray-600 dark:text-gray-400\">{$browser}</span>
                </div>";
    }

    protected function getIconPath(string $icon): string
    {
        // Simplificação para retornar o path do ícone de acordo com o nome
        return match($icon) {
            'heroicon-o-window' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />',
            'heroicon-o-command-line' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />',
            'heroicon-o-fire' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />',
            'heroicon-o-compass' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-6 3 3-6 6-3-3 6zm-3.471-3.471L11.25 12l.279.279a.375.375 0 010 .53l-.53.53a.375.375 0 01-.53 0l-.279-.279-.279.279a.375.375 0 01-.53 0l-.53-.53a.375.375 0 010-.53l.279-.279-.279-.279a.375.375 0 010-.53l.53-.53a.375.375 0 01.53 0l.279.279.279-.279a.375.375 0 01.53 0l.53.53a.375.375 0 010 .53l-.279.279zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
            default => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253" />',
        };
    }

    protected function formatarDadosParaHumano(string $json): array
    {
        $raw = json_decode($json, true);
        if (!$raw) return [];

        // Se for um array simples de strings (comum em Toggles do Filament), 
        // nós ignoramos para não mostrar o botão de detalhes desnecessariamente.
        if (is_array($raw) && count($raw) <= 3 && isset($raw[0]) && is_string($raw[0]) && in_array($raw[0], ['ativo', 'esta_ativo', 'active', 'is_active'])) {
            return [];
        }

        $lista = [];
        
        // Função recursiva simples para achatar o JSON e pegar chaves de dados
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($raw));
        foreach ($iterator as $key => $value) {
            $fullKey = $iterator->key();
            
            // Ignorar campos técnicos do Livewire/Filament
            if (in_array($fullKey, ['method', 'params', 'type', 'async', 'calls', 'path', 'id'])) continue;
            if (str_contains($fullKey, 'metadata')) continue;

            // Evitar que 'antigo' e 'novo' apareçam como nomes de campos (eles são chaves da nossa estrutura)
            if (str_ends_with($fullKey, '.antigo') || str_ends_with($fullKey, '.novo')) continue;
            if (in_array($fullKey, ['antigo', 'novo'])) continue;
            
            // Se for um índice numérico puro, não usamos como label, mas deixamos o iterator continuar
            if (is_numeric($fullKey)) continue;
            
            // Limpar a chave (ex: dados.nome_site -> Nome Site)
            $label = str_replace(['dados.', '_', '.'], ['', ' ', ' '], $fullKey);
            $label = mb_convert_case($label, MB_CASE_TITLE, "UTF-8");

            // Formatar o valor (considerando novo formato De/Para)
            if (is_array($value) && isset($value['novo'])) {
                $valorAntigoStr = is_array($value['antigo']) ? json_encode($value['antigo']) : (string)($value['antigo'] ?? '---');
                $valorNovoStr = is_array($value['novo']) ? json_encode($value['novo']) : (string)$value['novo'];
                
                if (strlen($valorAntigoStr) > 50) $valorAntigoStr = substr($valorAntigoStr, 0, 50) . '...';
                if (strlen($valorNovoStr) > 50) $valorNovoStr = substr($valorNovoStr, 0, 50) . '...';

                $lista[$label] = [
                    'antigo' => $valorAntigoStr,
                    'novo' => $valorNovoStr
                ];
            } else {
                $valorStr = is_array($value) ? json_encode($value) : (string)$value;
                if (strlen($valorStr) > 100) $valorStr = substr($valorStr, 0, 100) . '...';
                $lista[$label] = ['novo' => $valorStr];
            }
        }

        return $lista;
    }

    protected function formatarData(string $data): string
    {
        try {
            if (empty($data)) return '';
            
            // Se já tem barras e está no formato dd/mm/yyyy, retorna
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}/', $data)) {
                return $data;
            }

            // Converte de YYYY-MM-DD para dd/mm/YYYY
            return date('d/m/Y H:i:s', strtotime($data));
        } catch (\Exception $e) {
            return $data;
        }
    }

    public function getAcessos(): Collection
    {
        $caminho = storage_path('logs/acessos.log');
        if (!File::exists($caminho)) return collect();

        $linhas = explode(PHP_EOL, trim(File::get($caminho)));
        $dados = collect();

        foreach (array_reverse($linhas) as $linha) {
            if (empty($linha)) continue;

            if (preg_match('/\[(.*?)\] \[Sessão: (.*?)\] .*? Chave: (.*?) \| Usuário: (.*?) \| IP: (.*?) \| Agent: (.*)/', $linha, $matches)) {
                $sessaoId = $matches[2];
                $caminhoAcao = storage_path("logs/sessoes/sessao_{$sessaoId}.log");
                $acoesCount = File::exists($caminhoAcao) ? count(explode(PHP_EOL, trim(File::get($caminhoAcao)))) : 0;

                $dados->push([
                    'id' => $sessaoId,
                    'horario' => $matches[1],
                    'sessao_id' => $sessaoId,
                    'chave' => $matches[3],
                    'usuario' => $matches[4],
                    'ip' => $matches[5],
                    'agent' => $matches[6],
                    'acoes_count' => $acoesCount,
                ]);
            }
        }

        return $dados;
    }

    public function getAcoes(string $sessaoId): array
    {
        $caminho = storage_path("logs/sessoes/sessao_{$sessaoId}.log");
        if (!File::exists($caminho)) return [];

        $linhas = explode(PHP_EOL, trim(File::get($caminho)));
        $acoes = [];

        foreach ($linhas as $linha) {
            if (empty($linha)) continue;
            
            if (preg_match('/\[(.*?)\] (?:\[.*?\] )?CHAVE: (.*?) \| Usuário: (.*?) \| (?:Ação|Método): (.*?) \| (?:Origem|URL): (.*?)(?: \| Dados: (.*))?$/', $linha, $matches)) {
                $url = $matches[5];
                $metodoOriginal = $matches[4];

                // Mapeamento retroativo para logs antigos (técnicos -> amigáveis)
                $metodoAmigavel = match($metodoOriginal) {
                    'POST', 'PUT', 'PATCH' => 'Alterou',
                    'DELETE' => 'Excluiu',
                    default => $metodoOriginal,
                };

                // Limpar URL caso venha completa (logs antigos)
                if (str_contains($url, 'http')) {
                    $url = parse_url($url, PHP_URL_PATH);
                    $url = str_replace('/admin', '', $url);
                    if (empty($url)) $url = '/';
                }

                $acoes[] = [
                    'horario' => $this->formatarData($matches[1]),
                    'usuario' => $matches[3],
                    'metodo' => $metodoAmigavel,
                    'url' => $url,
                    'dados' => $matches[6] ?? '{}',
                    'dados_amigaveis' => $this->formatarDadosParaHumano($matches[6] ?? '{}'),
                ];
            }
        }

        return array_reverse($acoes);
    }
}
