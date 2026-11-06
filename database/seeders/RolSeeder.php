<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
        $roles = [
            'Administrador',
            'Director de proyectos',
            'Líder de proyecto',
            'Trabajador',
            'Gestor de almacén',
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate([
                'tipo_rol' => $rol,
            ]);
        }
    }
    }
}
