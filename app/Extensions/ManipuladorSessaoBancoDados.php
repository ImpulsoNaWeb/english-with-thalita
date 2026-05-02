<?php

namespace App\Extensions;

use Illuminate\Session\DatabaseSessionHandler;
use Illuminate\Contracts\Auth\Guard;

class ManipuladorSessaoBancoDados extends DatabaseSessionHandler
{
    /**
     * {@inheritdoc}
     */
    public function read($sessionId): string|false
    {
        $session = (object) $this->getQuery()->where('id', $sessionId)->first();

        if ($this->expired($session)) {
            $this->exists = true;
            return '';
        }

        if (isset($session->conteudo)) {
            $this->exists = true;
            return base64_decode($session->conteudo);
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data): bool
    {
        $payload = $this->getDefaultPayload($data);

        if (! $this->exists) {
            $this->read($sessionId);
        }

        if ($this->exists) {
            $this->getQuery()->where('id', $sessionId)->update($payload);
        } else {
            $payload['id'] = $sessionId;
            $this->getQuery()->insert($payload);
        }

        $this->exists = true;

        return true;
    }

    /**
     * Get default payload with translated columns.
     */
    protected function getDefaultPayload($data)
    {
        $payload = [
            'conteudo' => base64_encode($data),
            'ultima_atividade' => time(),
        ];

        if (! $this->container->bound('request')) {
            return $payload;
        }

        $request = $this->container->make('request');

        $payload['usuario_id'] = $this->userId();
        $payload['endereco_ip'] = $request->ip();
        $payload['navegador'] = substr((string) $request->header('User-Agent'), 0, 500);

        return $payload;
    }

    /**
     * Get the user ID for the session.
     */
    protected function userId()
    {
        if ($this->container->bound(Guard::class)) {
            return $this->container->make(Guard::class)->id();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function gc($lifetime): int
    {
        return $this->getQuery()->where('ultima_atividade', '<=', time() - $lifetime)->delete();
    }
    
    /**
     * Check if session is expired.
     */
    protected function expired($session)
    {
        return isset($session->ultima_atividade) &&
            $session->ultima_atividade < time() - $this->minutes * 60;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId): bool
    {
        $this->getQuery()->where('id', $sessionId)->delete();
        $this->exists = false;
        return true;
    }
}
