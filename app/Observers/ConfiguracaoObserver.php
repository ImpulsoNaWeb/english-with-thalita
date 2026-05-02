<?php

namespace App\Observers;

use App\Models\Configuracao;
use Illuminate\Support\Facades\Cache;

class ConfiguracaoObserver
{
    public function saved(Configuracao $configuracao): void
    {
        Cache::forget("configuracao_{$configuracao->chave}");
    }

    public function deleted(Configuracao $configuracao): void
    {
        Cache::forget("configuracao_{$configuracao->chave}");
    }
}
