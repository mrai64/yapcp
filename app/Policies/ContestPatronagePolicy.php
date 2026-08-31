<?php

/**
 * ContestPatronage is under Contest and reply
 *   all the ContestPolicy methods
 */

namespace App\Policies;

use App\Models\ContestPatronage;
use App\Models\User;

class ContestPatronagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContestPatronage $contestPatronage): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?Contest $contest = null): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        $evaluate = $contest && $contest->organization_id !== null
            && $user->isMemberOfOrganization($contest->organization_id);
        // Log
        return $evaluate;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContestPatronage $contestPatronage): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        $contest = $contestPatronage->contest;
        $evaluate = $contest && $contest->organization_id !== null
            && $user->isMemberOfOrganization($contest->organization_id);
        // Log
        return $evaluate;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContestPatronage $contestPatronage): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        $contest = $contestPatronage->contest;
        $evaluate = $contest && $contest->organization_id !== null
            && $user->isMemberOfOrganization($contest->organization_id);
        // Log
        return $evaluate;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContestPatronage $contestPatronage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContestPatronage $contestPatronage): bool
    {
        return false;
    }
}
