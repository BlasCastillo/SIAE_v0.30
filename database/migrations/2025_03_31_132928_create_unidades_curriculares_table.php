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
        Schema::create('unidades_curriculares', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion', 100);
            $table->string('cod_unidad_curricular', 100);
            $table->boolean('estatus');
            $table->integer('h_academicas');
            $table->integer('fk_pnf');
            $table->integer('fk_trayecto');
            $table->integer('fk_tipo_unidad_curricular');
            $table->timestamps();

            /* llaves foraneas */
            $table->foreign('fk_pnf')->references('id')->on('pnfs')->onDelete('cascade');
            $table->foreign('fk_trayecto')->references('id')->on('trayectos')->onDelete('cascade');
            $table->foreign('fk_tipo_unidad_curricular')->references('id')->on('tipo_unidades_curriculares')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_curriculares');
    }
};
