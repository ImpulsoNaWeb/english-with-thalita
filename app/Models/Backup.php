<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $fillable = ['nome_arquivo', 'senha', 'contagens', 'tamanho'];

    protected $casts = [
        'contagens' => 'array',
    ];
}
