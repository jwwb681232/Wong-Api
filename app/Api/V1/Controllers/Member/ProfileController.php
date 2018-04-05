<?php

namespace App\Api\V1\Controllers\Member;

use App\Api\V1\Repositories\EmployeeInfoRepository;
use App\Api\V1\Repositories\FileRepository;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;

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
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function detail()
    {
        $user = auth('member')->user()->toArray();
        $infoRep = app(EmployeeInfoRepository::class);
        $info = $infoRep->getInfo($user);
        return apiReturn($info);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/profile/edit",
     *   tags={"employee/profile"},
     *   summary="修改用户信息",
     *   description="修改用户信息",
     *   operationId="edit",
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter(in="formData",  name="member_avatar",type="file",  description="头像", required=true),
     *   @SWG\Parameter(in="formData",  name="old_password",type="string",  description="旧密码", required=true),
     *   @SWG\Parameter(in="formData",  name="password",type="string",  description="新密码", required=true),
     *   @SWG\Parameter(in="formData",  name="password_confirmation",type="string",  description="确认新密码", required=true),
     *   @SWG\Parameter(in="formData",  name="mobile_no",type="string",  description="手机号", required=true),
     *   @SWG\Parameter(in="formData",  name="availabilitys[0][day]",type="string",  description="日期(一个星期中的第几天)", required=true),
     *   @SWG\Parameter(in="formData",  name="availabilitys[0][start_time]",type="string",  description="开始时间（9:00）", required=true),
     *   @SWG\Parameter(in="formData",  name="availabilitys[0][end_time]",type="string",  description="结束时间（18:00）", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function edit()
    {
        $request = [
            'old_password' => request()->input('old_password'),
            'password' => request()->input('password'),
            'password_confirmation' => request()->input('password_confirmation'),
            'mobile_no' => request()->input('mobile_no'),
            'availabilitys' => request()->input('availabilitys'),
        ];
        $user = auth('member')->user()->toArray();
        $infoRep = app(EmployeeInfoRepository::class);
        if (request()->file('member_avatar')){
            $fileRepository = app(FileRepository::class);
            $request['member_avatar'] = $fileRepository->imageReSize( request()->file('member_avatar'),generateFilePath());
        }

        $info = $infoRep->edit($user,$request);
        if ($info['error']){
            return apiReturn([], 403, $info['msg']);
        }
        return apiReturn($info['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/profile/edit_additional",
     *   tags={"employee/profile"},
     *   summary="修改附加信息",
     *   description="修改附加信息",
     *   operationId="edit",
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter(in="formData",  name="gender",type="string",  description="性别(1:男，2：女)", required=true),
     *   @SWG\Parameter(in="formData",  name="birthdate",type="string",  description="生日(时间戳)", required=true),
     *   @SWG\Parameter(in="formData",  name="religion",type="string",  description="宗教", required=true),
     *   @SWG\Parameter(in="formData",  name="address",type="string",  description="详细地址", required=true),
     *   @SWG\Parameter(in="formData",  name="school",type="string",  description="学校id", required=true),
     *   @SWG\Parameter(in="formData",  name="school_pass_expiry_date",type="string",  description="学生证到期时间", required=true),
     *   @SWG\Parameter(in="formData",  name="bank_account",type="string",  description="银行卡号", required=true),
     *   @SWG\Parameter(in="formData",  name="language",type="string",  description="语言（多个用,隔开）", required=true),
     *   @SWG\Parameter(in="formData",  name="email",type="string",  description="邮箱", required=true),
     *   @SWG\Parameter(in="formData",  name="emergency_name",type="string",  description="紧急联系人", required=true),
     *   @SWG\Parameter(in="formData",  name="emergency_contact_no",type="string",  description="紧急联系人电话", required=true),
     *   @SWG\Parameter(in="formData",  name="emergency_relationship",type="string",  description="与紧急联系人的关系", required=true),
     *   @SWG\Parameter(in="formData",  name="emergency_address",type="string",  description="紧急联系人地址", required=true),
     *   @SWG\Parameter(in="formData",  name="contact_method",type="string",  description="本人联系方式", required=true),
     *   @SWG\Parameter(in="formData",  name="criminal_record",type="string",  description="犯罪记录（没有的传none）", required=true),
     *   @SWG\Parameter(in="formData",  name="medication",type="string",  description="药物治疗史（没有的传none）", required=true),
     *   @SWG\Parameter(in="formData",  name="ic_front",type="file",  description="身份证正面照", required=true),
     *   @SWG\Parameter(in="formData",  name="ic_back",type="file",  description="身份证反面照", required=true),
     *   @SWG\Parameter(in="formData",  name="signature",type="file",  description="签名图片", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function editAdditional(Request $request)
    {
        $user = auth('member')->user()->toArray();
        $infoRep = app(EmployeeInfoRepository::class);
        $info = $infoRep->editAdditional($user,$request);
        if ($info['error']){
            return apiReturn([], 403, $info['msg']);
        }
        return apiReturn($info['data']);
    }
}
