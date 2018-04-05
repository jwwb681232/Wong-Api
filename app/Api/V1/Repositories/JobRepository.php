<?php

namespace App\Api\V1\Repositories;

use DB;
use App\Models\Job;
use Prettus\Repository\Eloquent\BaseRepository;
class JobRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Job::class;
    }

    public function search($curPage, $pageSize, $industryId,$startTime)
    {
        $offset = ($curPage - 1) * $pageSize;
        if ($industryId){
            $this->model = $this->model->where('industry_id',$industryId);
        }
        if ($startTime){
            $this->model = $this->model->where('job_start_date','<',$startTime);
        }else{
            $this->model = $this->model->where('job_start_date','<',time());
        }
        //总数
        $count = $this->model->count();

        //总页数
        $countPage = ceil($count / $pageSize);

        //数据
        $result = $this->model->offset($offset)->limit($pageSize)->orderBy('job_id','desc')->get()->toArray();

        return [
            'error' => 0,
            'data'  => compact('countPage', 'count', 'curPage', 'pageSize', 'result'),
        ];

    }

    public function detail($memberId, $jobId)
    {
        $job = $this->find($jobId)->toArray();
        $data['job'] = $this->formatJob($job);
        $data['schedules'] = $this->getSchedules($memberId,$job['job_id']);
        return [
            'error' => 0,
            'data'  => $data,
        ];
    }

    private function formatJob($job){
        $data['job_id'] = $job['job_id'];
        $data['description']['job_image'] = $job['job_image'];
        $data['description']['job_type'] = $job['job_employer_company_name'];
        $data['description']['job_location'] = $job['job_address'];
        $data['description']['job_date'] = $job['job_address'];
        $data['description']['hourly_rate'] = $job['job_hour_rate'];
        $starTime = $job['job_start_date'];
        $data['description']['job_date'] = date('d/m/Y',$job['job_start_date']).'('.date('H:ia',$starTime).' - '.date('H:ia',$job['job_end_date']).')';
        $data['job_role'] = $job['job_post'];
        $data['required']['age'] = $job['job_people_min_age'] !=  50 ? $job['job_people_min_age'].'-'.$job['job_people_max_age'] : '50+';
        $data['required']['language'] = $job['job_people_language'];
        $data['required']['gender'] = $job['job_people_language'] == 0 ? 'all' : ($job['job_people_language'] == 1 ? 'male' : 'female');
        $data['required']['nationality'] = $job['job_people_nationality'];
        $data['remarks'] = $job['job_note'];
        $data['requirements'] = $job['job_requirements'];

        return $data;
    }

    private function getSchedules($memberId,$jobId){
        $schedulesRep = app(JobSchedulesRepository::class);
        $schedules = $schedulesRep->findWhere(['member_id'=>$memberId,'job_id'=>$jobId])->first();
        if ($schedules){
            return $schedules->toArray();
        }
        return [];
    }
}