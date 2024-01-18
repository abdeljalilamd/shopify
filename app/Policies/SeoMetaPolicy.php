<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SeoMeta;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeoMetaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the seoMeta can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list seometas');
    }

    /**
     * Determine whether the seoMeta can view the model.
     */
    public function view(User $user, SeoMeta $model): bool
    {
        return $user->hasPermissionTo('view seometas');
    }

    /**
     * Determine whether the seoMeta can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create seometas');
    }

    /**
     * Determine whether the seoMeta can update the model.
     */
    public function update(User $user, SeoMeta $model): bool
    {
        return $user->hasPermissionTo('update seometas');
    }

    /**
     * Determine whether the seoMeta can delete the model.
     */
    public function delete(User $user, SeoMeta $model): bool
    {
        return $user->hasPermissionTo('delete seometas');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete seometas');
    }

    /**
     * Determine whether the seoMeta can restore the model.
     */
    public function restore(User $user, SeoMeta $model): bool
    {
        return false;
    }

    /**
     * Determine whether the seoMeta can permanently delete the model.
     */
    public function forceDelete(User $user, SeoMeta $model): bool
    {
        return false;
    }
}
