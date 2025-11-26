<?php
/**
 * Restrict access to Organization members
 * 
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
        Log::info('Policies '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
    }

    /**
     * @param string $organization_id
     * 
     */
    public function grant_access(string $organization_id) : Response
    {
        Log::info('Policies '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        $user_id = Auth::id();

        $access_granted = UserRole::where('organization_id', $organization_id)->where('user_id', $user_id)->count(); // 1 | 0
        Log::info('Policies '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' res:' . $access_granted . ' for user:'. $user_id);

        if ($access_granted > 0) {
            return Response::allow();
        }

        return Response::deny( __("You can't") );

    }
}
