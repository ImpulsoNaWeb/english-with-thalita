<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracoes', function (Blueprint $col) {
            $col->id();
            $col->string('chave')->unique();
            $col->json('valor')->nullable();
            $col->string('tipo')->default('text');
            $col->string('grupo')->default('geral');
            $col->timestamp('criado_em')->nullable();
            $col->timestamp('atualizado_em')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};
