<?php

namespace App\Policies;

use App\Models\ShadowpayBotPreset;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpayBotPresetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayBotPreset  $shadowpayBotPreset
     * @return mixed
     */
    public function view(User $user, ShadowpayBotPreset $shadowpayBotPreset)
    {
        return $user->id == $shadowpayBotPreset->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayBotPreset  $shadowpayBotPreset
     * @return mixed
     */
    public function update(User $user, ShadowpayBotPreset $shadowpayBotPreset)
    {
        return $user->id == $shadowpayBotPreset->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayBotPreset  $shadowpayBotPreset
     * @return mixed
     */
    public function delete(User $user, ShadowpayBotPreset $shadowpayBotPreset)
    {
        return $user->id == $shadowpayBotPreset->user_id;
    }
}
