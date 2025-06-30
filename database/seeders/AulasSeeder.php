<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AulasSeeder extends Seeder
{
    public function run()
    {
        $aulas = [
            [
                'nombre' => 'Aula E-06',
                'descripcion' => 'Aula teorica',
                'cantidad' => 30,
                'fk_tipo_aulas' => '2',
                'estatus' => 1
            ],
            [
                'nombre' => 'Laboratorio Simon Bolivar',
                'descripcion' => 'laboratorio de computación',
                'cantidad' => 20,
                'fk_tipo_aulas' => '3',
                'estatus' => 1
            ],
            [
                'nombre' => 'Cancha techada',
                'descripcion' => 'Aula de usos múltiples',
                'cantidad' => 25,
                'fk_tipo_aulas' => '4',
                'estatus' => 0
            ]
        ];

        DB::table('aulas')->insert($aulas);
    }
}
