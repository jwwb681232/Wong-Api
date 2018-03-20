<?php

namespace App\Api\V1\Controllers\User;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /*public function show()
    {
        return response(['error' => 0], 200);
    }*/

    public function register()
    {
        return response(['a'=>request()->input('a')]);
    }
}
