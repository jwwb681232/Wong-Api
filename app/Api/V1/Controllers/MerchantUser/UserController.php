<?php

namespace App\Api\V1\Controllers\MerchantUser;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register()
    {
        //请求时附带Authorization:bearer eyJ0eXAiOiJKV... 可以获取到用户信息
        //return response(auth()->guard('merchant')->user());

        //请求时附带Authorization:bearer eyJ0eXAiOiJKV... 可以获取到token payload
        //return response(auth()->guard('merchant')->payload());

        //根据给定条件可以获取生成的用户token App\Auth\EloquentMerchantUserProvider retrieveByCredentials 配合使用
        return response(auth()->guard('merchant')->attempt(['user_name' => 'wangxiao', 'user_mobile' => 18871478079]));

        //根据给定主键可以获取生成的用户token App\Models\MerchantUser $primaryKey 配合使用
        //return response(auth()->guard('merchant')->tokenById(1));
    }
}
