<?php

namespace App\Api\V1\Controllers\Member;

use App\Api\V1\Repositories\JobRepository;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;

class JobController extends Controller
{
    /**
     * @SWG\Get(path="/index.php/api/employee/job/list",
     *   tags={"employee/job"},
     *   summary="工作列表",
     *   description="工作列表",
     *   operationId="job",
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
        $jobRep        = app(JobRepository::class);

        $curPage         = $request->input('cur_page', 1);
        $pageSize        = $request->input('page_size', 15);
        $industryId      = $request->input('industry_id', '');
        $startTime       = $request->input('start_time', 0);

        $data = $jobRep->search($curPage, $pageSize, $industryId,$startTime);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }

    /**
     * @SWG\Get(path="/index.php/api/employee/job/detail",
     *   tags={"employee/job"},
     *   summary="工作详情",
     *   description="工作详情",
     *   operationId="job",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="query",  name="job_id",type="string",  description="工作id", required=true),
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
        $jobRep = app(JobRepository::class);

        $memberId = auth('member')->user()->member_id;
        $jobId    = $request->input('job_id');

        $data = $jobRep->detail($memberId, $jobId);
        if ($data['error']) {
            return apiReturn([], 404, $data['msg']);
        }

        return apiReturn($data['data']);
    }
}
