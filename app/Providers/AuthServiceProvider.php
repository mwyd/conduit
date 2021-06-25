<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\ShadowpayBotConfig;
use App\Policies\ShadowpayBotConfigPolicy;
use App\Models\ShadowpayBotPreset;
use App\Policies\ShadowpayBotPresetPolicy;
use App\Models\ShadowpayFriend;
use App\Policies\ShadowpayFriendPolicy;
use App\Models\ShadowpaySaleGuardItem;
use App\Policies\ShadowpaySaleGuardItemPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ShadowpayBotConfig::class       => ShadowpayBotConfigPolicy::class,
        ShadowpayBotPreset::class       => ShadowpayBotPresetPolicy::class,
        ShadowpayFriend::class          => ShadowpayFriendPolicy::class,
        ShadowpaySaleGuardItem::class   => ShadowpaySaleGuardItemPolicy::class
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
