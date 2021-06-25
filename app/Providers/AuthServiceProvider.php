<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('api-create', function(User $user) {
            return $user->tokenCan('api:post');
        });

        Gate::define('api-update', function(User $user) {
            return $user->tokenCan('api:put');
        });

        Gate::define('api-delete', function(User $user) {
            return $user->tokenCan('api:delete');
        });
    }
}
