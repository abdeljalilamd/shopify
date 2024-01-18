<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Discount;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the discount can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list discounts');
    }

    /**
     * Determine whether the discount can view the model.
     */
    public function view(User $user, Discount $model): bool
    {
        return $user->hasPermissionTo('view discounts');
    }

    /**
     * Determine whether the discount can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create discounts');
    }

    /**
     * Determine whether the discount can update the model.
     */
    public function update(User $user, Discount $model): bool
    {
        return $user->hasPermissionTo('update discounts');
    }

    /**
     * Determine whether the discount can delete the model.
     */
    public function delete(User $user, Discount $model): bool
    {
        return $user->hasPermissionTo('delete discounts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete discounts');
    }

    /**
     * Determine whether the discount can restore the model.
     */
    public function restore(User $user, Discount $model): bool
    {
        return false;
    }

    /**
     * Determine whether the discount can permanently delete the model.
     */
    public function forceDelete(User $user, Discount $model): bool
    {
        return false;
    }
}
