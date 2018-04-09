<?php

namespace App\Api\V1\Repositories;

use App\Models\Setting;
use Prettus\Repository\Eloquent\BaseRepository;
class SettingRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Setting::class;
    }
}