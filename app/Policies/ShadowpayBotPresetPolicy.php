<?php

namespace App\Policies;

use App\Models\ShadowpayBotPreset;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpayBotPresetPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ShadowpayBotPreset $preset): bool
    {
        return $user->id == $preset->user_id;
    }

    public function update(User $user, ShadowpayBotPreset $preset): bool
    {
        return $user->id == $preset->user_id;
    }

    public function delete(User $user, ShadowpayBotPreset $preset): bool
    {
        return $user->id == $preset->user_id;
    }
}
