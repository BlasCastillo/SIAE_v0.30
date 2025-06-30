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
    Schema::create('unidad_curricular', function (Blueprint $table) {
        $table->id(); // 🔥 ID autoincrementable, clave primaria
        $table->string('nombre', 100); // 🔥 Nombre único
        $table->string('descripcion', 100); // Descripción no nula
        $table->string('duracion', 100); // Duración no nula
        $table->string('estatus', 2)->default('1'); // 🔥 Activo por defecto
        $table->unsignedBigInteger('fk_pnf'); // 🔥 Llave foránea PNF
        $table->unsignedBigInteger('fk_trayecto'); // 🔥 Llave foránea Trayecto
        $table->unsignedBigInteger('fk_duracion'); // 🔥 Llave foránea Duración
        $table->timestamps();

        // Definir llaves foráneas
        $table->foreign('fk_pnf')->references('id')->on('pnfs')->onDelete('cascade');
        $table->foreign('fk_trayecto')->references('id')->on('trayectos')->onDelete('cascade');
        $table->foreign('fk_duracion')->references('id')->on('duraciones')->onDelete('cascade');

        // 🔥 Restringir combinaciones únicas
        $table->unique(['nombre', 'fk_pnf', 'fk_trayecto']);
    });
}

public function down(): void
{
    Schema::dropIfExists('unidad_curricular');
}

};
