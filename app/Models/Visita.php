<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';
    protected $table = 'visitas';

    protected $fillable = ['endereco_ip', 'navegador', 'url', 'origem', 'visitado_em'];
    
    public $timestamps = false;
}
