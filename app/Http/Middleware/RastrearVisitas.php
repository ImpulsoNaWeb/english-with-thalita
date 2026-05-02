<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visita;

class RastrearVisitas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ignorar rotas administrativas, Livewire (usado no painel), assets e requisições JSON
        $ignorar = [
            'admin*',
            'livewire*',
            'filament*',
            'sw.js',
            'manifest.json',
            'favicon.ico',
            'storage*',
        ];

        if (!$request->is($ignorar) && !$request->expectsJson()) {
            // Verificar se esta sessão já foi contabilizada hoje
            $chaveSessao = 'visitado_' . now()->format('Y-m-d');

            if (!session()->has($chaveSessao)) {
                Visita::create([
                    'endereco_ip' => $request->ip(),
                    'navegador' => substr((string) $request->userAgent(), 0, 255),
                    'url' => $request->fullUrl(),
                    'origem' => $request->header('referer'),
                    'visitado_em' => now(),
                ]);

                session()->put($chaveSessao, true);
            }
        }

        return $next($request);
    }
}
