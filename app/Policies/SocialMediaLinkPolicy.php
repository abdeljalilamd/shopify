<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SocialMediaLink;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialMediaLinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the socialMediaLink can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list socialmedialinks');
    }

    /**
     * Determine whether the socialMediaLink can view the model.
     */
    public function view(User $user, SocialMediaLink $model): bool
    {
        return $user->hasPermissionTo('view socialmedialinks');
    }

    /**
     * Determine whether the socialMediaLink can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create socialmedialinks');
    }

    /**
     * Determine whether the socialMediaLink can update the model.
     */
    public function update(User $user, SocialMediaLink $model): bool
    {
        return $user->hasPermissionTo('update socialmedialinks');
    }

    /**
     * Determine whether the socialMediaLink can delete the model.
     */
    public function delete(User $user, SocialMediaLink $model): bool
    {
        return $user->hasPermissionTo('delete socialmedialinks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete socialmedialinks');
    }

    /**
     * Determine whether the socialMediaLink can restore the model.
     */
    public function restore(User $user, SocialMediaLink $model): bool
    {
        return false;
    }

    /**
     * Determine whether the socialMediaLink can permanently delete the model.
     */
    public function forceDelete(User $user, SocialMediaLink $model): bool
    {
        return false;
    }
}
