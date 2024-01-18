<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductAttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productAttribute can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productattributes');
    }

    /**
     * Determine whether the productAttribute can view the model.
     */
    public function view(User $user, ProductAttribute $model): bool
    {
        return $user->hasPermissionTo('view productattributes');
    }

    /**
     * Determine whether the productAttribute can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productattributes');
    }

    /**
     * Determine whether the productAttribute can update the model.
     */
    public function update(User $user, ProductAttribute $model): bool
    {
        return $user->hasPermissionTo('update productattributes');
    }

    /**
     * Determine whether the productAttribute can delete the model.
     */
    public function delete(User $user, ProductAttribute $model): bool
    {
        return $user->hasPermissionTo('delete productattributes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productattributes');
    }

    /**
     * Determine whether the productAttribute can restore the model.
     */
    public function restore(User $user, ProductAttribute $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productAttribute can permanently delete the model.
     */
    public function forceDelete(User $user, ProductAttribute $model): bool
    {
        return false;
    }
}
