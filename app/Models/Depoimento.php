<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depoimento extends Model
{
    use SoftDeletes;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $table = 'depoimentos';

    protected $fillable = ['nome_autor', 'cargo_autor', 'avatar_autor', 'conteudo', 'nota', 'seo_title', 'seo_description', 'seo_image', 'esta_ativo'];
}
