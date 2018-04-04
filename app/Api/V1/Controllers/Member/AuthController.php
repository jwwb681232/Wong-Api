<?php

namespace App\Api\V1\Controllers\Member;

use App\Models\Member;
use App\Http\Controllers\Controller;
use App\Api\V1\Repositories\EmployeeRepository;
use App\Api\V1\Repositories\EmployerApplyRepository;

class AuthController extends Controller
{
    /**
     * @SWG\Post(path="/index.php/api/employee/auth/register",
     *   tags={"employee/auth"},
     *   summary="普通注册",
     *   description="普通注册",
     *   operationId="register",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="name",type="string",  description="姓名", required=true),
     *   @SWG\Parameter(in="formData",  name="password",type="string",  description="密码", required=true),
     *   @SWG\Parameter(in="formData",  name="email",type="string",  description="邮箱", required=true),
     *   @SWG\Parameter(in="formData",  name="nric_no",type="string",  description="身份证号", required=true),
     *   @SWG\Parameter(in="formData",  name="mobile_no",type="string",  description="电话号码", required=true),
     *   @SWG\Parameter(in="formData",  name="school",type="integer",  description="学校id", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function register()
    {
        $employeeRep = app(EmployeeRepository::class);
        $res = $employeeRep->registerForMobile(request()->all());
        if ($res['error']){
            return apiReturn([], 403, $res['msg']);
        }
        return apiReturn($res['data']);

    }

    /**
     * @SWG\Post(path="/index.php/api/employee/auth/register/fb",
     *   tags={"employee/auth"},
     *   summary="Facebook注册",
     *   description="Facebook注册",
     *   operationId="register/fb",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="name",type="string",  description="姓名", required=true),
     *   @SWG\Parameter(in="formData",  name="email",type="string",  description="邮箱", required=true),
     *   @SWG\Parameter(in="formData",  name="nric_no",type="string",  description="身份证号", required=true),
     *   @SWG\Parameter(in="formData",  name="mobile_no",type="string",  description="电话号码", required=true),
     *   @SWG\Parameter(in="formData",  name="school",type="integer",  description="学校id", required=true),
     *   @SWG\Parameter(in="formData",  name="social_access_token",type="string",  description="第三方Token", required=true),
     *   @SWG\Parameter(in="formData",  name="social_fb_id",type="string",  description="第三方id", required=true),
     *   @SWG\Parameter(in="formData",  name="platform",type="string",  description="注册平台（1：ios，2：android，3：web）", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function registerForFacebook()
    {
        $employeeRep = app(EmployeeRepository::class);
        $res = $employeeRep->registerForFacebook(request()->all());
        if ($res['error']){
            return apiReturn([], 403, $res['msg']);
        }
        return apiReturn($res['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/auth/register/google",
     *   tags={"employee/auth"},
     *   summary="google注册",
     *   description="google注册",
     *   operationId="register/google",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="name",type="string",  description="姓名", required=true),
     *   @SWG\Parameter(in="formData",  name="email",type="string",  description="邮箱", required=true),
     *   @SWG\Parameter(in="formData",  name="nric_no",type="string",  description="身份证号", required=true),
     *   @SWG\Parameter(in="formData",  name="mobile_no",type="string",  description="电话号码", required=true),
     *   @SWG\Parameter(in="formData",  name="school",type="integer",  description="学校id", required=true),
     *   @SWG\Parameter(in="formData",  name="social_access_token",type="string",  description="第三方Token", required=true),
     *   @SWG\Parameter(in="formData",  name="social_google_id",type="string",  description="第三方id", required=true),
     *   @SWG\Parameter(in="formData",  name="platform",type="string",  description="注册平台（1：ios，2：android，3：web）", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function registerForGoogle()
    {
        $employeeRep = app(EmployeeRepository::class);
        $res = $employeeRep->registerForGoogle(request()->all());
        if ($res['error']){
            return apiReturn([], 403, $res['msg']);
        }
        return apiReturn($res['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/auth/login",
     *   tags={"employee/auth"},
     *   summary="登录",
     *   description="登录",
     *   operationId="login",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="nric_no",type="string",  description="身份证号", required=true),
     *   @SWG\Parameter(in="formData",  name="password",type="string",  description="密码", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function login()
    {

        $employeeRep = app(EmployeeRepository::class);
        $res = $employeeRep->login(request()->all());
        if ($res['error']){
            return apiReturn([], 403, $res['msg']);
        }
        return apiReturn($res['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/auth/login/fb",
     *   tags={"employee/auth"},
     *   summary="Facebook登录",
     *   description="Facebook登录",
     *   operationId="login/fb",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="social_fb_id",type="string",  description="facebook id", required=true),
     *   @SWG\Parameter(in="formData",  name="social_access_token",type="string",  description="第三方token", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function loginForFacebook()
    {
        $employeeRep = app(EmployeeRepository::class);
        $res = $employeeRep->loginForFacebook(request()->all());
        if ($res['error']){
            return apiReturn([], 403, $res['msg']);
        }
        return apiReturn($res['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/auth/login/google",
     *   tags={"employee/auth"},
     *   summary="Google登录",
     *   description="Google登录",
     *   operationId="login/google",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="social_google_id",type="string",  description="facebook id", required=true),
     *   @SWG\Parameter(in="formData",  name="social_access_token",type="string",  description="第三方token", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function loginForGoogle()
    {
        $employeeRep = app(EmployeeRepository::class);
        $res = $employeeRep->loginForGoogle(request()->all());
        if ($res['error']){
            return apiReturn([], 403, $res['msg']);
        }
        return apiReturn($res['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/auth/apply",
     *   tags={"employee/auth/apply"},
     *   summary="申请注册雇主",
     *   description="申请注册雇主",
     *   operationId="apply",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="name",type="string",  description="姓名", required=true),
     *   @SWG\Parameter(in="formData",  name="business_name",type="string",  description="店铺名称", required=true),
     *   @SWG\Parameter(in="formData",  name="email",type="string",  description="邮箱", required=true),
     *   @SWG\Parameter(in="formData",  name="mobile_no",type="string",  description="电话号码", required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="403", description="无权限"),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function applyEmployer()
    {
        $employerRep = app(EmployerApplyRepository::class);
        $res         = $employerRep->apply(request()->all());
        if ($res['error']){
            return apiReturn([], 403, $res['msg']);
        }
        return apiReturn($res['data']);
    }
}