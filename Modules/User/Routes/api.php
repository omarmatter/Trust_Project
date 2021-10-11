<?php

use Illuminate\Http\Request;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

});
Route::middleware(['auth:sanctum','isAdmin'])->group(function () {
    Route::resource('users','Api\UserController');
//    Route::resource('catogereis',\App\Http\Controllers\Api\CatogeryController::class);


});

Route::prefix('auth')->group(function () {
    Route::post('register', [\Modules\User\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('login', [\Modules\User\Http\Controllers\Api\AuthController::class, 'login']);
});
