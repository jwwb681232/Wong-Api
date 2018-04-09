<?php

namespace App\Api\V1\Controllers\Member;

use App\Api\V1\Repositories\JobSchedulesRepository;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;

class JobSchedulesController extends Controller
{
    /**
     * @SWG\Post(path="/index.php/api/employee/job/apply",
     *   tags={"employee/job"},
     *   summary="申请工作",
     *   description="申请工作",
     *   operationId="job",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="job_id",type="string",  description="工作id", required=false),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apply(Request $request)
    {
        $member = auth('member')->user();
        $jobId = $request->input('job_id');
        $schedulesRep = app(JobSchedulesRepository::class);
        $data         = $schedulesRep->apply($member,$jobId);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }

    /**
     * @SWG\Get(path="/index.php/api/employee/job/schedules/list",
     *   tags={"employee/job/schedules"},
     *   summary="工作计划列表",
     *   description="工作计划列表",
     *   operationId="list",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="query",  name="cur_page",type="string",  description="当前页", required=false),
     *   @SWG\Parameter(in="query",  name="page_size",type="string",  description="每页条数", required=false),
     *   @SWG\Parameter(in="query",  name="industry_id",type="string",  description="行业id", required=false),
     *   @SWG\Parameter(in="query",  name="start_time",type="string",  description="工作开始时间", required=false),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists(Request $request)
    {
        $jobRep        = app(JobSchedulesRepository::class);

        $curPage         = $request->input('cur_page', 1);
        $pageSize        = $request->input('page_size', 15);
        $industryId      = $request->input('industry_id', '');
        $startTime       = $request->input('start_time', 0);
        $memberId        = auth('member')->user()->member_id;

        $data = $jobRep->search($curPage, $pageSize, $memberId,$industryId,$startTime);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }

    /**
     * @SWG\Get(path="/index.php/api/employee/job/schedules/detail",
     *   tags={"employee/job/schedules"},
     *   summary="check-in详情",
     *   description="check-in详情",
     *   operationId="detail",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request)
    {
        $jobRep        = app(JobSchedulesRepository::class);

        $memberId      = auth('member')->user()->member_id;

        $data = $jobRep->detail($memberId);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/job/schedules/cancel",
     *   tags={"employee/job/schedules"},
     *   summary="取消工作计划",
     *   description="取消工作计划",
     *   operationId="cancel",
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter(in="formData",  name="file",  type="file",  description="取消的证明图片",required=false),
     *   @SWG\Parameter(in="formData",  name="reason",  type="string",  description="取消的原因",required=true),
     *   @SWG\Parameter(in="formData",  name="id",  type="string",  description="取消的计划ID",required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request)
    {
        $jobRep        = app(JobSchedulesRepository::class);

        $memberId      = auth('member')->user()->member_id;
        $schedulesId   = $request->input('id');

        $data = $jobRep->cancel($request,$memberId,$schedulesId);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/job/schedules/checkin",
     *   tags={"employee/job/schedules"},
     *   summary="工作签入（更新用户坐标）",
     *   description="工作签入（更新用户坐标）",
     *   operationId="checkin",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="schedule_id",  type="string",  description="工作计划ID",required=true),
     *   @SWG\Parameter(in="formData",  name="latitude",  type="string",  description="纬度",required=true),
     *   @SWG\Parameter(in="formData",  name="longitude",  type="string",  description="经度",required=true),
     *   @SWG\Parameter(in="formData",  name="address",  type="string",  description="用户当前地址信息",required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkin(Request $request)
    {
        $jobRep        = app(JobSchedulesRepository::class);

        $memberId      = auth('member')->user()->member_id;
        $schedulesId   = $request->input('schedule_id');
        $latitude      = $request->input('latitude');
        $longitude     = $request->input('longitude');
        $address       = $request->input('address');

        $data = $jobRep->checkin($memberId,$schedulesId,$latitude,$longitude,$address);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/job/schedules/checkout",
     *   tags={"employee/job/schedules"},
     *   summary="工作签出",
     *   description="工作签出",
     *   operationId="checkout",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="formData",  name="schedule_id",  type="string",  description="工作计划ID",required=true),
     *   @SWG\Parameter(in="formData",  name="latitude",  type="string",  description="纬度",required=true),
     *   @SWG\Parameter(in="formData",  name="longitude",  type="string",  description="经度",required=true),
     *   @SWG\Parameter(in="formData",  name="address",  type="string",  description="用户当前地址信息",required=true),
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Parameter(in="header",  name="Authorization",  type="string",  description="Token 前面需要加：'bearer '",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Request $request)
    {
        $jobRep        = app(JobSchedulesRepository::class);

        $member        = auth('member')->user();
        $schedulesId   = $request->input('schedule_id');
        $latitude      = $request->input('latitude');
        $longitude     = $request->input('longitude');
        $address       = $request->input('address');

        $data = $jobRep->checkout($member,$schedulesId,$latitude,$longitude,$address);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }
}
