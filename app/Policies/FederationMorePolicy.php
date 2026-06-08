<?php

namespace App\Policies;

use App\Models\FederationMore;
use App\Models\User;

class FederationMorePolicy
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
    public function view(User $user, FederationMore $federation_more): bool
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
        $evaluate = $user->isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;

        // TODO if not admin, can be a federation member, but that pages are admin-only
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FederationMore $federation_more): bool
    {
        // only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FederationMore $federation_more): bool
    {
        // only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, $federation_more): bool
    {
        // only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, $federation_more): bool
    {
        // only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }
}
