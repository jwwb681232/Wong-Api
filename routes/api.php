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

$api = app(Dingo\Api\Routing\Router::class);

$api->version('v1', function ($api) {

    $api->group(['middleware'=>'api','prefix'=>'users'],function ($api){
        $api->post('auth/login',   'App\Api\V1\Controllers\User\AuthController@login');
        $api->post('auth/register','App\Api\V1\Controllers\User\AuthController@register');

        $api->get('profile/me',   'App\Api\V1\Controllers\User\ProfileController@me');
    });

    $api->group(['middleware'=>'api','prefix'=>'merchant'],function ($api){
        $api->post('auth/login',   'App\Api\V1\Controllers\MerchantUser\AuthController@login');
        $api->post('auth/register','App\Api\V1\Controllers\MerchantUser\AuthController@register');

        $api->get('profile/me',   'App\Api\V1\Controllers\MerchantUser\ProfileController@me');

    });
});