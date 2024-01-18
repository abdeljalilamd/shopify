<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReturnProdct;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReturnProdctPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the returnProdct can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list returnprodcts');
    }

    /**
     * Determine whether the returnProdct can view the model.
     */
    public function view(User $user, ReturnProdct $model): bool
    {
        return $user->hasPermissionTo('view returnprodcts');
    }

    /**
     * Determine whether the returnProdct can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create returnprodcts');
    }

    /**
     * Determine whether the returnProdct can update the model.
     */
    public function update(User $user, ReturnProdct $model): bool
    {
        return $user->hasPermissionTo('update returnprodcts');
    }

    /**
     * Determine whether the returnProdct can delete the model.
     */
    public function delete(User $user, ReturnProdct $model): bool
    {
        return $user->hasPermissionTo('delete returnprodcts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete returnprodcts');
    }

    /**
     * Determine whether the returnProdct can restore the model.
     */
    public function restore(User $user, ReturnProdct $model): bool
    {
        return false;
    }

    /**
     * Determine whether the returnProdct can permanently delete the model.
     */
    public function forceDelete(User $user, ReturnProdct $model): bool
    {
        return false;
    }
}
