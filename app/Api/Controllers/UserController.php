<?php

namespace  App\Api\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show()
    {
        return response(['error'=>0],200);
    }
}
