<?php

namespace App\Policies;

use App\Models\ShadowpayFriend;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpayFriendPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ShadowpayFriend $friend): bool
    {
        return $user->id == $friend->user_id;
    }

    public function update(User $user, ShadowpayFriend $friend): bool
    {
        return $user->id == $friend->user_id;
    }

    public function delete(User $user, ShadowpayFriend $friend): bool
    {
        return $user->id == $friend->user_id;
    }
}
