<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users',function($user){
            return $user->type == 1;
        });

        Gate::define('manage-procedures',function($user){
            return ($user->type == 1 || $user->type == 2);
        });

        Gate::define('create-procedures',function($user){
            return $user->type == 1;
        });

        Gate::define('delete-procedures',function($user){
             return $user->type == 1;
        });

        Gate::define('update-full-procedure',function($user){
             return $user->type == 1;
        });    

    }
}
