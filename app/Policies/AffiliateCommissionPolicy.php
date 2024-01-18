<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AffiliateCommission;
use Illuminate\Auth\Access\HandlesAuthorization;

class AffiliateCommissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the affiliateCommission can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list affiliatecommissions');
    }

    /**
     * Determine whether the affiliateCommission can view the model.
     */
    public function view(User $user, AffiliateCommission $model): bool
    {
        return $user->hasPermissionTo('view affiliatecommissions');
    }

    /**
     * Determine whether the affiliateCommission can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create affiliatecommissions');
    }

    /**
     * Determine whether the affiliateCommission can update the model.
     */
    public function update(User $user, AffiliateCommission $model): bool
    {
        return $user->hasPermissionTo('update affiliatecommissions');
    }

    /**
     * Determine whether the affiliateCommission can delete the model.
     */
    public function delete(User $user, AffiliateCommission $model): bool
    {
        return $user->hasPermissionTo('delete affiliatecommissions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete affiliatecommissions');
    }

    /**
     * Determine whether the affiliateCommission can restore the model.
     */
    public function restore(User $user, AffiliateCommission $model): bool
    {
        return false;
    }

    /**
     * Determine whether the affiliateCommission can permanently delete the model.
     */
    public function forceDelete(User $user, AffiliateCommission $model): bool
    {
        return false;
    }
}
