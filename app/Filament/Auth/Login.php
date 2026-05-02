<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

/**
 * Classe de login customizada para o Filament.
 */
class Login extends BaseLogin
{
    /**
     * Inicializa a página de login.
     * Se o ambiente for local, preenche automaticamente as credenciais.
     */
    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal()) {
            $this->form->fill([
                'email' => 'admin@admin.com',
                'password' => 'password',
                'remember' => true,
            ]);
        }
    }

    /**
     * Sobrescreve a autenticação para registrar no log.
     */
    public function authenticate(): ?\Filament\Auth\Http\Responses\Contracts\LoginResponse
    {
        $response = parent::authenticate();
        
        if ($response) {
            $usuario = auth()->user();
            $chaveAcesso = str()->random(8);
            session()->put('chave_acesso', $chaveAcesso);

            $metadados = [
                'ip' => request()->ip(),
                'navegador' => request()->userAgent(),
                'chave' => $chaveAcesso,
                'email' => $usuario->email,
                'hora' => now()->toDateTimeString(),
            ];

            \App\Services\LogService::logAcesso("LOGIN EFETUADO | Chave: {$chaveAcesso} | Usuário: {$usuario->email} | IP: {$metadados['ip']} | Agent: {$metadados['navegador']}");
        }

        return $response;
    }
}
