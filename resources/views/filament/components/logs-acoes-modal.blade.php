<div 
    x-init="setTimeout(() => $el.scrollTop = 0, 100)"
    style="position: relative; max-height: 70vh !important; overflow-y: auto !important; padding-right: 10px !important; padding-bottom: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important; scroll-behavior: auto !important;"
>
    <!-- Linha Vertical -->
    <div style="position: absolute; left: 15px; top: 10px; bottom: 20px; width: 2px !important; background-color: #f3f4f6 !important;"></div>

    @if(count($acoes) > 0)
        @foreach($acoes as $acao)
            @php
                $metodoLower = strtolower($acao['metodo']);
                $corFundo = '#9ca3af';
                $corTexto = '#4b5563';
                
                // Prioridade para Desativou (pois contém a palavra 'ativou')
                if (str_contains($metodoLower, 'desativou') || str_contains($metodoLower, 'excluiu')) {
                    $corFundo = '#ef4444';
                    $corTexto = '#dc2626';
                } elseif (str_contains($metodoLower, 'criou') || str_contains($metodoLower, 'ativou')) {
                    $corFundo = '#22c55e';
                    $corTexto = '#16a34a';
                } elseif (str_contains($metodoLower, 'alterou')) {
                    $corFundo = '#3b82f6';
                    $corTexto = '#2563eb';
                } elseif (str_contains($metodoLower, 'executou')) {
                    $corFundo = '#f59e0b';
                    $corTexto = '#d97706';
                }
            @endphp

            <div style="position: relative; padding-left: 45px; margin-bottom: 30px;">
                <!-- Marcador -->
                <div style="position: absolute; left: 8px; top: 6px; width: 14px !important; height: 14px !important; border-radius: 50% !important; border: 3px solid white !important; z-index: 10 !important; box-shadow: 0 1px 2px rgba(0,0,0,0.1) !important; background-color: {{ $corFundo }} !important;"></div>

                <!-- Cabeçalho da Ação (Formato solicitado) -->
                <div style="margin-bottom: 12px; font-size: 13px; color: #4b5563; line-height: 1.5;">
                    O usuário <strong style="color: #111827;">{{ $acao['usuario'] }}</strong> 
                    <span style="font-weight: 800; color: {{ $corTexto }};">{{ strtolower($acao['metodo']) }}</span> 
                    às <span style="color: #9ca3af;">{{ $acao['horario'] }}</span>
                </div>

                <!-- Card de Conteúdo -->
                <div style="background: #ffffff !important; border: 1px solid #e5e7eb !important; border-radius: 12px !important; padding: 16px !important; box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;">
                    <div style="background: #f9fafb !important; padding: 10px 12px !important; border-radius: 8px !important; border: 1px solid #f3f4f6 !important; margin-bottom: 12px !important; font-family: monospace !important; font-size: 11px !important; color: #6b7280 !important; word-break: break-all !important;">
                        <span style="opacity: 0.5; font-weight: bold;">URL:</span> {{ $acao['url'] }}
                    </div>

                    @if(!empty($acao['dados_amigaveis']))
                        <div x-data="{ open: false }">
                            <button type="button" x-on:click="open = !open" style="background: #f3f4f6 !important; border: none !important; padding: 6px 12px !important; border-radius: 6px !important; color: #3b82f6 !important; font-size: 10px !important; font-weight: 800 !important; cursor: pointer !important; display: inline-flex !important; align-items: center !important; gap: 6px !important; text-transform: uppercase !important;">
                                <span>Ver detalhes das alterações</span>
                                <span x-text="open ? '▲' : '▼'" style="font-size: 8px !important; line-height: 1 !important;"></span>
                            </button>

                            <div x-show="open" x-collapse style="margin-top: 12px !important; border: 1px solid #f3f4f6 !important; border-radius: 8px !important; overflow: hidden !important; background: #ffffff !important;">
                                <table style="width: 100% !important; border-collapse: collapse !important; font-size: 11px !important;">
                                    <thead>
                                        <tr style="background: #f9fafb !important; text-align: left !important; border-bottom: 1px solid #f3f4f6 !important;">
                                            <th style="padding: 10px 12px !important; color: #6b7280 !important; text-transform: uppercase !important; font-size: 9px !important; font-weight: 800 !important; width: 25% !important;">Campo</th>
                                            <th style="padding: 10px 12px !important; color: #b91c1c !important; text-transform: uppercase !important; font-size: 9px !important; font-weight: 800 !important; width: 37% !important;">Valor Anterior</th>
                                            <th style="padding: 10px 12px !important; color: #1d4ed8 !important; text-transform: uppercase !important; font-size: 9px !important; font-weight: 800 !important;">Novo Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background: white !important;">
                                        @foreach($acao['dados_amigaveis'] as $campo => $valor)
                                            <tr style="border-bottom: 1px solid #f9fafb !important;">
                                                <td style="padding: 10px 12px !important; font-weight: bold !important; color: #111827 !important; background: #fbfcfe !important; border-right: 1px solid #f3f4f6 !important;">{{ $campo }}</td>
                                                <td style="padding: 10px 12px !important; color: #ef4444 !important; background: #fef2f2 !important; border-right: 1px solid #f3f4f6 !important; word-break: break-all !important; font-style: italic;">{{ $valor['antigo'] ?? '---' }}</td>
                                                <td style="padding: 10px 12px !important; color: #2563eb !important; background: #eff6ff !important; word-break: break-all !important; font-weight: 500;">{{ $valor['novo'] ?? $valor }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div style="padding: 80px 20px !important; text-align: center !important;">
            <p style="color: #9ca3af !important; font-size: 13px !important; font-style: italic !important;">Nenhuma ação registrada nesta sessão.</p>
        </div>
    @endif
</div>





