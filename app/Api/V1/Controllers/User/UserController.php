<?php

namespace App\Api\V1\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /*public function show()
    {
        return response(['error' => 0], 200);
    }*/

    public function register()
    {
        echo '<pre>';
        var_dump(auth()->guard('api')->attempt(['user_name' => 'wangxiao', 'user_mobile' => 17671757687]));
        die;
        return response(
            
        );
    }
}
