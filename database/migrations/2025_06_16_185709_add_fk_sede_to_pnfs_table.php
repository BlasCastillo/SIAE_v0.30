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
       Schema::table('pnfs', function (Blueprint $table) {
        $table->foreignId('fk_sede')->nullable()->constrained('sedes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pnfs', function (Blueprint $table) {
            $table->dropForeign(['fk_sede']);
            $table->dropColumn('fk_sede');
        });
    }
};
