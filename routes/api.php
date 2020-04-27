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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 注文
Route::apiResource('/orders', 'OrderApiController');
Route::apiResource('/orderCarts', 'OrderCartApiController');
Route::apiResource('/orderItems', 'OrderItemApiController');

// 学校
Route::apiResource('/schools', 'SchoolApiController');
