<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShippingMethod;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingMethodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shippingMethod can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shippingmethods');
    }

    /**
     * Determine whether the shippingMethod can view the model.
     */
    public function view(User $user, ShippingMethod $model): bool
    {
        return $user->hasPermissionTo('view shippingmethods');
    }

    /**
     * Determine whether the shippingMethod can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shippingmethods');
    }

    /**
     * Determine whether the shippingMethod can update the model.
     */
    public function update(User $user, ShippingMethod $model): bool
    {
        return $user->hasPermissionTo('update shippingmethods');
    }

    /**
     * Determine whether the shippingMethod can delete the model.
     */
    public function delete(User $user, ShippingMethod $model): bool
    {
        return $user->hasPermissionTo('delete shippingmethods');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shippingmethods');
    }

    /**
     * Determine whether the shippingMethod can restore the model.
     */
    public function restore(User $user, ShippingMethod $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shippingMethod can permanently delete the model.
     */
    public function forceDelete(User $user, ShippingMethod $model): bool
    {
        return false;
    }
}
