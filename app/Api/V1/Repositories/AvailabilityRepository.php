<?php

namespace App\Api\V1\Repositories;

use App\Models\Availability;
use Prettus\Repository\Eloquent\BaseRepository;
class AvailabilityRepository extends BaseRepository
{

    public $week
        = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Availability::class;
    }
}