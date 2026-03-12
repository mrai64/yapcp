<?php

namespace App\Policies;

use App\Models\Federation;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class FederationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // view for all
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Federation $federation): bool
    {
        // view for all
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = UserRole::where('user_id', $user->id)
            ->where('role', UserRole::ADMINGROUP)
            ->where('role_opening', '<=', now())
            ->where('role_closing', '>=', now())
            ->exists();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Federation $federation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Federation $federation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Federation $federation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Federation $federation): bool
    {
        return false;
    }
}
