<?php

namespace App\Policies;

use App\Models\ContestAward;
use App\Models\User;

class ContestAwardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // all
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContestAward $contestAward): bool
    {
        // all
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?Contest $contest = null): bool
    {
        // all
        if ($user->isAdmin()) {
            return true;
        }

        if ($contest && $user->isMemberOfOrganization($contest->organization_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContestAward $contestAward): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($contest && $user->isMemberOfOrganization($contestAward->contest->organization_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContestAward $contestAward): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($contest && $user->isMemberOfOrganization($contestAward->contest->organization_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContestAward $contestAward): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContestAward $contestAward): bool
    {
        return false;
    }
}
