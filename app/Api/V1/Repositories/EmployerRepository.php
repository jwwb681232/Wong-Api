<?php
namespace App\Api\V1\Repositories;

use App\Models\Employer;
use Prettus\Repository\Eloquent\BaseRepository;

class EmployerRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Employer::class;
    }
}