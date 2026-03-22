<?php

namespace App\Policies;

use App\Models\Federation;
use App\Models\User;
use App\Models\UserRole;

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
        $evaluate = UserRole::isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can update the model.
     *
     * TODO Modify federation can cause mistake on running contest,
     * TODO add some check that there is no running contest
     */
    public function update(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * TODO Cannot remove federation with contest sponsored running
     * TODO check there is no running contest sponsored by federation id.
     */
    public function delete(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can backup the model
     */
    public function backuppable(User $user, Federation $federation): bool
    {
        // for all federation - only for user in admin group
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = UserRole::isAdmin();
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }
}
