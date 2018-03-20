<?php

namespace App\Api\V1\Controllers\MerchantUser;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register()
    {
        return response(
            auth()->guard('merchant')->attempt(['user_name' => 'wangxiao', 'user_mobile' => 18871478079])
        );
    }
}
