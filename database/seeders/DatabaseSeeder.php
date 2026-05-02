<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::factory()->create([
            'nome' => 'Admin',
            'email' => 'admin@admin.com',
            'senha' => bcrypt('password'),
        ]);

        $this->call([
            ConteudoSeeder::class,
            VisitaSeeder::class,
        ]);
    }
}
