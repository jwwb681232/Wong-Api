<?php

namespace App\Api\V1\Controllers;
use App\Api\V1\Repositories\IndustryRepository;
use App\Api\V1\Repositories\SchoolRepository;
use App\Http\Controllers\Controller;

class ExtraController extends Controller
{

    /**
     * @SWG\Post(path="/index.php/api/employee/extra/industry",
     *   tags={"employee/extra"},
     *   summary="行业列表",
     *   description="行业列表",
     *   operationId="industry",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function industry()
    {
        $industryRep = app(IndustryRepository::class);
        $industry = $industryRep->all();
        return apiReturn($industry);
    }

    /**
     * @SWG\Post(path="/index.php/api/employee/extra/school",
     *   tags={"employee/extra"},
     *   summary="学校列表",
     *   description="学校列表",
     *   operationId="school",
     *   consumes={"application/x-www-form-urlencoded"},
     *   @SWG\Parameter(in="header",  name="Content-Type",  type="string",  description="application/x-www-form-urlencoded", default="application/x-www-form-urlencoded",required=true),
     *   @SWG\Parameter(in="header",  name="Accept",  type="string",  description="版本号", default="application/x.yyjobs-api.v1+json",required=true),
     *   @SWG\Response(response="500", description=""),
     * )
     */
    public function school()
    {
        $schoolRep = app(SchoolRepository::class);
        $school = $schoolRep->all();
        return apiReturn($school);
    }
}
