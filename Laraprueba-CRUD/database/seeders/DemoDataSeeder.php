<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Administrador;
use App\Models\Voluntario;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $adminUser = User::create([
            'name' => 'Admin Demo',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'telefono' => '70000001',
            'cedula_identidad' => '1234567',
        ]);

        Administrador::create([
            'user_id' => $adminUser->id,
            'departamento' => 'Sistemas',
            'nivel_acceso' => 5,
            'activo' => true,
        ]);

        // Crear segundo administrador
        $adminUser2 = User::create([
            'name' => 'María González',
            'email' => 'maria@demo.com',
            'password' => Hash::make('password'),
            'telefono' => '70000002',
            'cedula_identidad' => '7654321',
        ]);

        Administrador::create([
            'user_id' => $adminUser2->id,
            'departamento' => 'Operaciones',
            'nivel_acceso' => 3,
            'activo' => true,
        ]);

        // Crear voluntarios
        $voluntarioUser1 = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@demo.com',
            'password' => Hash::make('password'),
            'telefono' => '70000003',
            'cedula_identidad' => '1111111',
        ]);

        Voluntario::create([
            'user_id' => $voluntarioUser1->id,
            'direccion' => 'Av. Principal 123',
            'ciudad' => 'San José de Chiquitos',
            'zona' => 'Centro',
            'notas' => 'Disponible fines de semana',
        ]);

        $voluntarioUser2 = User::create([
            'name' => 'Ana López',
            'email' => 'ana@demo.com',
            'password' => Hash::make('password'),
            'telefono' => '70000004',
            'cedula_identidad' => '2222222',
        ]);

        Voluntario::create([
            'user_id' => $voluntarioUser2->id,
            'direccion' => 'Calle 15 de Abril 456',
            'ciudad' => 'San José de Chiquitos',
            'zona' => 'Norte',
            'notas' => 'Experiencia en combate de incendios',
        ]);

        $voluntarioUser3 = User::create([
            'name' => 'Carlos Ramírez',
            'email' => 'carlos@demo.com',
            'password' => Hash::make('password'),
            'telefono' => '70000005',
            'cedula_identidad' => '3333333',
        ]);

        Voluntario::create([
            'user_id' => $voluntarioUser3->id,
            'direccion' => 'Barrio El Prado 789',
            'ciudad' => 'San José de Chiquitos',
            'zona' => 'Sur',
            'notas' => null,
        ]);

        $this->command->info('Datos de demostración creados exitosamente!');
        $this->command->info('Email: admin@demo.com | Password: password');
    }
}
