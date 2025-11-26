<?php
/**
 * Restrict access to jury member 
 * 
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
        Log::info('Policies '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
    }
    
    /**
     * @param string $section_id
     * 
     */
    public function grant_access(string $section_id) : Response
    {
        Log::info('Policies '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        $user_id = Auth::id();
        $access_granted = ContestJury::where('section_id', $section_id)->where('user_contact_id', $user_id)->count(); // 1 | 0
        Log::info('Policies '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' res:' . $access_granted . ' for user:'. $user_id);

        if ($access_granted > 0) {
            return Response::allow();
        }

        return Response::deny( __("You can't") );
    }
}
