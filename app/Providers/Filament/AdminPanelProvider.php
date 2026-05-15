<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Auth\Login::class)
            ->profile(\App\Filament\Pages\Auth\EditarPerfil::class)
            ->brandName('Painel English with Thalita')
            ->colors([
                'primary' => \App\Models\Configuracao::get('cor_primaria', '#1d8985'),
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::BODY_END,
                fn (): string => view('filament.components.bottom-nav')->render(),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::CONTENT_AFTER,
                fn (): string => view('filament.tables.footer.reorder-save-button')->render(),
                scopes: [\App\Filament\Resources\DepoimentoResource::class, \App\Filament\Resources\ServicoResource::class],
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_START,
                fn (): string => <<<'HTML'
                    <meta name="mobile-web-app-capable" content="yes">
                    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
                    <link rel="manifest" href="/manifest.json">
                    <style>
                        .fi-sidebar-item-label, 
                        .fi-sidebar-item-button span,
                        .fi-header-heading {
                            color: #000 !important;
                            font-weight: 600 !important;
                        }
                        .fi-sidebar-item-icon {
                            color: #1d8985 !important;
                        }
                        /* Estilização dos títulos das seções (Site, Catálogo, Sistema) */
                        .fi-sidebar-group-btn {
                            background-color: #1d8985 !important;
                            border-radius: 12px !important;
                            padding: 10px 16px !important;
                            margin-bottom: 8px !important;
                            margin-top: 12px !important;
                            transition: all 0.2s ease !important;
                        }
                        .fi-sidebar-group-label,
                        .fi-sidebar-group-btn svg {
                            color: #ffffff !important;
                            font-weight: 800 !important;
                            text-transform: uppercase !important;
                            letter-spacing: 0.05em !important;
                            font-size: 0.75rem !important;
                        }
                        .fi-sidebar-group-btn:hover {
                            filter: brightness(1.1) !important;
                        }
                        /* Ocultação total do checkmark e indicadores de reordenação */
                        .fi-ta-reorder-indicator,
                        .fi-ta-reorder-trigger,
                        [wire\:click*="reorderRecords"],
                        .fi-ta-actions button:has(svg) {
                            display: none !important;
                            visibility: hidden !important;
                        }

                        /* Estilização de Botões Primários (Emerald) */
                        .fi-btn-color-primary {
                            background-color: #10b981 !important; /* emerald-500 */
                            border-radius: 0.75rem !important;
                            font-weight: 700 !important;
                            transition: all 0.2s ease !important;
                        }
                        .fi-btn-color-primary:hover {
                            background-color: #059669 !important; /* emerald-600 */
                            transform: translateY(-1px);
                        }
                        .fi-btn-color-primary:active {
                            transform: scale(0.95);
                        }
                    </style>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const hideElements = () => {
                                document.querySelectorAll('[wire\\:click*="reorderRecords"]').forEach(el => el.remove());
                                document.querySelectorAll(".fi-ta-reorder-indicator").forEach(el => el.remove());
                            };
                            hideElements();
                            new MutationObserver(hideElements).observe(document.body, { childList: true, subtree: true });
                        });
                    </script>
HTML
,
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets removidos para exibir apenas os customizados
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                'Site',
                'Catálogo',
                'Sistema',
            ]);
    }
}
