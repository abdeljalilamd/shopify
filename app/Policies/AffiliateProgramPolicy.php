<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AffiliateProgram;
use Illuminate\Auth\Access\HandlesAuthorization;

class AffiliateProgramPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the affiliateProgram can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list affiliateprograms');
    }

    /**
     * Determine whether the affiliateProgram can view the model.
     */
    public function view(User $user, AffiliateProgram $model): bool
    {
        return $user->hasPermissionTo('view affiliateprograms');
    }

    /**
     * Determine whether the affiliateProgram can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create affiliateprograms');
    }

    /**
     * Determine whether the affiliateProgram can update the model.
     */
    public function update(User $user, AffiliateProgram $model): bool
    {
        return $user->hasPermissionTo('update affiliateprograms');
    }

    /**
     * Determine whether the affiliateProgram can delete the model.
     */
    public function delete(User $user, AffiliateProgram $model): bool
    {
        return $user->hasPermissionTo('delete affiliateprograms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete affiliateprograms');
    }

    /**
     * Determine whether the affiliateProgram can restore the model.
     */
    public function restore(User $user, AffiliateProgram $model): bool
    {
        return false;
    }

    /**
     * Determine whether the affiliateProgram can permanently delete the model.
     */
    public function forceDelete(User $user, AffiliateProgram $model): bool
    {
        return false;
    }
}
