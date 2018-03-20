<?php

namespace App\Auth;

use App\Models\MerchantUser;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class EloquentMerchantUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        return MerchantUser::where('user_name', '=', $credentials['user_name'])
            ->where('user_mobile', '=', $credentials['user_mobile'])->first();
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return true;
    }
}