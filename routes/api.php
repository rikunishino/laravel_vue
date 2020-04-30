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

// 科目
Route::apiResource('/subjects', 'SubjectApiController');

// 商品
Route::apiResource('/products', 'ProductApiController');

// 法人
Route::apiResource('/corporations', 'CorporationApiController');


// 注文
Route::apiResource('/orders', 'OrderApiController');
Route::apiResource('/orderSchools', 'OrderSchoolApiController');
Route::apiResource('/orderCarts', 'OrderCartApiController');
Route::apiResource('/orderItems', 'OrderItemApiController');

// 学校
Route::apiResource('/schools', 'SchoolApiController');
