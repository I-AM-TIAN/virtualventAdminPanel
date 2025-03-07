<?php

namespace Database\Seeders;

use App\Models\tipoUsuario;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        tipoUsuario::create([
            'codigo' => 1,
            'nombre' => 'Administrador',
        ]);

        tipoUsuario::create([
            'codigo' => 2,
            'nombre' => 'Corporativo',
        ]);

        tipoUsuario::create([
            'codigo' => 3,
            'nombre' => 'Cliente',
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'administrador@',
            'tipousuario_id' => 1,
        ]);

        
    }
}
