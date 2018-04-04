<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//v1s1
Route::group([],function(){
    //apidoc
    Route::get('apidoc/v1/employee/json', '\App\Api\V1\Controllers\Member\SwaggerController@getJson');
});
