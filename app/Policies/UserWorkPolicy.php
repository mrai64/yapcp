<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use App\Models\UserWork;

class UserWorkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // only admin
        // admin can
        $admin = UserRole::isAdmin();
        if ($admin) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserWork $userWork): bool
    {
        // admin can
        $admin = UserRole::isAdmin();
        if ($admin) {
            return true;
        }
        if ($user->id === $userWork->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // user only
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserWork $userWork): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserWork $userWork): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserWork $userWork): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserWork $userWork): bool
    {
        return true;
    }
}
