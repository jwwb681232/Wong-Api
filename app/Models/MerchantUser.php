<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MerchantUser extends Authenticatable
{
    use Notifiable;

    protected $guard = 'merchant';


    /**
     * 表名
     * @var string
     */
    protected $table = 'wong_merchant_users';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'user_id';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public $timestamps = false;

    /**
     * 获取主键
     * @return string
     */
    public function getJWTIdentifier()
    {
        return $this->primaryKey;
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
