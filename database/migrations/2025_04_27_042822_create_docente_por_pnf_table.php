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
        Schema::create('docente_por_pnf', function (Blueprint $table) {
            $table->id(); // ID autoincrementable
            $table->unsignedBigInteger('user_id'); // FK a users
            $table->unsignedBigInteger('pnf_id'); // FK a pnfs
            $table->timestamps();

            // Restricciones de llave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pnf_id')->references('id')->on('pnfs')->onDelete('cascade');

            // Índice único para evitar duplicados
            $table->unique(['user_id', 'pnf_id'], 'unique_user_pnf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_por_pnf');
    }
};
