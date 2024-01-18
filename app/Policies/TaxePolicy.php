<?php

namespace App\Policies;

use App\Models\Taxe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the taxe can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list taxes');
    }

    /**
     * Determine whether the taxe can view the model.
     */
    public function view(User $user, Taxe $model): bool
    {
        return $user->hasPermissionTo('view taxes');
    }

    /**
     * Determine whether the taxe can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create taxes');
    }

    /**
     * Determine whether the taxe can update the model.
     */
    public function update(User $user, Taxe $model): bool
    {
        return $user->hasPermissionTo('update taxes');
    }

    /**
     * Determine whether the taxe can delete the model.
     */
    public function delete(User $user, Taxe $model): bool
    {
        return $user->hasPermissionTo('delete taxes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete taxes');
    }

    /**
     * Determine whether the taxe can restore the model.
     */
    public function restore(User $user, Taxe $model): bool
    {
        return false;
    }

    /**
     * Determine whether the taxe can permanently delete the model.
     */
    public function forceDelete(User $user, Taxe $model): bool
    {
        return false;
    }
}
