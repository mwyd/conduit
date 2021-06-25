<?php

namespace App\Policies;

use App\Models\ShadowpaySaleGuardItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShadowpaySaleGuardItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpaySaleGuardItem  $shadowpaySaleGuardItem
     * @return mixed
     */
    public function view(User $user, ShadowpaySaleGuardItem $shadowpaySaleGuardItem)
    {
        return $user->id == $shadowpaySaleGuardItem->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpaySaleGuardItem  $shadowpaySaleGuardItem
     * @return mixed
     */
    public function update(User $user, ShadowpaySaleGuardItem $shadowpaySaleGuardItem)
    {
        return $user->id == $shadowpaySaleGuardItem->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShadowpaySaleGuardItem  $shadowpaySaleGuardItem
     * @return mixed
     */
    public function delete(User $user, ShadowpaySaleGuardItem $shadowpaySaleGuardItem)
    {
        return $user->id == $shadowpaySaleGuardItem->user_id;
    }
}