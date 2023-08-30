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
        Schema::create('carta_tipo_pontuacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_pontuacao_id')->constrained('tipo_pontuacao');
            $table->integer('valor_pontuacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta_tipo_pontuacao');
    }
};
