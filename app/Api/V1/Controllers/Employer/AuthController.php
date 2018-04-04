<?php

namespace App\Api\V1\Controllers\Employer;

use App\Models\Admin;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function login()
    {
        $token = auth()->guard('member')->attempt(request()->all());

        $response = ['status' => 'Success', 'data' => $token, 'message' => 'Request Success!'];

        return response($response);
    }
}