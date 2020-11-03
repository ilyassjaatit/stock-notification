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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('create-token', \App\Http\Controllers\UserTokenController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class)
    ->middleware('auth:sanctum');

Route::resource('categories', \App\Http\Controllers\CategoryController::class )
    ->middleware('auth:sanctum');
