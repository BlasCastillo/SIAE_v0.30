<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstatusToSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secciones', function (Blueprint $table) {
            $table->string('estatus', 1)->default('1'); // Activo por defecto: '1' (0 = inactivo, 1 = activo)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('secciones', function (Blueprint $table) {
            $table->dropColumn('estatus');
        });
    }
}
