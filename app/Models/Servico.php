<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
    use SoftDeletes;
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $table = 'servicos';

    protected $fillable = ['categoria_id', 'nome', 'descricao', 'icone', 'badge', 'badge_cor', 'imagem', 'seo_title', 'seo_description', 'seo_image', 'ordem', 'esta_ativo'];
}
