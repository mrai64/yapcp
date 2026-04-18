<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use App\Models\UserContact;
use Illuminate\Support\Facades\Log;

class UserContactPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * admin can view the entre list of.
     */
    public function viewAny(User $user): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can view the model.
     *
     * admin | user can view him/her userContact
     */
    public function view(User $user, ?UserContact $userContact = null): bool
    {
        // only for user in admin group
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        if ($evaluate) {
            return true;
        }

        $userContactId = $userContact?->id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userContactId);
        if ($userContactId === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * admin | user himself/herself
     *
     */
    public function update(User $user, ?UserContact $userContact = null): bool
    {
        // only for user in admin group
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        if ($evaluate) {
            return true;
        }

        $userContactId = $userContact?->id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userContactId);
        if ($userContactId === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserContact $userContact): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserContact $userContact): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserContact $userContact): bool
    {
        return false;
    }
}
