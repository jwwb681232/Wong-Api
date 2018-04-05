<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSchedules extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'job_schedules';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 's_id';

    protected $fillable = ['member_id', 'member_name', 'job_id', 'is_assigned', 'cancel_status', 'cancel_reason', 'cancel_image', 'checkin_time', 'checkin_address', 'checkout_time', 'checkout_address', 'work_hours', 'adjusted_hourly_rate', 'job_salary', 'process_date', 'payment_methods', 'add_time', 'member_current_lat', 'member_current_long', 'work_status',];

    public $timestamps = false;
}
