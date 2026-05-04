<?php

namespace App\Models;

use App\Casts\ConfiguracaoValorCast;
use App\Observers\ConfiguracaoObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

#[ObservedBy([ConfiguracaoObserver::class])]
class Configuracao extends Model
{
    use HasTranslations;

    public $translatable = ['valor'];
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $table = 'configuracoes';

    protected $fillable = ['chave', 'valor', 'grupo', 'tipo'];

    protected function casts(): array
    {
        return [];
    }

    public static function get(string $chave, mixed $padrao = null): mixed
    {
        try {
            // Se estiver rodando no console (como deploy/artisan) e a tabela não existir,
            // evita quebrar o boot antes de rodar as migrations.
            if (app()->runningInConsole() && !\Illuminate\Support\Facades\Schema::hasTable('configuracoes')) {
                return $padrao;
            }

            $locale = app()->getLocale();
            return Cache::rememberForever("configuracao_{$chave}_{$locale}", function () use ($chave, $padrao) {
                return static::where('chave', $chave)->first()?->valor ?? $padrao;
            });
        } catch (\Throwable $e) {
            return $padrao;
        }
    }
}
