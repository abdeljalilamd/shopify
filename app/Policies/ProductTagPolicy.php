<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productTag can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list producttags');
    }

    /**
     * Determine whether the productTag can view the model.
     */
    public function view(User $user, ProductTag $model): bool
    {
        return $user->hasPermissionTo('view producttags');
    }

    /**
     * Determine whether the productTag can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create producttags');
    }

    /**
     * Determine whether the productTag can update the model.
     */
    public function update(User $user, ProductTag $model): bool
    {
        return $user->hasPermissionTo('update producttags');
    }

    /**
     * Determine whether the productTag can delete the model.
     */
    public function delete(User $user, ProductTag $model): bool
    {
        return $user->hasPermissionTo('delete producttags');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete producttags');
    }

    /**
     * Determine whether the productTag can restore the model.
     */
    public function restore(User $user, ProductTag $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productTag can permanently delete the model.
     */
    public function forceDelete(User $user, ProductTag $model): bool
    {
        return false;
    }
}
