<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;



Route::apiResource('usuarios', UsuarioController::class);

Route::post('/usuarios/criar', [UsuarioController::class, 'store'])->name('criar_usuario');
