<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailTemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the emailTemplate can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list emailtemplates');
    }

    /**
     * Determine whether the emailTemplate can view the model.
     */
    public function view(User $user, EmailTemplate $model): bool
    {
        return $user->hasPermissionTo('view emailtemplates');
    }

    /**
     * Determine whether the emailTemplate can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create emailtemplates');
    }

    /**
     * Determine whether the emailTemplate can update the model.
     */
    public function update(User $user, EmailTemplate $model): bool
    {
        return $user->hasPermissionTo('update emailtemplates');
    }

    /**
     * Determine whether the emailTemplate can delete the model.
     */
    public function delete(User $user, EmailTemplate $model): bool
    {
        return $user->hasPermissionTo('delete emailtemplates');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete emailtemplates');
    }

    /**
     * Determine whether the emailTemplate can restore the model.
     */
    public function restore(User $user, EmailTemplate $model): bool
    {
        return false;
    }

    /**
     * Determine whether the emailTemplate can permanently delete the model.
     */
    public function forceDelete(User $user, EmailTemplate $model): bool
    {
        return false;
    }
}
