<?php

namespace App\Policies;

use App\Models\Contest;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Log;

class OrganizationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // all can view
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Organization $organization): bool
    {
        // all can view
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // all user can define a new Organization
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organization $organization): bool
    {
        // admin can
        $admin = UserRole::isAdmin();
        if ($admin) {
            return true;
        }
        // check if a userRole is present
        $evaluate = UserRole::whereUserId($user->id)
            ->whereOrganizationId($organization->id)
            ->exists();
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__
            . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * TODO Should be wrong also for admin if contest are running... ?
     *
     */
    public function delete(User $user, Organization $organization): bool
    {
        // admin can
        $admin = UserRole::isAdmin();
        if ($admin) {
            return true;
        }

        // organization member can
        $member = UserRole::whereUserId($user->id)
            ->whereOrganizationId($organization->id)
            ->exists();
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__
            . ' user member:' . $member);
        if (!$member) {
            return false;
        }
        // no contest ended less than a year ago...
        $recentContest = Contest::where('organization_id', $organization->id)
            ->closedAfterOneYearAgo()
            ->exists();
        if (!$recentContest) {
            return true;
        }
        //
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Organization $organization): bool
    {
        // user in admin group
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Organization $organization): bool
    {
        // user in admin group
        return false;
    }
}
