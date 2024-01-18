<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductVariant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductVariantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productVariant can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productvariants');
    }

    /**
     * Determine whether the productVariant can view the model.
     */
    public function view(User $user, ProductVariant $model): bool
    {
        return $user->hasPermissionTo('view productvariants');
    }

    /**
     * Determine whether the productVariant can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productvariants');
    }

    /**
     * Determine whether the productVariant can update the model.
     */
    public function update(User $user, ProductVariant $model): bool
    {
        return $user->hasPermissionTo('update productvariants');
    }

    /**
     * Determine whether the productVariant can delete the model.
     */
    public function delete(User $user, ProductVariant $model): bool
    {
        return $user->hasPermissionTo('delete productvariants');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productvariants');
    }

    /**
     * Determine whether the productVariant can restore the model.
     */
    public function restore(User $user, ProductVariant $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productVariant can permanently delete the model.
     */
    public function forceDelete(User $user, ProductVariant $model): bool
    {
        return false;
    }
}
