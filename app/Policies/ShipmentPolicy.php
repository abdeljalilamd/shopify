<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shipment can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shipments');
    }

    /**
     * Determine whether the shipment can view the model.
     */
    public function view(User $user, Shipment $model): bool
    {
        return $user->hasPermissionTo('view shipments');
    }

    /**
     * Determine whether the shipment can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shipments');
    }

    /**
     * Determine whether the shipment can update the model.
     */
    public function update(User $user, Shipment $model): bool
    {
        return $user->hasPermissionTo('update shipments');
    }

    /**
     * Determine whether the shipment can delete the model.
     */
    public function delete(User $user, Shipment $model): bool
    {
        return $user->hasPermissionTo('delete shipments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shipments');
    }

    /**
     * Determine whether the shipment can restore the model.
     */
    public function restore(User $user, Shipment $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shipment can permanently delete the model.
     */
    public function forceDelete(User $user, Shipment $model): bool
    {
        return false;
    }
}
