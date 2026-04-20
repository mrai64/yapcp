<?php

namespace App\Policies;

use App\Models\ContestJury;
use App\Models\User;

class ContestJuryPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * all can
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * all can
     *
     */
    public function view(User $user, ContestJury $contestJury): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * organization members
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContestJury $contestJury): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContestJury $contestJury): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContestJury $contestJury): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContestJury $contestJury): bool
    {
        return false;
    }
}
