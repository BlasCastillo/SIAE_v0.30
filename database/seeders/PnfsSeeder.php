<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PnfsSeeder extends Seeder
{
    public function run()
    {
        $pnfs = [
            [
                'nombre' => 'Informática',
                'descripcion' => 'Ingeniería en Informática',
                'estatus' => 1
            ],
            [
                'nombre' => 'Administración',
                'descripcion' => 'Licenciatura en Administración',
                'estatus' => 1
            ],
            [
                'nombre' => 'Enfermería',
                'descripcion' => 'Licenciatura en Enfermería',
                'estatus' => 1
            ]
        ];

        DB::table('pnfs')->insert($pnfs);
    }
}
