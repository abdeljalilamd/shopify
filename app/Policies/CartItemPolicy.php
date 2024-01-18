<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cartItem can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list cartitems');
    }

    /**
     * Determine whether the cartItem can view the model.
     */
    public function view(User $user, CartItem $model): bool
    {
        return $user->hasPermissionTo('view cartitems');
    }

    /**
     * Determine whether the cartItem can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create cartitems');
    }

    /**
     * Determine whether the cartItem can update the model.
     */
    public function update(User $user, CartItem $model): bool
    {
        return $user->hasPermissionTo('update cartitems');
    }

    /**
     * Determine whether the cartItem can delete the model.
     */
    public function delete(User $user, CartItem $model): bool
    {
        return $user->hasPermissionTo('delete cartitems');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete cartitems');
    }

    /**
     * Determine whether the cartItem can restore the model.
     */
    public function restore(User $user, CartItem $model): bool
    {
        return false;
    }

    /**
     * Determine whether the cartItem can permanently delete the model.
     */
    public function forceDelete(User $user, CartItem $model): bool
    {
        return false;
    }
}
