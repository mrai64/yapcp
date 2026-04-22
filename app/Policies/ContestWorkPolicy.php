<?php

namespace App\Policies;

use App\Models\ContestWork;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContestWorkPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * admin can
     */
    public function viewAny(User $user): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // admin can
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        // other cannot
        return $evaluate;
    }

    /**
     * Determine whether the user can view the model.
     *
     * admin can
     * user herself / himself can
     */
    public function view(User $user, ContestWork $contestWork): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // user herself / himself can
        $userContestId = $contestWork->user_id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userContestId);
        if ($userContestId === $user->id) {
            return true;
        }
        // admin can
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        // other cannot
        return $evaluate;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // user herself / himself can
        $evaluate = ($user->id == Auth::id());
        // other cannot
        return $evaluate;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContestWork $contestWork): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // user herself / himself can
        $userContestId = $contestWork->user_id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userContestId);
        if ($userContestId === $user->id) {
            return true;
        }
        // admin can
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        if ($evaluate) {
            return true;
        }
        // organization members can
        $organizationId = $contestWork->contest->organization_id;
        $evaluate = $user->isMemberOfOrganization($organizationId);
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        // other cannot
        return $evaluate;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContestWork $contestWork): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // user herself / himself
        $userContestId = $contestWork->user_id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userContestId);
        $evaluate = ($userContestId === $user->id);
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        // other cannot
        return $evaluate;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContestWork $contestWork): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContestWork $contestWork): bool
    {
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        return false;
    }
}
