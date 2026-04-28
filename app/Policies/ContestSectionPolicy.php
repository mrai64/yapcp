<?php

namespace App\Policies;

use App\Models\ContestSection;
use App\Models\User;

class ContestSectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContestSection $contestSection): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMemberOfOrganization($contestSection->contest->organization_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContestSection $contestSection): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMemberOfOrganization($contestSection->contest->organization_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContestSection $contestSection): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMemberOfOrganization($contestSection->contest->organization_id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContestSection $contestSection): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContestSection $contestSection): bool
    {
        return false;
    }
}
