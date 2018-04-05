<?php

namespace App\Api\V1\Repositories;

use App\Models\School;
use Prettus\Repository\Eloquent\BaseRepository;
class SchoolRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return School::class;
    }
}