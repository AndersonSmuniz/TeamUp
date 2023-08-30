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
        Schema::create('tipo_pontuacao', function (Blueprint $table) {
            $table->id();
            $table->string('posicao');
            $table->integer('valor_pontuacao');
            $table->string('nome_pontuacao');
            $table->foreignId('esporte_id')->constrained('esportes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_pontuacao');
    }
};
