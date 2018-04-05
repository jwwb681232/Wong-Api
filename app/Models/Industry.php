<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'industry';


    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'industry_id';



    public $timestamps = false;
}
