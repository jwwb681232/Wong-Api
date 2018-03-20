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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

$api = app(Dingo\Api\Routing\Router::class);

$api->version('v1', function ($api) {

    $api->group(['middleware'=>'api','prefix'=>'users'],function ($api){
        $api->post('register','App\Api\V1\Controllers\User\UserController@register');
        $api->post('login',   'App\Api\V1\Controllers\User\UserController@login');
    });

    $api->group(['middleware'=>'api','prefix'=>'merchant'],function ($api){
        $api->post('register','App\Api\V1\Controllers\MerchantUser\UserController@register');
        $api->post('login',   'App\Api\V1\Controllers\MerchantUser\UserController@login');
    });
});