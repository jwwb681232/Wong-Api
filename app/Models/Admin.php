<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guard = 'employer';


    /**
     * 表名
     * @var string
     */
    protected $table = 'admins';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'remember_token', 'created_at', 'updated_at', 'type', 'has_employer', 'status'];


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
