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
    Schema::create('duraciones', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100)->unique();
        $table->string('descripcion', 100);
        $table->string('estatus', 2)->default('1'); // Activo por defecto
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('duraciones');
}

};
