<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Log;

class UserRolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // admin can view all userroles
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can view the model.
     *
     * admin | user can view him/her userRole
     */
    public function view(User $user, ?UserRole $userRole = null): bool
    {
        // admin can view
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        if ($evaluate) {
            return true;
        }
        // user herself / himself
        $userRoleId = $userRole?->user_id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userRoleId);
        if ($userRoleId === $user->id) {
            return true;
        }
        // other cannot
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * user himself/herself | admin | organization (for juror)
     */
    public function create(User $user): bool
    {
        // user herself/himself - from route()
        // organization members for juror list
        // admin
        $evaluate = $user->isAdmin();
        if ($evaluate) {
            return true;
        }
        // other cannot
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserRole $userRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserRole $userRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserRole $userRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserRole $userRole): bool
    {
        return false;
    }
}
