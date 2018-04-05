<?php

namespace App\Api\V1\Repositories;

use App\Models\JobSchedules;
use Prettus\Repository\Eloquent\BaseRepository;
class JobSchedulesRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return JobSchedules::class;
    }

    public function apply($member,$jobId)
    {
        $jobRep = app(JobRepository::class);
        $job = $jobRep->find($jobId);

        ////是否申请过
        //if ($this->findWhere(['member_id'=>$member->member_id,'job_id'=>$jobId])->first()){
        //    return ['error'=>1,'msg'=>'This job is already on your scheduled job list!'];
        //}

        ////个人状态是否可以申请
        //if ($member->member_status != 3){
        //    return ['error'=>1,'msg'=>'Your account status is pending or blocked!'];
        //}

        ////工作是否过期
        //if ($job->job_start_date <= time()){
        //    return ['error'=>1,'msg'=>'The job has already expired!'];
        //}

        //$startDate = $job->job_start_date;
        //$endDate = $job->job_start_date;

        //是否有时间相冲突的工作
        //if ($this->hasConflict($member->member_id,$startDate,$endDate)){
        //    return ['error'=>1,'msg'=>'You have a schedule that overlaps with this job start date or end date!'];
        //}
        
        $memberInfoRep = app(EmployeeInfoRepository::class);
        $memberInfo = $memberInfoRep->getInfo($member->toArray());
        echo '<pre>';
        print_r($memberInfo);
        die;
        



    }

    public function hasConflict($memberId,$startDate,$endDate)
    {
        return $this->model->leftJoin('job as j','job_schedules.job_id','j.job_id')
            ->where('job_schedules.member_id',$memberId)
            ->where(function ($query)use ($startDate,$endDate){
                $query->where(function ($query) use ($startDate) {
                    $query->where('j.job_start_date', '<=', $startDate);
                    $query->where('j.job_end_date', '>=', $startDate);
                });
                $query->orWhere(function ($query) use ($endDate){
                    $query->where('j.job_start_date', '<=', $endDate);
                    $query->where('j.job_end_date', '>=', $endDate);
                });
            })->first();
    }
}