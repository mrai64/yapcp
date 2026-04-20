<?php

namespace App\Policies;

use App\Models\Contest;
use App\Models\Organization;
use App\Models\User;

class ContestPolicy
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
     */
    public function view(User $user, Contest $contest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * an organization member can (no admin)
     */
    public function create(User $user, ?Organization $organization = null): bool
    {
        $evaluate = $user->isMemberOfOrganization($organization);
        // Log
        return $evaluate;
    }

    /**
     * Determine whether the user can update the model.
     *
     * admin: can
     * member of contest organization: can
     */
    public function update(User $user, Contest $contest): bool
    {
        // admin : can
        if ($user->isAdmin()) {
            return true;
        }

        // member of contest organization: can
        $contestOrganizationId = $contest->organization_id;
        $evaluate = $user->isMemberOfOrganization($contestOrganizationId);
        // Log
        return $evaluate;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * Contest are closed, backupped, removed only by admin
     */
    public function delete(User $user, Contest $contest): bool
    {
        $evaluate = $user->isAdmin();
        // Log
        return $evaluate;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contest $contest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contest $contest): bool
    {
        return false;
    }
}
