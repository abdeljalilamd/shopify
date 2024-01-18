<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserActivitie;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserActivitiePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the userActivitie can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list useractivities');
    }

    /**
     * Determine whether the userActivitie can view the model.
     */
    public function view(User $user, UserActivitie $model): bool
    {
        return $user->hasPermissionTo('view useractivities');
    }

    /**
     * Determine whether the userActivitie can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create useractivities');
    }

    /**
     * Determine whether the userActivitie can update the model.
     */
    public function update(User $user, UserActivitie $model): bool
    {
        return $user->hasPermissionTo('update useractivities');
    }

    /**
     * Determine whether the userActivitie can delete the model.
     */
    public function delete(User $user, UserActivitie $model): bool
    {
        return $user->hasPermissionTo('delete useractivities');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete useractivities');
    }

    /**
     * Determine whether the userActivitie can restore the model.
     */
    public function restore(User $user, UserActivitie $model): bool
    {
        return false;
    }

    /**
     * Determine whether the userActivitie can permanently delete the model.
     */
    public function forceDelete(User $user, UserActivitie $model): bool
    {
        return false;
    }
}
