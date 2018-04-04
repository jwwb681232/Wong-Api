<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guard = 'member';


    /**
     * 表名
     * @var string
     */
    protected $table = 'member';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'member_id';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'member_password',
    ];

    /**
     * @var array
     */
    protected $fillable = ['member_name', 'member_sex', 'member_email', 'member_password', 'member_add_time', 'member_update_time', 'member_platform', 'member_country_code', 'member_mobile', 'member_nric', 'member_school_id', 'social_access_token', 'social_google_id', 'social_fb_id', 'member_avatar', 'member_salary_rate', 'member_birthday', 'member_credit', 'member_point', 'member_recruiter_id', 'member_status',];


    public $timestamps = false;

    /**
     * 获取主键
     * @return string
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 返回一个键值数组，其中包含要添加到JWT的任何自定义声明。
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
