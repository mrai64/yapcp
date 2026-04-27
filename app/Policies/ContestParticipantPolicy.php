<?php

namespace App\Policies;

use App\Models\ContestParticipant;
use App\Models\User;

class ContestParticipantPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * all can
     *
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * admin can
     * organization member can
     * participant itself can
     * others no
     *
     */
    public function view(User $user, ContestParticipant $contestParticipant): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMemberOfOrganization($contestParticipant->contest->organization_id)) {
            return true;
        }

        if ($user->id === $contestParticipant->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * participant itself can
     *
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * admin can
     * organization member can
     * participant itself can
     * others no
     *
     */
    public function update(User $user, ContestParticipant $contestParticipant): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMemberOfOrganization($contestParticipant->contest->organization_id)) {
            return true;
        }

        if ($user->id === $contestParticipant->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContestParticipant $contestParticipant): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isMemberOfOrganization($contestParticipant->contest->organization_id)) {
            return true;
        }

        if ($user->id === $contestParticipant->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContestParticipant $contestParticipant): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContestParticipant $contestParticipant): bool
    {
        return false;
    }
}
