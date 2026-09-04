<?php

namespace App\Policies;

use App\Models\Federation;
use App\Models\User;
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
        // for all federation - view for all
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * TODO federation secretary can
     */
    public function create(User $user): bool
    {
        // for all federation - only for user in admin group
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can update the model.
     *
     */
    public function update(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = (bool) $user->isAdmin();
        return $evaluate;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * Must be both
     * - user is admin
     * - zero running contest sponsored by federation
     */
    public function delete(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $userNotAdmin = !($user->isAdmin());
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' user not admin:' . $userNotAdmin);
        if ($userNotAdmin) {
            return false;
        }
        //
        $zeroContestActive = !($federation->activeContests()->exists());
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' zero contest active:' . $zeroContestActive);
        return $zeroContestActive;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can backup the model
     *
     * admin can
     */
    public function backuppable(User $user, Federation $federation): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__
            . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__
            . ' evaluated:' . $evaluate);
        return $evaluate;
    }
}
