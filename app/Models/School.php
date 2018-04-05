<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'school';

    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'school_id';

    public $timestamps = false;
}
