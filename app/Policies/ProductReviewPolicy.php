<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productReview can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list productreviews');
    }

    /**
     * Determine whether the productReview can view the model.
     */
    public function view(User $user, ProductReview $model): bool
    {
        return $user->hasPermissionTo('view productreviews');
    }

    /**
     * Determine whether the productReview can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create productreviews');
    }

    /**
     * Determine whether the productReview can update the model.
     */
    public function update(User $user, ProductReview $model): bool
    {
        return $user->hasPermissionTo('update productreviews');
    }

    /**
     * Determine whether the productReview can delete the model.
     */
    public function delete(User $user, ProductReview $model): bool
    {
        return $user->hasPermissionTo('delete productreviews');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete productreviews');
    }

    /**
     * Determine whether the productReview can restore the model.
     */
    public function restore(User $user, ProductReview $model): bool
    {
        return false;
    }

    /**
     * Determine whether the productReview can permanently delete the model.
     */
    public function forceDelete(User $user, ProductReview $model): bool
    {
        return false;
    }
}
