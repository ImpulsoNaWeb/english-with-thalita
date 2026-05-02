<?php

namespace App\Models;

use App\Casts\ConfiguracaoValorCast;
use App\Observers\ConfiguracaoObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[ObservedBy([ConfiguracaoObserver::class])]
class Configuracao extends Model
{
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $table = 'configuracoes';

    protected $fillable = ['chave', 'valor', 'grupo', 'tipo'];

    protected function casts(): array
    {
        return [
            'valor' => ConfiguracaoValorCast::class,
        ];
    }

    public static function get(string $chave, mixed $padrao = null): mixed
    {
        return Cache::rememberForever("configuracao_{$chave}", function () use ($chave, $padrao) {
            return static::where('chave', $chave)->first()?->valor ?? $padrao;
        });
    }
}
