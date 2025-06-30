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
    Schema::create('trayectos', function (Blueprint $table) {
        $table->id(); // 🔥 ID autoincrementable
        $table->string('codigo', 2)->unique(); // 🔥 Código único de dos dígitos
        $table->string('nombre', 100)->unique(); // 🔥 Nombre único
        $table->string('descripcion', 100);
        $table->string('estatus', 2)->default('1'); // 🔥 Activo por defecto
        $table->unsignedBigInteger('fk_pnf'); // 🔥 Llave foránea
        $table->timestamps();

        // 🔥 Definir la llave foránea
        $table->foreign('fk_pnf')->references('id')->on('pnfs')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trayectos');
    }
};
