<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SeoSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeoSettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the seoSetting can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list seosettings');
    }

    /**
     * Determine whether the seoSetting can view the model.
     */
    public function view(User $user, SeoSetting $model): bool
    {
        return $user->hasPermissionTo('view seosettings');
    }

    /**
     * Determine whether the seoSetting can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create seosettings');
    }

    /**
     * Determine whether the seoSetting can update the model.
     */
    public function update(User $user, SeoSetting $model): bool
    {
        return $user->hasPermissionTo('update seosettings');
    }

    /**
     * Determine whether the seoSetting can delete the model.
     */
    public function delete(User $user, SeoSetting $model): bool
    {
        return $user->hasPermissionTo('delete seosettings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete seosettings');
    }

    /**
     * Determine whether the seoSetting can restore the model.
     */
    public function restore(User $user, SeoSetting $model): bool
    {
        return false;
    }

    /**
     * Determine whether the seoSetting can permanently delete the model.
     */
    public function forceDelete(User $user, SeoSetting $model): bool
    {
        return false;
    }
}
