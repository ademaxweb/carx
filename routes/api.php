<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);

    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me']);

});

Route::group(['middleware' => 'jwt.auth'], function ($router){
    Route::post('/user/buyCar', [\App\Http\Controllers\UserController::class, 'buyCar']);
    Route::post('/user/sellCar', [\App\Http\Controllers\UserController::class, 'sellCar']);


    Route::get('/roulettes/{id}', [\App\Http\Controllers\RouletteController::class, 'byId']);
    Route::post('/roulettes/{id}/open', [\App\Http\Controllers\RouletteController::class, 'open']);
    Route::post('/roulettes/create', [\App\Http\Controllers\RouletteController::class, 'create']);
});

Route::post('auth/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::get('/cars', [\App\Http\Controllers\CarModelController::class, 'all']);
Route::get('/cars/{car}', [\App\Http\Controllers\CarModelController::class, 'byId']);
Route::post('/cars/create', [\App\Http\Controllers\CarModelController::class, 'create']);
Route::get('/brands', [\App\Http\Controllers\BrandController::class, 'all']);
Route::get('/brands/{id}', [\App\Http\Controllers\BrandController::class, 'byId']);

Route::get('/user/{id}', [\App\Http\Controllers\UserController::class, 'byId']);

Route::get('/roulettes', [\App\Http\Controllers\RouletteController::class, 'all']);

