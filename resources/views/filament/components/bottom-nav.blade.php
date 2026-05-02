@php
    $abas = [
        ['url' => '/admin', 'icone' => 'heroicon-o-home', 'atleta' => 'heroicon-s-home', 'label' => 'Início', 'ativo' => request()->is('admin')],
        ['url' => '/admin/gerenciar-dados', 'icone' => 'heroicon-o-circle-stack', 'atleta' => 'heroicon-s-circle-stack', 'label' => 'Dados', 'ativo' => request()->is('admin/gerenciar-dados*')],
        ['url' => '/admin/configuracoes', 'icone' => 'heroicon-o-cog-6-tooth', 'atleta' => 'heroicon-s-cog-6-tooth', 'label' => 'Ajustes', 'ativo' => request()->is('admin/configuracoes*')],
    ];
@endphp

<div id="pwa-bottom-nav" class="md:hidden" style="position: fixed !important; bottom: 0 !important; left: 0 !important; width: 100% !important; background: rgba(255, 255, 255, 0.8) !important; backdrop-filter: blur(10px) !important; -webkit-backdrop-filter: blur(10px) !important; border-top: 1px solid rgba(226, 232, 240, 0.5) !important; box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.08) !important; z-index: 9999 !important; padding-bottom: env(safe-area-inset-bottom) !important;">
    <nav style="display: grid !important; grid-template-columns: repeat(3, 1fr) !important; height: 64px !important; width: 100% !important; margin: 0 !important; padding: 0 !important;">
        @foreach($abas as $aba)
            <a href="{{ $aba['url'] }}" 
               style="position: relative !important; display: flex !important; flex-direction: column !important; items-center: center !important; justify-content: center !important; gap: 4px !important; height: 100% !important; text-decoration: none !important; transition: all 0.3s ease !important; color: {{ $aba['ativo'] ? '#1d8985' : '#94a3b8' }} !important; text-align: center !important; font-family: sans-serif !important;">
                
                @if($aba['ativo'])
                    <div style="position: absolute !important; top: 0 !important; left: 50% !important; transform: translateX(-50%) !important; width: 40px !important; height: 4px !important; background: #1d8985 !important; border-radius: 0 0 10px 10px !important;"></div>
                @endif

                <div style="display: flex !important; align-items: center !important; justify-content: center !important; min-height: 24px !important;">
                    @if($aba['ativo'])
                        <x-dynamic-component :component="$aba['atleta']" class="w-6 h-6" style="width: 24px !important; height: 24px !important;" />
                    @else
                        <x-dynamic-component :component="$aba['icone']" class="w-6 h-6" style="width: 24px !important; height: 24px !important;" />
                    @endif
                </div>
                
                <span style="font-size: 10px !important; font-weight: 700 !important; text-transform: uppercase !important; line-height: 1 !important; letter-spacing: -0.01em !important;">{{ $aba['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>

<style>
    /* Ajuste para o conteúdo não ficar por baixo da barra */
    body { 
        padding-bottom: calc(5rem + env(safe-area-inset-bottom)) !important; 
        background-color: #f8fafc !important;
    }
    
    @media (min-width: 768px) {
        body { padding-bottom: 0 !important; }
        #pwa-bottom-nav { display: none !important; }
    }
</style>
