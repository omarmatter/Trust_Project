<?php

use Illuminate\Http\Request;
use  \Illuminate\Support\Facades;

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

//Route::middleware('auth:api')->get('/order', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::resource('carts','Api\CartController');
    Route::resource('orders','Api\OrderController');

});
