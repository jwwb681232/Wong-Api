<?php

namespace App\Api\V1\Controllers\Member;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function bak()
    {
        //请求时附带Authorization:bearer eyJ0eXAiOiJKV... 可以获取到用户信息
        //return response(auth()->guard('merchant')->user());

        //请求时附带Authorization:bearer eyJ0eXAiOiJKV... 可以获取到token payload
        //return response(auth()->guard('merchant')->payload());

        //根据给定条件可以获取生成的用户token App\Auth\EloquentMerchantUserProvider retrieveByCredentials 配合使用
        //return response(auth()->guard('merchant')->attempt(['user_name' => 'wangxiao', 'user_mobile' => 18871478079]));

        //根据给定主键可以获取生成的用户token App\Models\MerchantUser $primaryKey 配合使用
        //return response(auth()->guard('merchant')->tokenById(1));
    }


    /**
     * @SWG\Get(path="/index.php/api/employee/profile/detail",
     *   tags={"employee/profile"},
     *   summary="用户详情",
     *   description="用户详情",
     *   operationId="detail",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function detail()
    {
        $user = auth()->guard('member')->user()->toArray();
        return apiReturn([$user]);
    }
}
