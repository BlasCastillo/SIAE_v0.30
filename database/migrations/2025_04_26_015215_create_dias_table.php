<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 10)->unique();
            $table->unsignedTinyInteger('valor')->unique();
            $table->string('estatus', 2)->default('1');
            $table->timestamps();
        });

        // Insertar los días de la semana
        \App\Models\Dia::insert([ // Asegúrate de que el modelo Dia exista antes de usarlo aquí
            ['nombre' => 'Lunes', 'valor' => 1, 'estatus' => '1'],
            ['nombre' => 'Martes', 'valor' => 2, 'estatus' => '1'],
            ['nombre' => 'Miércoles', 'valor' => 3, 'estatus' => '1'],
            ['nombre' => 'Jueves', 'valor' => 4, 'estatus' => '1'],
            ['nombre' => 'Viernes', 'valor' => 5, 'estatus' => '1'],
            ['nombre' => 'Sábado', 'valor' => 6, 'estatus' => '1'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dias');
    }
};
