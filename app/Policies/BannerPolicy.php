<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Banner;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the banner can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list banners');
    }

    /**
     * Determine whether the banner can view the model.
     */
    public function view(User $user, Banner $model): bool
    {
        return $user->hasPermissionTo('view banners');
    }

    /**
     * Determine whether the banner can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create banners');
    }

    /**
     * Determine whether the banner can update the model.
     */
    public function update(User $user, Banner $model): bool
    {
        return $user->hasPermissionTo('update banners');
    }

    /**
     * Determine whether the banner can delete the model.
     */
    public function delete(User $user, Banner $model): bool
    {
        return $user->hasPermissionTo('delete banners');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete banners');
    }

    /**
     * Determine whether the banner can restore the model.
     */
    public function restore(User $user, Banner $model): bool
    {
        return false;
    }

    /**
     * Determine whether the banner can permanently delete the model.
     */
    public function forceDelete(User $user, Banner $model): bool
    {
        return false;
    }
}
