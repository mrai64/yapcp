<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // admin can view all
        Log::info('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        return $evaluate;
    }

    /**
     * Determine whether the user can view the model.
     *
     * user herself / himself and admin
     */
    public function view(User $user, ?User $model = null): bool
    {
        // admin can view
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        if ($evaluate) {
            return true;
        }
        // user herself / himself
        $userId = $model?->id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userId);
        if ($userId === $user->id) {
            return true;
        }
        // other cannot
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * not used
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * user herself / himself and admin
     */
    public function update(User $user, ?User $model = null): bool
    {
        // admin can view
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $evaluate = $user->isAdmin();
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' evaluated:' . $evaluate);
        if ($evaluate) {
            return true;
        }
        // user herself / himself
        $userId = $model?->id;
        Log::info('Policy: ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' id:' . $userId);
        if ($userId === $user->id) {
            return true;
        }
        // other cannot
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * user herself / himself and admin
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
