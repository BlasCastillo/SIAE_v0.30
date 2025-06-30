<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->string('nombre', 3)->unique(); // Nombre numérico de 3 dígitos, único
            $table->string('codigo', 20)->unique(); // Código generado automáticamente
            $table->unsignedBigInteger('cantidad_alumnos'); // Número de alumnos inscritos
            $table->unsignedBigInteger('fk_pnf'); // Clave foránea hacia pnfs
            $table->unsignedBigInteger('fk_trayecto'); // Clave foránea hacia trayectos
            $table->unsignedBigInteger('fk_unidad_curricular'); // Clave foránea hacia unidad_curricular
            $table->timestamps(); // created_at y updated_at

            // Relación de claves foráneas
            $table->foreign('fk_pnf')->references('id')->on('pnfs')->onDelete('cascade');
            $table->foreign('fk_trayecto')->references('id')->on('trayectos')->onDelete('cascade');
            $table->foreign('fk_unidad_curricular')->references('id')->on('unidad_curricular')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secciones');
    }
}
