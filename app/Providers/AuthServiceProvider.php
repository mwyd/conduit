<?php

namespace App\Providers;

use App\Models\ShadowpayBotConfig;
use App\Models\ShadowpayBotPreset;
use App\Models\ShadowpayFriend;
use App\Models\ShadowpaySaleGuardItem;
use App\Models\User;
use App\Policies\ShadowpayBotConfigPolicy;
use App\Policies\ShadowpayBotPresetPolicy;
use App\Policies\ShadowpayFriendPolicy;
use App\Policies\ShadowpaySaleGuardItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ShadowpayBotConfig::class => ShadowpayBotConfigPolicy::class,
        ShadowpayBotPreset::class => ShadowpayBotPresetPolicy::class,
        ShadowpayFriend::class => ShadowpayFriendPolicy::class,
        ShadowpaySaleGuardItem::class => ShadowpaySaleGuardItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('api-create', fn (User $user) => $user->tokenCan('api:post'));

        Gate::define('api-update', fn (User $user) => $user->tokenCan('api:put'));

        Gate::define('api-delete', fn (User $user) => $user->tokenCan('api:delete'));
    }
}
