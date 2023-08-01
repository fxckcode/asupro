<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout'])->middleware("auth:sanctum");
    });
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('unidadmedida', UnidadMedidaController::class);
        Route::apiResource('categorias', CategoriasController::class);
        Route::apiResource('productos', ProductosController::class);
        Route::apiResource('users', UsersController::class);
        Route::get('productos/categoria/{id}', [ProductosController::class, 'getProductsByCategorie']);
        Route::get('productos/unidadmedida/{id}', [ProductosController::class, 'getProductsByUnidadMedida']);
        Route::middleware('checkdate')->group(function () {
            Route::apiResource('pedidos', PedidosController::class);
        });
    });

});

