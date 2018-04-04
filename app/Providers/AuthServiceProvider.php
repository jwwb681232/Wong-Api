<?php

namespace App\Providers;

use Auth;
use App\Auth\EloquentMemberProvider;
use App\Auth\EloquentEmployerProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
        Auth::provider('EloquentMember', function($app, array $config) {
            return new EloquentMemberProvider($app['hash'], $config['model']);
        });

        Auth::provider('EloquentEmployer', function($app, array $config) {
            return new EloquentEmployerProvider($app['hash'], $config['model']);
        });

        //
    }
}
