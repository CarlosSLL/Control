<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolAdministrador = Rol::where('tipo_rol', 'Administrador')->first();

        User::updateOrCreate(
            [
                'email' => 'admin@almacen.com'
            ],
            [
                'nombres' => 'admin',
                'apellidos' => 'Administrador',
                'password' => Hash::make('admin123'),
                'rol_id' => $rolAdministrador->id,
                'foto_path' => null,
            ]
        );
    }
}
