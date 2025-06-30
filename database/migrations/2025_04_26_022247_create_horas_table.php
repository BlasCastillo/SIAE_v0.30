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
        Schema::create('horas', function (Blueprint $table) {
            $table->id();
            $table->time('hora_inicio')->unique();
            $table->time('hora_fin')->unique();
            $table->string('estatus', 2)->default('1');
            $table->timestamps();
        });

        // Insertar las horas
        \App\Models\Hora::insert([
            ['hora_inicio' => '07:30:00', 'hora_fin' => '08:15:00', 'estatus' => '1'],
            ['hora_inicio' => '08:15:00', 'hora_fin' => '09:00:00', 'estatus' => '1'],
            ['hora_inicio' => '09:00:00', 'hora_fin' => '09:45:00', 'estatus' => '1'],
            ['hora_inicio' => '09:45:00', 'hora_fin' => '10:30:00', 'estatus' => '1'],
            ['hora_inicio' => '10:30:00', 'hora_fin' => '11:15:00', 'estatus' => '1'],
            ['hora_inicio' => '11:15:00', 'hora_fin' => '12:00:00', 'estatus' => '1'],
            ['hora_inicio' => '13:00:00', 'hora_fin' => '13:45:00', 'estatus' => '1'],
            ['hora_inicio' => '13:45:00', 'hora_fin' => '14:30:00', 'estatus' => '1'],
            ['hora_inicio' => '14:30:00', 'hora_fin' => '15:15:00', 'estatus' => '1'],
            ['hora_inicio' => '15:15:00', 'hora_fin' => '16:00:00', 'estatus' => '1'],
            ['hora_inicio' => '16:00:00', 'hora_fin' => '16:45:00', 'estatus' => '1'],
            ['hora_inicio' => '16:45:00', 'hora_fin' => '17:30:00', 'estatus' => '1'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horas');
    }
};