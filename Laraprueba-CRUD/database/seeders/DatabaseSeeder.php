<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Administrador;
use App\Models\Voluntario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        DB::transaction(function () {
            $adminUser = User::firstOrCreate(
                ['email' => 'admin@sipii.com'],
                [
                    'name' => 'Administrador SIPII',
                    'password' => bcrypt('admin123'),
                    'telefono' => '555-0001',
                    'cedula_identidad' => '1234567-0',
                ]
            );

            // Crear perfil de administrador si no existe
            if (!$adminUser->administrador) {
                Administrador::create([
                    'user_id' => $adminUser->id,
                    'departamento' => 'Sistemas',
                    'nivel_acceso' => 'completo',
                    'activo' => true,
                ]);
            }
        });

        // Crear usuario voluntario
        DB::transaction(function () {
            $volUser = User::firstOrCreate(
                ['email' => 'voluntario@sipii.com'],
                [
                    'name' => 'Voluntario Test',
                    'password' => bcrypt('voluntario123'),
                    'telefono' => '555-0002',
                    'cedula_identidad' => '7654321-0',
                ]
            );

            // Crear perfil de voluntario si no existe
            if (!$volUser->voluntario) {
                Voluntario::create([
                    'user_id' => $volUser->id,
                    'direccion' => 'Calle Test 123',
                    'ciudad' => 'Ciudad Test',
                    'zona' => 'Zona Norte',
                    'notas' => 'Usuario de prueba para voluntarios',
                ]);
            }
        });

        // Seed tipos de biomasa
        $this->call(TipoBiomasaSeeder::class);
    }
}
