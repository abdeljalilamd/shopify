<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentMethodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the paymentMethod can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list paymentmethods');
    }

    /**
     * Determine whether the paymentMethod can view the model.
     */
    public function view(User $user, PaymentMethod $model): bool
    {
        return $user->hasPermissionTo('view paymentmethods');
    }

    /**
     * Determine whether the paymentMethod can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create paymentmethods');
    }

    /**
     * Determine whether the paymentMethod can update the model.
     */
    public function update(User $user, PaymentMethod $model): bool
    {
        return $user->hasPermissionTo('update paymentmethods');
    }

    /**
     * Determine whether the paymentMethod can delete the model.
     */
    public function delete(User $user, PaymentMethod $model): bool
    {
        return $user->hasPermissionTo('delete paymentmethods');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete paymentmethods');
    }

    /**
     * Determine whether the paymentMethod can restore the model.
     */
    public function restore(User $user, PaymentMethod $model): bool
    {
        return false;
    }

    /**
     * Determine whether the paymentMethod can permanently delete the model.
     */
    public function forceDelete(User $user, PaymentMethod $model): bool
    {
        return false;
    }
}
