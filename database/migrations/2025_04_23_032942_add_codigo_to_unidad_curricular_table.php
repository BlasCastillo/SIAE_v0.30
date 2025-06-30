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
            // 🔥 Añadir la columna `codigo` como string de 3 caracteres, única y no nula
            $table->string('codigo', 5)->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('unidad_curricular', function (Blueprint $table) {
            // 🔥 Eliminar la columna `codigo` en caso de rollback
            $table->dropColumn('codigo');
        });
    }

};
