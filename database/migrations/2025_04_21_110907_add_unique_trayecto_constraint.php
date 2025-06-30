<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('trayectos', function (Blueprint $table) {
        // 🔥 Solo agregar la restricción si no existe
        $table->unique(['codigo', 'nombre', 'fk_pnf']);
    });
}

public function down(): void
{
    Schema::table('trayectos', function (Blueprint $table) {
        // 🔥 Verifica si la restricción existe antes de eliminarla
        DB::statement("ALTER TABLE trayectos DROP CONSTRAINT IF EXISTS trayectos_codigo_nombre_fk_pnf_unique");
    });
}


};
