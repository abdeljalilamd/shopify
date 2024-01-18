<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CustomerWishlist;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerWishlistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the customerWishlist can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list customerwishlists');
    }

    /**
     * Determine whether the customerWishlist can view the model.
     */
    public function view(User $user, CustomerWishlist $model): bool
    {
        return $user->hasPermissionTo('view customerwishlists');
    }

    /**
     * Determine whether the customerWishlist can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create customerwishlists');
    }

    /**
     * Determine whether the customerWishlist can update the model.
     */
    public function update(User $user, CustomerWishlist $model): bool
    {
        return $user->hasPermissionTo('update customerwishlists');
    }

    /**
     * Determine whether the customerWishlist can delete the model.
     */
    public function delete(User $user, CustomerWishlist $model): bool
    {
        return $user->hasPermissionTo('delete customerwishlists');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete customerwishlists');
    }

    /**
     * Determine whether the customerWishlist can restore the model.
     */
    public function restore(User $user, CustomerWishlist $model): bool
    {
        return false;
    }

    /**
     * Determine whether the customerWishlist can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerWishlist $model): bool
    {
        return false;
    }
}
