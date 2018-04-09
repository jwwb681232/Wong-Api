<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'settings';

    /**
     * 主键
     * @var string
     */
    protected $primaryKey = 'id';

    public $timestamps = false;
}
