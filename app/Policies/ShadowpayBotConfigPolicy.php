<?php

namespace App\Policies;

use App\Models\ShadowpayBotConfig;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpayBotConfigPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayBotConfig  $shadowpayBotConfig
     * @return mixed
     */
    public function view(User $user, ShadowpayBotConfig $shadowpayBotConfig)
    {
        return $user->id == $shadowpayBotConfig->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayBotConfig  $shadowpayBotConfig
     * @return mixed
     */
    public function update(User $user, ShadowpayBotConfig $shadowpayBotConfig)
    {
        return $user->id == $shadowpayBotConfig->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayBotConfig  $shadowpayBotConfig
     * @return mixed
     */
    public function delete(User $user, ShadowpayBotConfig $shadowpayBotConfig)
    {
        return $user->id == $shadowpayBotConfig->user_id;
    }
}
