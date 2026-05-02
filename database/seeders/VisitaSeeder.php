<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visita;

class VisitaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            Visita::create([
                'endereco_ip' => '127.0.0.1',
                'navegador' => 'Mozilla/5.0',
                'url' => 'http://localhost/',
                'visitado_em' => now()->subDays(rand(0, 7)),
            ]);
        }
    }
}
