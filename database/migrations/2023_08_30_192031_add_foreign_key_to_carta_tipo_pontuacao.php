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
        Schema::table('carta_tipo_pontuacao', function (Blueprint $table) {
            $table->foreignId('carta_id')->constrained('cartas')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carta_tipo_pontuacao', function (Blueprint $table) {
            //
        });
    }
};
