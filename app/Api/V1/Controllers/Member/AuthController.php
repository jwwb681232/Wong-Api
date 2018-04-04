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
     *   tags={"employer/auth"},
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

        /*if (Member::where('user_name', request()->input('user_name'))->first()) {
            $response = ['status' => 'Error', 'message' => 'User Already Exists!'];

            return response($response, 400);
        }

        if ( ! $user = Member::create(request()->all())) {
            $response = ['status' => 'Error', 'message' => 'Unknown'];

            return response($response, 400);
        }

        $token = auth()->guard('member')->attempt(request()->all());

        $response = [
            'status'  => 'Success',
            'data'    => $token,
            'message' => 'Request Success!',
        ];

        return response($response);*/
    }

    public function login()
    {
        $token = auth()->guard('member')->attempt(request()->all());

        $response = ['status' => 'Success', 'data' => $token, 'message' => 'Request Success!'];

        return response($response);
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