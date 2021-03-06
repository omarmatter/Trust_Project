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

//Route::middleware('auth:api')->get('/menu', function (Request $request) {
//    return $request->user();
//});


Route::middleware(['auth:sanctum','isAdmin'])->group(function () {
//    Route::resource('users','Api\UserController');

        Route::resource('categories', 'Api\CategoryController');

//        Route::get('product/fillter', [\Modules\Menu\Http\Controllers\Api\ProductController::class, 'fillter']);




});


Route::resource('products', 'Api\ProductController');
Route::get('productExport','Api\ProductController@export');

