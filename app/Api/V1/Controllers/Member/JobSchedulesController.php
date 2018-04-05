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
}
