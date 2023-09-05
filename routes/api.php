<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\UsuarioController;


Route::prefix('V1')->group(function (){

    Route::apiResource('usuarios', UsuarioController::class);

});

