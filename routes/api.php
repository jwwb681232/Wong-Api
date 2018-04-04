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

    $api->group(['middleware'=>'api','prefix'=>'employee'],function ($api){
        //注册
        $api->post('auth/register','App\Api\V1\Controllers\Member\AuthController@register');
        $api->post('auth/register/fb','App\Api\V1\Controllers\Member\AuthController@registerForFacebook');
        $api->post('auth/register/google','App\Api\V1\Controllers\Member\AuthController@registerForFacebook');
        //登录
        $api->post('auth/login',   'App\Api\V1\Controllers\Member\AuthController@login');
        $api->post('auth/login/fb',   'App\Api\V1\Controllers\Member\AuthController@loginForFacebook');
        $api->post('auth/login/google',   'App\Api\V1\Controllers\Member\AuthController@loginForGoogle');
        //雇主申请
        $api->post('auth/apply','App\Api\V1\Controllers\Member\AuthController@applyEmployer');
    });
});