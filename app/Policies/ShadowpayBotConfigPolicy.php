<?php

namespace App\Policies;

use App\Models\ShadowpayBotConfig;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpayBotConfigPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ShadowpayBotConfig $config): bool
    {
        return $user->id == $config->user_id;
    }

    public function update(User $user, ShadowpayBotConfig $config): bool
    {
        return $user->id == $config->user_id;
    }

    public function delete(User $user, ShadowpayBotConfig $config): bool
    {
        return $user->id == $config->user_id;
    }
}
