<?php

namespace App\Filament\Pages;


use App\Models\Depoimento;
use App\Models\Servico;
use App\Models\Configuracao;
use App\Models\Visita;
use App\Models\Backup;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class GerenciarDados extends Page implements HasTable, HasSchemas
{
    use WithFileUploads, InteractsWithTable, InteractsWithSchemas;

    public ?array $data = [];

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationLabel = 'Gerenciamento de Dados';
    protected static string | \UnitEnum | null $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Backup e Restauração';
    protected static ?string $slug = 'gerenciar-dados';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Importar Backup (Upload)')
                    ->description('Faça upload de um backup externo para restaurar os dados do site.')
                    ->schema([
                        FileUpload::make('file')
                            ->label('Arquivo JSON (.json)')
                            ->acceptedFileTypes(['application/json'])
                            ->required()
                            ->columnSpanFull(),
                            
                        TextInput::make('importPassword')
                            ->label('Senha de Descriptografia')
                            ->password()
                            ->placeholder('Informe a senha do arquivo...')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->footerActions([
                        Action::make('importar')
                            ->label('Validar e Restaurar')
                            ->color('warning')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->action(fn () => $this->importarDados())
                    ])
            ])
            ->statePath('data');
    }

    public static function getNavigationBadge(): ?string
    {
        return Backup::count();
    }

    protected string $view = 'filament.pages.gerenciar-dados';

    protected function gerarBackupInterno(string $senha): string
    {
        $contagens = [
            'configuracoes' => Configuracao::count(),
            'servicos' => Servico::count(),
            'depoimentos' => Depoimento::count(),
        ];

        $conteudoBruto = [
            'configuracoes' => Configuracao::all(),
            'servicos' => Servico::all(),
            'depoimentos' => Depoimento::all(),
            'visitas' => Visita::limit(5000)->get(),
            'logs' => [
                'acessos' => File::exists(storage_path('logs/acessos.log')) ? File::get(storage_path('logs/acessos.log')) : '',
                'sessoes' => collect(File::exists(storage_path('logs/sessoes')) ? File::files(storage_path('logs/sessoes')) : [])
                    ->mapWithKeys(fn ($file) => [$file->getFilename() => File::get($file->getPathname())])
                    ->toArray(),
            ],
        ];

        $jsonParaCriptografar = json_encode($conteudoBruto, JSON_UNESCAPED_UNICODE);
        
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $criptografado = openssl_encrypt($jsonParaCriptografar, 'aes-256-cbc', hash('sha256', $senha, true), 0, $iv);
        $dadosCriptografados = base64_encode($iv . $criptografado);

        $dadosFinais = [
            'esta_criptografado' => true,
            'metodo_criptografia' => 'aes-256-cbc',
            'metadados' => [
                'data' => now()->toDateTimeString(),
                'contagens' => $contagens,
            ],
            'conteudo_criptografado' => $dadosCriptografados,
        ];

        $json = json_encode($dadosFinais, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $nomeArquivo = 'backup_site_' . now()->format('Y-m-d_H-i-s') . '.json';
        
        Storage::disk('local')->put('backups/' . $nomeArquivo, $json);
        $tamanho = number_format(Storage::disk('local')->size('backups/' . $nomeArquivo) / 1024, 2) . ' KB';

        Backup::create([
            'nome_arquivo' => $nomeArquivo,
            'senha' => $senha,
            'contagens' => $contagens,
            'tamanho' => $tamanho,
        ]);

        return $nomeArquivo;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Backup::query()->latest('id'))
            ->heading('Histórico de Backups Seguros')
            ->description('Listagem de todos os backups criados automaticamente ou manualmente.')
            ->columns([
                Tables\Columns\TextColumn::make('criado_em')
                    ->label('Data / ID')
                    ->dateTime('d/m/Y H:i')
                    ->description(fn (Backup $record) => str($record->nome_arquivo)->limit(40))
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('senha')
                    ->label('Chave (DB)')
                    ->badge()
                    ->color('primary')
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Chave de acesso copiada!')
                    ->copyMessageDuration(1500),
                    
                Tables\Columns\TextColumn::make('contagens')
                    ->label('Conteúdo')
                    ->html()
                    ->state(function (Backup $record) {
                        $state = $record->contagens;
                        $prod = $state['produtos'] ?? 0;
                        $serv = $state['servicos'] ?? 0;
                        return "<div class=\"flex flex-wrap gap-2\">" .
                               "<span class=\"inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-xs font-bold text-green-700 bg-green-50 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/10 dark:text-green-400 dark:ring-green-400/30\">🛠️ {$serv} Serv</span>" .
                               "</div>";
                    }),
                    
                Tables\Columns\TextColumn::make('tamanho')
                    ->label('Tamanho')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
            ])
            ->actions([
                Action::make('restaurar')
                    ->label('Restaurar')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Restaurar Backup')
                    ->modalDescription('Deseja restaurar este backup do servidor? Aviso extremo: Esta ação irá limpar e sobrescrever todo o banco de dados atual pelas informações deste momento histórico.')
                    ->modalSubmitActionLabel('Sim, quero Restaurar Agora!')
                    ->action(fn (Backup $record) => $this->restaurarBackup($record->id)),
                    
                Action::make('remover')
                    ->label('Remover')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->outlined()
                    ->requiresConfirmation()
                    ->modalHeading('Excluir Backup')
                    ->modalDescription('Você está prestes a deletar fisicamente este arquivo de armazenamento e sua senha no banco. Essa operação é irreversível.')
                    ->action(fn (Backup $record) => $this->excluirBackup($record->id)),
            ])
            ->emptyStateHeading('Sem Histórico')
            ->emptyStateDescription('Nenhum backup registrado no banco de dados ainda.')
            ->emptyStateIcon('heroicon-o-circle-stack');
    }

    public function importarDados()
    {
        $data = $this->form->getState();
        $file = $data['file'];
        $password = $data['importPassword'];

        try {
            $this->gerarBackupInterno('AUTO_' . now()->timestamp);

            $filePath = Storage::disk('local')->path($file);
            $json = file_get_contents($filePath);
            $dados = json_decode($json, true);
            
            if (!isset($dados['esta_criptografado']) || !$dados['esta_criptografado']) {
                 throw new \Exception('O arquivo subido não é um backup criptografado válido.');
            }

            $jsonDescriptografado = $this->descriptografar($dados['conteudo_criptografado'], $this->importPassword);
            if (!$jsonDescriptografado) {
                throw new \Exception('Senha incorreta para este arquivo.');
            }

            $dadosImportacao = json_decode($jsonDescriptografado, true);
            $this->executarImportacao($dadosImportacao);

            Notification::make()->title('Importação concluída!')->success()->send();
            
            $this->form->fill();
            Storage::disk('local')->delete($file);

        } catch (\Exception $e) {
            Notification::make()->title('Erro na importação')->body($e->getMessage())->danger()->send();
        }
    }

    protected function executarImportacao($dados)
    {
        DB::beginTransaction();
        try {
            DB::statement('PRAGMA foreign_keys = OFF;');

            Configuracao::truncate();
            Servico::truncate();
            Depoimento::truncate();

            foreach ($dados['configuracoes'] ?? [] as $item) Configuracao::create($item);
            foreach ($dados['servicos'] ?? [] as $item) Servico::create($item);
            foreach ($dados['depoimentos'] ?? [] as $item) Depoimento::create($item);

            // Restaurar Logs
            if (isset($dados['logs'])) {
                if (!empty($dados['logs']['acessos'])) {
                    File::put(storage_path('logs/acessos.log'), $dados['logs']['acessos']);
                }
                if (!empty($dados['logs']['sessoes'])) {
                    $dirSessoes = storage_path('logs/sessoes');
                    if (!File::exists($dirSessoes)) File::makeDirectory($dirSessoes, 0755, true);
                    foreach ($dados['logs']['sessoes'] as $nome => $conteudo) {
                        File::put($dirSessoes . '/' . $nome, $conteudo);
                    }
                }
            }

            DB::statement('PRAGMA foreign_keys = ON;');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            DB::statement('PRAGMA foreign_keys = ON;');
            throw $e;
        }
    }

    public function restaurarBackup($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $caminho = 'backups/' . $backup->nome_arquivo;
            
            if (!Storage::disk('local')->exists($caminho)) {
                throw new \Exception('Arquivo não encontrado no disco.');
            }

            $json = Storage::disk('local')->get($caminho);
            $dados = json_decode($json, true);
            
            $jsonDescriptografado = $this->descriptografar($dados['conteudo_criptografado'], $backup->senha);
            $dadosImportacao = json_decode($jsonDescriptografado, true);
            $this->executarImportacao($dadosImportacao);

            Notification::make()->title('Restauração concluída!')->success()->send();
        } catch (\Exception $e) {
            Notification::make()->title('Erro')->body($e->getMessage())->danger()->send();
        }
    }

    public function excluirBackup($id)
    {
        $backup = Backup::findOrFail($id);
        Storage::disk('local')->delete('backups/' . $backup->nome_arquivo);
        $backup->delete();
        Notification::make()->title('Backup excluído')->success()->send();
    }

    protected function descriptografar($stringCriptografada, $senha)
    {
        $dados = base64_decode($stringCriptografada);
        $tamanhoIv = openssl_cipher_iv_length('aes-256-cbc');
        if (strlen($dados) <= $tamanhoIv) return false;
        
        $iv = substr($dados, 0, $tamanhoIv);
        $criptografado = substr($dados, $tamanhoIv);
        
        return openssl_decrypt($criptografado, 'aes-256-cbc', hash('sha256', $senha, true), 0, $iv);
    }

    public function acaoExportarJson(): Action
    {
        return Action::make('exportarJson')
            ->label('Fazer Backup (Exportar Tudo)')
            ->color('primary')
            ->icon('heroicon-o-lock-closed')
            ->form([
                \Filament\Forms\Components\TextInput::make('senha')
                    ->label('Defina uma Senha para o Arquivo')
                    ->password()
                    ->required()
                    ->minLength(4),
            ])
            ->modalSubmitActionLabel('Gerar Backup')
            ->action(function (array $data) {
                $nomeArquivo = $this->gerarBackupInterno($data['senha']);
                Notification::make()->title('Backup gerado e salvo!')->success()->send();
                return Storage::disk('local')->download('backups/' . $nomeArquivo);
            });
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->acaoExportarJson(),
        ];
    }
}
