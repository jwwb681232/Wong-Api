<?php

namespace App\Api\V1\Repositories;

use App\Models\JobSchedules;
use Prettus\Repository\Eloquent\BaseRepository;
class JobSchedulesRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return JobSchedules::class;
    }
}