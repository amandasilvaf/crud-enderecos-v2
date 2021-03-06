<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdressController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tipo-endereco', [AdressController::class, 'getTypes']); 
Route::get('/tipo/{id}', [AdressController::class, 'getType']);
Route::get('/enderecos', [AdressController::class, 'getAdresses']);
Route::post('/enderecos', [AdressController::class, 'store']);
Route::put('/enderecos/editar/{id}', [AdressController::class, 'update']);
Route::get('/enderecos/{id}', [AdressController::class, 'show']);
Route::delete('/enderecos/deletar/{id}', [AdressController::class, 'destroy']);