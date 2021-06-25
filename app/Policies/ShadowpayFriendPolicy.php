<?php

namespace App\Policies;

use App\Models\ShadowpayFriend;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpayFriendPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayFriend  $shadowpayFriend
     * @return mixed
     */
    public function view(User $user, ShadowpayFriend $shadowpayFriend)
    {
        return $user->id == $shadowpayFriend->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayFriend  $shadowpayFriend
     * @return mixed
     */
    public function update(User $user, ShadowpayFriend $shadowpayFriend)
    {
        return $user->id == $shadowpayFriend->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpayFriend  $shadowpayFriend
     * @return mixed
     */
    public function delete(User $user, ShadowpayFriend $shadowpayFriend)
    {
        return $user->id == $shadowpayFriend->user_id;
    }
}
