<?php

namespace App\Api\V1\Controllers\MerchantUser;

use App\Models\MerchantUser;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register()
    {
        if (MerchantUser::where('user_name', request()->input('user_name'))->first()) {
            $response = ['status' => 'Error', 'message' => 'User Already Exists!'];

            return response($response, 400);
        }

        if ( ! $user = MerchantUser::create(request()->all())) {
            $response = ['status' => 'Error', 'message' => 'Unknown'];

            return response($response, 400);
        }

        $token = auth()->guard('merchant')->attempt(request()->all());

        $response = [
            'status'  => 'Success',
            'data'    => $token,
            'message' => 'Request Success!',
        ];

        return response($response);

    }

    public function login()
    {
        $token = auth()->guard('merchant')->attempt(request()->all());

        $response = ['status' => 'Success', 'data' => $token, 'message' => 'Request Success!'];

        return response($response);
    }
}