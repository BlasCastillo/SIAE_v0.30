<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrayectosSeeder extends Seeder
{
    public function run()
    {
        $trayectos = [
            [
                'nombre' => 'Primer Año',
                'descripcion' => 'Trayecto 1 de la carrera',
                'estatus' => 1
            ],
            [
                'nombre' => 'Segundo Año',
                'descripcion' => 'Trayecto 2 de la carrera',
                'estatus' => 1
            ],
            [
                'nombre' => 'Tercer Año',
                'descripcion' => 'Trayecto 3 de la carrera',
                'estatus' => 1
            ]
        ];

        DB::table('trayectos')->insert($trayectos);
    }
}
