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
        Schema::table('unidad_curricular', function (Blueprint $table) {
            // Renombrar la columna existente
            $table->renameColumn('duracion', 'horas_academicas');
        });

        Schema::table('unidad_curricular', function (Blueprint $table) {
            // Cambiar el tipo de dato de la columna renombrada
            $table->integer('horas_academicas')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unidad_curricular', function (Blueprint $table) {
            // Revertir el cambio de tipo de dato
            $table->string('duracion', 100)->change();
        });

        Schema::table('unidad_curricular', function (Blueprint $table) {
            // Revertir el nombre de la columna
            $table->renameColumn('horas_academicas', 'duracion');
        });
    }
};
