<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'employer';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'e_id';

    /**
     * @var array
     */
    protected $fillable = ['e_admin_id', 'e_recruiter_id', 'e_company_name', 'e_company_logo', 'e_email', 'e_company_description', 'e_contact_no', 'e_hourly_rate', 'e_industry_id', 'e_status'];


    public $timestamps = false;
}
