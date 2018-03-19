<?php

namespace  App\Api\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show()
    {
        return $this->response->error('This is an error.', 404);
    }
}
