<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerApply extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'employer_apply';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'apply_id';

    /**
     * @var array
     */
    protected $fillable = ['apply_name', 'apply_business_name', 'apply_email', 'apply_contact_no', 'apply_time', 'apply_status'];


    public $timestamps = false;
}
