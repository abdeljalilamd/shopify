<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductImage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productImage can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productimages');
    }

    /**
     * Determine whether the productImage can view the model.
     */
    public function view(User $user, ProductImage $model): bool
    {
        return $user->hasPermissionTo('view productimages');
    }

    /**
     * Determine whether the productImage can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productimages');
    }

    /**
     * Determine whether the productImage can update the model.
     */
    public function update(User $user, ProductImage $model): bool
    {
        return $user->hasPermissionTo('update productimages');
    }

    /**
     * Determine whether the productImage can delete the model.
     */
    public function delete(User $user, ProductImage $model): bool
    {
        return $user->hasPermissionTo('delete productimages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productimages');
    }

    /**
     * Determine whether the productImage can restore the model.
     */
    public function restore(User $user, ProductImage $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productImage can permanently delete the model.
     */
    public function forceDelete(User $user, ProductImage $model): bool
    {
        return false;
    }
}
