<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\LogService;

class LogAcoesPainel
{
    private static $logGerado = false;
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Apenas logar se o usuário estiver no painel administrativo (ou em uma rota Livewire disparada pelo painel)
        $referencia = $request->header('referer', '');
        $eRotaAdmin = $request->is('admin*') || str_contains($referencia, '/admin');

        if ($eRotaAdmin) {
            // Garantir que existe uma chave de acesso para o usuário logado
            if (auth()->check() && !session()->has('chave_acesso')) {
                $novaChave = str()->random(8);
                session()->put('chave_acesso', $novaChave);
                LogService::logAcesso("SESSÃO REESTABELECIDA | Chave: {$novaChave} | Usuário: " . auth()->user()->email . " | IP: " . $request->ip() . " | Agent: " . $request->userAgent());
            }

            $referencia = $request->header('referer', '');
            $urlFull = $request->is('admin*') ? $request->fullUrl() : $referencia;
            $urlLimpa = parse_url($urlFull, PHP_URL_PATH);
            $urlLimpa = str_replace('/admin', '', $urlLimpa);

            // Registrar ações de modificação
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                $usuario = auth()->user()?->email ?? 'Visitante';
                $metodo = $request->method();
                $chave = session()->get('chave_acesso', 'SEM_CHAVE');
                $updates = [];
                
                // Capturar e filtrar dados enviados
                $dadosOriginais = $request->except(['password', 'senha', 'password_confirmation', 'current_password', '_token', '_method']);
                $eLivewire = $request->hasHeader('X-Livewire');
                $temMudancaReal = false;
                
                // Se for Livewire, filtrar apenas ações reais (chamadas de métodos e mudanças de dados)
                if ($eLivewire) {
                    $components = $request->input('components', []);
                    $temChamadaUsuario = false;
                    $ignorarCompletamente = false;

                    // Lista de métodos técnicos do Filament/Livewire que NÃO são ações diretas de clique do usuário
                    $metodosTecnicos = [
                        'callSchemaComponentMethod', 
                        'getUploadedFiles', 
                        'updateChartData', 
                        'poll',
                        'syncInput'
                    ];

                    $alteracoesCompletas = [];

                    foreach ($components as $c) {
                        $snapshot = isset($c['snapshot']) ? json_decode($c['snapshot'], true) : [];
                        $dadosAntigos = $snapshot['memo']['data'] ?? [];
                        
                        $calls = $c['calls'] ?? [];
                        foreach ($calls as $call) {
                            $metodoCall = $call['method'] ?? '';
                            
                            // Se a requisição contiver qualquer um destes, ignoramos o log inteiro dessa requisição
                            if (in_array($metodoCall, $metodosTecnicos)) {
                                $ignorarCompletamente = true;
                                break 2;
                            }
                            
                            // Métodos que representam ações reais de "clique" ou "comando"
                            $metodosAcao = ['salvar', 'save', 'store', 'create', 'delete', 'destroy', 'reorder', 'callAction', 'mountAction', 'mountTableAction', 'callTableAction', 'updateTableColumnState'];
                            if (in_array($metodoCall, $metodosAcao)) {
                                $temChamadaUsuario = true;
                                
                                // Detecção específica de Criação para capturar dados iniciais
                                if (in_array($metodoCall, ['salvar', 'save', 'store', 'create']) && str_contains($urlFull, '/create')) {
                                    foreach ($dadosAntigos as $campo => $valor) {
                                        if (!isset($alteracoesCompletas[$campo]) && !is_array($valor) && !str_starts_with($campo, '__')) {
                                            $alteracoesCompletas[$campo] = [
                                                'antigo' => '---',
                                                'novo' => $valor
                                            ];
                                            $temMudancaReal = true;
                                        }
                                    }
                                }

                                // Detecção específica de Toggle para Ativou/Desativou
                                if ($metodoCall === 'updateTableColumnState') {
                                    $params = $call['params'] ?? [];
                                    $idRegistroToggle = $params[1] ?? null; // O segundo parâmetro é o ID do registro
                                    $novoEstado = $params[2] ?? null; // O terceiro parâmetro é o novo estado (true/false)
                                    
                                    if ($novoEstado === true || $novoEstado === '1' || $novoEstado === 1) {
                                        $acaoAmigavelToggle = 'Ativou';
                                    } elseif ($novoEstado === false || $novoEstado === '0' || $novoEstado === 0) {
                                        $acaoAmigavelToggle = 'Desativou';
                                    }
                                    
                                    if ($idRegistroToggle) {
                                        $identificadorRegistroManual = "ID {$idRegistroToggle}";
                                    }
                                }

                                // Detecção específica de Exclusão (Actions do Filament)
                                if (in_array($metodoCall, ['callTableAction', 'mountTableAction', 'callAction', 'mountAction'])) {
                                    $nomeAcao = $call['params'][0] ?? '';
                                    if (is_string($nomeAcao) && in_array(strtolower($nomeAcao), ['delete', 'destroy', 'excluir'])) {
                                        $acaoAmigavelToggle = 'Excluiu';
                                        
                                        if (isset($call['params'][1]) && is_numeric($call['params'][1])) {
                                            $identificadorRegistroManual = "ID {$call['params'][1]}";
                                        }
                                    }
                                } elseif (in_array(strtolower($metodoCall), ['delete', 'destroy', 'excluir'])) {
                                    $acaoAmigavelToggle = 'Excluiu';
                                }
                            }
                        }

                        if (isset($c['updates']) && !empty($c['updates'])) {
                            foreach ($c['updates'] as $campo => $valorNovo) {
                                // Ignorar campos que começam com data. (Filament costuma agrupar)
                                $campoLimpo = str_replace('data.', '', $campo);
                                $valorAntigo = $dadosAntigos[$campoLimpo] ?? $dadosAntigos[$campo] ?? null;
                                
                                // Só registrar se o valor mudou
                                if ($valorAntigo !== $valorNovo) {
                                    $alteracoesCompletas[$campo] = [
                                        'antigo' => $valorAntigo,
                                        'novo' => $valorNovo
                                    ];
                                    $temMudancaReal = true;
                                }
                            }
                        }
                        
                        if (isset($c['calls'])) $updates[] = $c['calls'];
                    }

                    // Critério rigoroso: Só loga se NÃO for técnico E se for uma chamada de ação do usuário
                    if ($ignorarCompletamente || !$temChamadaUsuario) {
                        return $response;
                    }

                    // Se for uma chamada de 'salvar' mas não mudou absolutamente nada no formulário, ignoramos
                    if (!$temMudancaReal && str_contains(json_encode($updates), '"method":"salvar"')) {
                        return $response;
                    }

                    $dados = !empty($alteracoesCompletas) ? $alteracoesCompletas : (!empty($updates) ? $updates : ['action' => 'user_interaction']);
                } else {
                    $dados = $dadosOriginais;
                    $temMudancaReal = !empty($dados);
                }

                $jsonDados = json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
                
                // Limpar a URL para mostrar apenas o caminho após o /admin
                $urlFull = $request->is('admin*') ? $request->fullUrl() : $referencia;
                $urlLimpa = parse_url($urlFull, PHP_URL_PATH);
                $urlLimpa = str_replace('/admin', '', $urlLimpa);
                if (empty($urlLimpa)) $urlLimpa = '/';

                // Mapear ação amigável
                $acaoAmigavel = $acaoAmigavelToggle ?? 'Alterou';
                $jsonBruto = json_encode($updates ?? []);
                
                // Tentar identificar o registro (nome, titulo, etc)
                $identificadorRegistro = $identificadorRegistroManual ?? '';
                $camposIdentificadores = ['nome', 'titulo', 'name', 'title', 'email', 'label', 'razao_social'];
                
                foreach ($updates as $update) {
                    foreach ($camposIdentificadores as $campo) {
                        if (isset($update[$campo]) && is_string($update[$campo])) {
                            $identificadorRegistro = $update[$campo];
                            break 2;
                        }
                        if (isset($update['data'][$campo]) && is_string($update['data'][$campo])) {
                            $identificadorRegistro = $update['data'][$campo];
                            break 2;
                        }
                    }
                }

                // Outras ações se não for toggle detectado no loop de calls
                if ($acaoAmigavel === 'Alterou') {
                    if ($metodo === 'DELETE') {
                        $acaoAmigavel = 'Excluiu';
                    } elseif (str_contains($urlLimpa, '/create')) {
                        $acaoAmigavel = 'Criou';
                    } elseif (str_contains($jsonBruto, 'mountTableAction')) {
                        $acaoAmigavel = 'Executou Ação';
                    }
                }

                // Personalizar a frase com o identificador se encontrado
                $fraseAcao = $acaoAmigavel;
                if (!empty($identificadorRegistro)) {
                    $acaoVerbo = match($acaoAmigavel) {
                        'Alterou' => 'alterou o registro',
                        'Criou' => 'criou o registro',
                        'Excluiu' => 'excluiu o registro',
                        'Ativou' => 'ativou o registro',
                        'Desativou' => 'desativou o registro',
                        default => $acaoAmigavel
                    };
                    $fraseAcao = "{$acaoVerbo} [{$identificadorRegistro}]";
                }

                $chave = session()->get('chave_acesso', 'SEM_CHAVE');
                
                // Evitar logar a própria tela de logs e garantir apenas um por requisição
                if (!str_contains($urlFull, '/admin/logs') && !self::$logGerado) {
                    LogService::logAcao("CHAVE: {$chave} | Usuário: {$usuario} | Ação: {$fraseAcao} | Origem: {$urlLimpa} | Dados: {$jsonDados}");
                    self::$logGerado = true;
                }
            }
        }

        return $response;
    }
}
