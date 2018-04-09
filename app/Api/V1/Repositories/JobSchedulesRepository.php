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

    /**
     * 申请工作
     * @param $member
     * @param $jobId
     *
     * @return array
     */
    public function apply($member,$jobId)
    {
        $jobRep = app(JobRepository::class);
        $job = $jobRep->find($jobId);
        $memberInfoRep = app(EmployeeInfoRepository::class);
        $memberInfo = $memberInfoRep->getInfo($member->toArray());
        if ($jobValid = $this->validJob($job,$memberInfo)){
            if ($jobValid['error'] == 1){
                return $jobValid;
            }
        }

        $schedules = $this->createSchedules($job,$memberInfo);

        return ['error'=>0,'data'=>$schedules,'msg'=>'Successful application'];

    }

    /**
     * 验证是否可以申请
     * @param $job
     * @param $memberInfo
     *
     * @return array
     */
    public function validJob($job,$memberInfo)
    {
        //是否申请过
        if ($this->findWhere(['member_id'=>$memberInfo['member_id'],'job_id'=>$job->job_id])->first()){
            return ['error'=>1,'msg'=>'This job is already on your scheduled job list!'];
        }

        //个人状态是否可以申请
        if ($memberInfo['member_status'] != 3){
            return ['error'=>1,'msg'=>'Your account status is pending or blocked!'];
        }

        //工作是否过期
        if ($job->job_start_date <= time()){
            return ['error'=>1,'msg'=>'The job has already expired!'];
        }

        $startDate = $job->job_start_date;
        $endDate = $job->job_start_date;

        //是否有时间相冲突的工作
        if ($this->hasConflict($memberInfo['member_id'],$startDate,$endDate)){
            return ['error'=>1,'msg'=>'You have a schedule that overlaps with this job start date or end date!'];
        }

        //是否填写用户详细信息
        if(!isset($memberInfo['info_id'])){
            return ['error'=>1,'msg'=>'Your info setting doesn\'t meet the job requirement. Please go back to try other jobs.'];
        }

        $age = $this->getMemberAge($memberInfo['member_birthday']);

        //年龄是否符合要求
        if (!($age > $job->job_people_min_age && $age < $job->job_people_max_age)){
            return ['error'=>1,'msg'=>'Age does not meet requirements.'];
        }

        //性别是否符合要求
        if ($job->job_people_sex != 0 && $job->job_people_sex != $memberInfo['member_sex']){
            return ['error'=>1,'msg'=>'Sex does not meet requirements'];
        }

        //国籍是否符合要求
        if ($job->job_people_nationality != '' && $job->job_people_nationality != $memberInfo['info_nationality']){
            return ['error'=>1,'msg'=>'Nationality does not meet requirements'];
        }

        //语言是否符合要求
        $lang = $this->validLanguage($job->job_people_language,$memberInfo['info_language']);
        if (!$lang){
            return ['error'=>1,'msg'=>'Language does not meet requirements'];
        }

        //工作是否申请满了
        $applyNum = $this->getJobApplyNum($job->job_id);
        if ($applyNum >= $job->job_need_people_count){
            return ['error'=>1,'msg'=>'This job has already fully applied. Please check other jobs.'];
        }

        return ['error'=>0];
    }

    /**
     * 是否有时间相冲突的工作
     * @param $memberId
     * @param $startDate
     * @param $endDate
     *
     * @return mixed
     */
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

    /**
     * 根据时间戳获取年龄
     * @param $time
     *
     * @return float
     */
    public function getMemberAge($time)
    {
        return (time() - $time) / 60 / 60 / 24 / 365;
    }

    /**
     * 语言是否符合
     * @param $jobLang
     * @param $memberLang
     *
     * @return bool
     */
    public function validLanguage($jobLang, $memberLang)
    {
        if ($jobLang == ''){
            return true;
        }
        if ($jobLang != '' && $memberLang == ''){
            return false;
        }
        
        $jobLanguage = explode(',',$jobLang);
        $memberLanguage = explode(',',$memberLang);
        
        if (array_diff($jobLanguage,$memberLanguage)){
            return false;
        }

        return true;
    }

    /**
     * 工作申请了多少人
     * @param $jobId
     *
     * @return mixed
     */
    public function getJobApplyNum($jobId)
    {
        //工作状态（1：Pending信用低于70的时候申请的，
        //2：Applied申请成功，
        //3：Rejected Request管理员拒绝，
        //4：Auto Cancelled未签到或到时未签出自动取消，
        //5：Complete成功签出待审批，
        //6：Payment Pending待支付，
        //7：Rejected不认可该工作，
        //8：Payment Processed支付完成）
        return $this->model->where('job_id',$jobId)->where('work_status',[2,4,5,6,7,8])->count();
    }

    /**
     * 插入数据
     * @param $job
     * @param $member
     *
     * @return mixed
     */
    public function createSchedules($job,$member)
    {
        $schedules['member_id'] = $member['member_id'];
        $schedules['member_name'] = $member['member_name'];
        $schedules['job_id'] = $job->job_id;
        $schedules['is_assigned'] = 0;
        $schedules['cancel_status'] = 0;
        $schedules['cancel_reason'] = '';
        $schedules['cancel_image'] = '';
        $schedules['checkin_time'] = 0;
        $schedules['checkin_address'] = '';
        $schedules['checkout_time'] = 0;
        $schedules['checkout_address'] = '';
        $schedules['work_hours'] = 0.00;
        $schedules['adjusted_hourly_rate'] = 0.00;
        $schedules['job_salary'] = 0.00;
        $schedules['process_date'] = 0;
        $schedules['payment_methods'] = '';
        $schedules['add_time'] = time();
        $schedules['member_current_lat'] = '';
        $schedules['member_current_long'] = '';
        $schedules['work_status'] = $member['member_credit'] < 70 ? 1 : 2;

        return $this->create($schedules);
    }
}