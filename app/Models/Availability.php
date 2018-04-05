<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'availabilities';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['day', 'start_time', 'end_time', 'member_id'];


    public $timestamps = false;
}
