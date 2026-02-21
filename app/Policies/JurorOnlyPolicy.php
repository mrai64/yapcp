<?php

/**
 * Restrict access to jury member
 */

namespace App\Policies;

use App\Models\ContestJury;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JurorOnlyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        ds('Policies '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
    }

    public function grantAccess(string $section_id): Response
    {
        ds('Policies ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $userId = Auth::id();
        $grantedAccess = ContestJury::where('section_id', $section_id)->where('user_contact_id', $userId)->exists(); // 1 | 0
        ds('Policies ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' res:' . $grantedAccess . ' for user:' . $userId);

        // return ($grantedAccess) ? Response::allow() ? Response::deny(__("Sorry, no"));
        if ($grantedAccess) {
            // log
            return Response::allow();
        }
        // log
        return Response::deny(__("Sorry, no"));
    }
}
