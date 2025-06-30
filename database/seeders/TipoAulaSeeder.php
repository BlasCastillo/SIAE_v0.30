<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_aulas')->insert([
            [
                'nombre' => 'Aula Teórica',
                'descripcion' => 'Aula para clases teóricas',
                'estatus' => 1,
            ],
            [
                'nombre' => 'Laboratorio de Informática',
                'descripcion' => 'Aula equipada con computadoras',
                'estatus' => 1,
            ],
            [
                'nombre' => 'Aula Multimedia',
                'descripcion' => 'Aula con equipos multimedia',
                'estatus' => 1,
            ],
        ]);
    }
}
