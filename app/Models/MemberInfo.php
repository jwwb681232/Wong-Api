<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberInfo extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'member_info';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'info_id';

    /**
     * @var array
     */
    protected $fillable = ['member_id', 'info_religion', 'info_address', 'info_school_expiry_date', 'info_emergency_name', 'info_emergency_phone', 'info_emergency_relationship', 'info_emergency_address', 'info_contact_method', 'info_criminal_record', 'info_medication', 'info_bank_statement', 'info_language', 'info_is_uploaded', 'info_signature', 'info_nationality', 'info_nric_zheng', 'info_nric_fan',];


    public $timestamps = false;
}
