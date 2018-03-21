<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Auth\EloquentMerchantUserProvider;
use App\Auth\EloquentUserProvider;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Auth::provider('EloquentMerchantUser', function($app, array $config) {
            return new EloquentMerchantUserProvider($app['hash'], $config['model']);
        });
        Auth::provider('EloquentUser', function($app, array $config) {
            return new EloquentUserProvider($app['hash'], $config['model']);
        });
        //
    }
}
