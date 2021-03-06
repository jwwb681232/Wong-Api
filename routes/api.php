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

        $api->group(['middleware'=>'api.auth'], function($api) {
            $api->get('profile/detail',   'App\Api\V1\Controllers\Member\ProfileController@detail');
            $api->post('profile/edit',   'App\Api\V1\Controllers\Member\ProfileController@edit');
            $api->post('profile/edit_additional',   'App\Api\V1\Controllers\Member\ProfileController@editAdditional');

            //工作列表
            $api->get('job/list','App\Api\V1\Controllers\Member\JobController@lists');
            //工作详情
            $api->get('job/detail','App\Api\V1\Controllers\Member\JobController@detail');
            //工作申请
            $api->post('job/apply','App\Api\V1\Controllers\Member\JobSchedulesController@apply');
            //工作计划列表
            $api->get('job/schedules/list','App\Api\V1\Controllers\Member\JobSchedulesController@lists');
            //工作签入详情
            $api->get('job/schedules/detail','App\Api\V1\Controllers\Member\JobSchedulesController@detail');
            //工作签入
            $api->post('job/schedules/checkin','App\Api\V1\Controllers\Member\JobSchedulesController@checkin');
            //工作签出
            $api->post('job/schedules/checkout','App\Api\V1\Controllers\Member\JobSchedulesController@checkout');
            //取消工作计划
            $api->post('job/schedules/cancel','App\Api\V1\Controllers\Member\JobSchedulesController@cancel');
        });

        //雇主申请
        $api->post('auth/apply','App\Api\V1\Controllers\Member\AuthController@applyEmployer');
        //行业列表
        $api->get('extra/industry','App\Api\V1\Controllers\ExtraController@industry');
        //学校列表
        $api->get('extra/school','App\Api\V1\Controllers\ExtraController@school');
    });

});