<?php

namespace App\Policies;

use App\Models\ShadowpaySaleGuardItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpaySaleGuardItemPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ShadowpaySaleGuardItem $item): bool
    {
        return $user->id == $item->user_id;
    }

    public function update(User $user, ShadowpaySaleGuardItem $item): bool
    {
        return $user->id == $item->user_id;
    }

    public function delete(User $user, ShadowpaySaleGuardItem $item): bool
    {
        return $user->id == $item->user_id;
    }
}
