<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\UsuarioController;
use \App\Http\Controllers\Api\V1\EsporteController;
use \App\Http\Controllers\Api\V1\TipoPontuacaoController;
use \App\Http\Controllers\AuthController;


Route::prefix('V1')->group(function (){

    Route::post('login', [AuthController::class, 'login']);

    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.store');
        Route::post('usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.store');
        Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.store');
        Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.store');
        Route::post('logout', [AuthController::class, 'logout']);

        Route::apiResource('esportes', EsporteController::class);

        Route::get('esportes/{esporte}/tipo_pontuacao', [TipoPontuacaoController::class, 'index'])->name('tipo_pontuacao.index');
        Route::post('esportes/{esporte}/tipo_pontuacao', [TipoPontuacaoController::class, 'store'])->name('tipo_pontuacao.store');
        Route::post('esportes/{esporte}/tipo_pontuacao/{id}', [TipoPontuacaoController::class, 'show'])->name('tipo_pontuacao.show');
        Route::put('esportes/{esporte}/tipo_pontuacao/{id}', [TipoPontuacaoController::class, 'update'])->name('tipo_pontuacao.update');
        Route::delete('esportes/{esporte}/tipo_pontuacao/{id}', [TipoPontuacaoController::class, 'destroy'])->name('tipo_pontuacao.destroy');

    });
});

