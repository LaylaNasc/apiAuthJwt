<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(
       [
                'status' => 'ok',
                'message' => 'API fUNCIONANDO!'
       ],200      
    );
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/registra', [AuthController::class, 'registra'])->name('registra');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/atualizarToken', [AuthController::class, 'atualizarToken'])->middleware('auth:api')->name('atualizarToken');
    Route::post('/obterUsuario', [AuthController::class, 'obterUsuario'])->middleware('auth:api')->name('obterUsuario');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('clientes', ClienteController::class);
});


