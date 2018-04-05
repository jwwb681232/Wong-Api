<?php

namespace App\Api\V1\Repositories;

use App\Models\Industry;
use Prettus\Repository\Eloquent\BaseRepository;
class IndustryRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Industry::class;
    }
}