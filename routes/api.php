<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\UsuarioController;
use \App\Http\Controllers\Api\V1\EsporteController;
use \App\Http\Controllers\Api\V1\TipoPontuacaoController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\Api\V1\CartaController;
use \App\Http\Controllers\Api\V1\PartidaController;
use \App\Http\Controllers\Api\V1\PontuacaoController;


Route::prefix('V1')->group(function (){

    Route::post('login', [AuthController::class, 'login']);

    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
        Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

        Route::post('logout', [AuthController::class, 'logout']);

        Route::apiResource('esportes', EsporteController::class);

        Route::get('esportes/{esporte}/tipo_pontuacao', [TipoPontuacaoController::class, 'index'])->name('tipo_pontuacao.index');
        Route::post('esportes/{esporte}/tipo_pontuacao', [TipoPontuacaoController::class, 'store'])->name('tipo_pontuacao.store');
        Route::post('esportes/{esporte}/tipo_pontuacao/{id}', [TipoPontuacaoController::class, 'show'])->name('tipo_pontuacao.show');
        Route::put('esportes/{esporte}/tipo_pontuacao/{id}', [TipoPontuacaoController::class, 'update'])->name('tipo_pontuacao.update');
        Route::delete('esportes/{esporte}/tipo_pontuacao/{id}', [TipoPontuacaoController::class, 'destroy'])->name('tipo_pontuacao.destroy');

        Route::post('carta', [CartaController::class, 'CriarCarta'])->name('carta.CriarCarta');
        Route::get('carta', [CartaController::class, 'index'])->name('carta.index');
        Route::delete('carta/{id}', [CartaController::class, 'destroy'])->name('carta.destroy');

        Route::apiResource('partida', PartidaController::class);
        Route::post('partida/{partida}/entrar', [PartidaController::class,'entrar'])->name('partida.entrar');
        Route::post('partida/{partida}/finalizar',[PartidaController::class, 'finalizarPartida'])->name('partida.ficalizarPartida');

        Route::put('partida/{partida}/ponto', [PontuacaoController::class,'addPontuacao'])->name('partida.addPontuacao');
    });
});

