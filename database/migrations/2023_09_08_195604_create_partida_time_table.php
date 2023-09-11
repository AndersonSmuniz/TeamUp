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
        Schema::create('partida_time', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('partida_id');
            $table->unsignedBigInteger('time_id');

            $table->foreign('partida_id')
                ->references('id')
                ->on('partidas')
                ->onDelete('cascade');

            $table->foreign('time_id')
                ->references('id')
                ->on('times')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partida_time');
    }
};
