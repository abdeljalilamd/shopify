<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Categorie;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the categorie can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list categories');
    }

    /**
     * Determine whether the categorie can view the model.
     */
    public function view(User $user, Categorie $model): bool
    {
        return $user->hasPermissionTo('view categories');
    }

    /**
     * Determine whether the categorie can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create categories');
    }

    /**
     * Determine whether the categorie can update the model.
     */
    public function update(User $user, Categorie $model): bool
    {
        return $user->hasPermissionTo('update categories');
    }

    /**
     * Determine whether the categorie can delete the model.
     */
    public function delete(User $user, Categorie $model): bool
    {
        return $user->hasPermissionTo('delete categories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete categories');
    }

    /**
     * Determine whether the categorie can restore the model.
     */
    public function restore(User $user, Categorie $model): bool
    {
        return false;
    }

    /**
     * Determine whether the categorie can permanently delete the model.
     */
    public function forceDelete(User $user, Categorie $model): bool
    {
        return false;
    }
}
