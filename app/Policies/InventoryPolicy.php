<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Inventory;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the inventory can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list inventories');
    }

    /**
     * Determine whether the inventory can view the model.
     */
    public function view(User $user, Inventory $model): bool
    {
        return $user->hasPermissionTo('view inventories');
    }

    /**
     * Determine whether the inventory can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create inventories');
    }

    /**
     * Determine whether the inventory can update the model.
     */
    public function update(User $user, Inventory $model): bool
    {
        return $user->hasPermissionTo('update inventories');
    }

    /**
     * Determine whether the inventory can delete the model.
     */
    public function delete(User $user, Inventory $model): bool
    {
        return $user->hasPermissionTo('delete inventories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete inventories');
    }

    /**
     * Determine whether the inventory can restore the model.
     */
    public function restore(User $user, Inventory $model): bool
    {
        return false;
    }

    /**
     * Determine whether the inventory can permanently delete the model.
     */
    public function forceDelete(User $user, Inventory $model): bool
    {
        return false;
    }
}
