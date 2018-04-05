<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'job';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'job_id';

    protected $fillable = ['job_publish_admin_id', 'job_publish_admin_role', 'job_employer_admin_id', 'job_employer_company_name', 'job_recruiter_admin_id', 'job_recruiter_admin_name', 'job_title', 'job_description', 'job_post', 'job_image', 'job_address', 'job_need_people_count', 'job_contact_name', 'job_contact_no', 'job_start_date', 'job_end_date', 'job_hour_rate', 'job_note', 'job_add_time', 'job_update_time', 'job_industry_id', 'job_industry_name', 'job_people_sex', 'job_people_language', 'job_people_nationality', 'job_people_min_age', 'job_people_max_age', 'job_latitude', 'job_longitude', 'job_requirements', 'job_geolocation', 'job_zip', 'job_status'];

    public $timestamps = false;
}
