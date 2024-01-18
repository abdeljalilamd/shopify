<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ExternalIntegration;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExternalIntegrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the externalIntegration can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list externalintegrations');
    }

    /**
     * Determine whether the externalIntegration can view the model.
     */
    public function view(User $user, ExternalIntegration $model): bool
    {
        return $user->hasPermissionTo('view externalintegrations');
    }

    /**
     * Determine whether the externalIntegration can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create externalintegrations');
    }

    /**
     * Determine whether the externalIntegration can update the model.
     */
    public function update(User $user, ExternalIntegration $model): bool
    {
        return $user->hasPermissionTo('update externalintegrations');
    }

    /**
     * Determine whether the externalIntegration can delete the model.
     */
    public function delete(User $user, ExternalIntegration $model): bool
    {
        return $user->hasPermissionTo('delete externalintegrations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete externalintegrations');
    }

    /**
     * Determine whether the externalIntegration can restore the model.
     */
    public function restore(User $user, ExternalIntegration $model): bool
    {
        return false;
    }

    /**
     * Determine whether the externalIntegration can permanently delete the model.
     */
    public function forceDelete(User $user, ExternalIntegration $model): bool
    {
        return false;
    }
}
