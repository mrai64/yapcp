<?php

/**
 * Restrict access to Organization members
 */

namespace App\Policies;

use App\Models\UserRole;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrganizationMemberOnlyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        Log::info('Policies ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    }

    public function grantAccess(string $organizationId): Response
    {
        Log::info('Policies ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $userId = Auth::id();

        $grantedAccess = UserRole::where('organization_id', $organizationId)->where('user_id', $userId)->exists(); // 1 | 0
        Log::info('Policies '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' res:'.$grantedAccess.' for user:'.$userId);

        if ($grantedAccess) {
            return Response::allow();
        }

        return Response::deny(__("Sorry, no"));

    }
}
