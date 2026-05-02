<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

/**
 * Serviço responsável pelo gerenciamento de Logs customizados do painel.
 */
class LogService
{
    /**
     * Registra um log de acesso (login).
     */
    public static function logAcesso(string $mensagem): void
    {
        $diretorio = storage_path('logs');
        if (!File::exists($diretorio)) {
            File::makeDirectory($diretorio, 0755, true);
        }

        $sessaoId = session()->getId();
        $caminho = $diretorio . '/acessos.log';
        $conteudo = "[" . now()->format('d/m/Y H:i:s') . "] [Sessão: {$sessaoId}] " . $mensagem . PHP_EOL;
        File::append($caminho, $conteudo);
    }

    /**
     * Registra um log de ação no painel, separado por sessão.
     */
    public static function logAcao(string $mensagem): void
    {
        $sessaoId = session()->getId();
        $diretorio = storage_path('logs/sessoes');
        
        if (!File::exists($diretorio)) {
            File::makeDirectory($diretorio, 0755, true);
        }

        $caminho = $diretorio . "/sessao_{$sessaoId}.log";
        $conteudo = "[" . now()->format('d/m/Y H:i:s') . "] " . $mensagem . PHP_EOL;
        File::append($caminho, $conteudo);
    }
}
