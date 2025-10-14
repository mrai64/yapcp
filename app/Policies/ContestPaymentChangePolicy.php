<?php
/**
 * first policy class
 *
 * To modify fee_payment_completed
 * - TODO if contest_participants.user_id === Auth::id()
 *   uploading receipt pdf
 * - if Auth::id() in (organization_id > contest_participants.contest_id)
 * 
 * used in: 
 * define /app/Providers/AppServiceProvider 
 * @can   /resources/views/livewire/contest/participant/modify.blade.php 
 * 
 */
namespace App\Policies;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use \Carbon\CarbonImmutable;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ContestPaymentChangePolicy
{
    public Contest      $contest;
    public              $deadline;
    public Organization $organization;
    public              $today;
    public string       $user_id;
    public              $user_role;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
    }
    /**
     * Determine if contest_participant should be updated by (...)
     * Request by gate::inspect
     * 
     * @param User $user online user auth::id
     * @param ContestParticipant $contest_participant
     */
    public function update(User $user, ContestParticipant $contest_participant): Response
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' user:' . json_encode($user));
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' participant:' . json_encode($contest_participant));

        $this->contest = Contest::where('id', $contest_participant->contest_id )->get()[0]; // out -> | [] ?
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' contest:' . json_encode($this->contest));
        if (!isset($this->contest->id)){
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ko 2');
            return Response::deny( __("You do not modify that record") );
        }

     // $this->today = CarbonImmutable::now();
     // $this->deadline = CarbonImmutable::parse( $this->contest->day_3_jury_opening);
     // Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' today vs deadline: '. json_encode($this->today).' vs '.json_encode($this->deadline));
     // if ($this->today >= $this->contest->day_3_jury_opening) {
     //     Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ko 3');
     //     return Response::deny( __("You do not modify that record") );
     // }

        if ($user->id === $contest_participant->user_id ){
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ok 1');
            return Response::allow();
        }

        $this->organization = Organization::where('id', $this->contest->organization_id)->get()[0];
        if (!isset($this->organization->id)){
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ko 4');
            return Response::deny( __("You do not modify that record") );
        }

        $this->user_role = UserRole::where('user_id', $user->id)->whereNull('federation_id')
            ->whereNot('role', 'juror')->get();
        if (count($this->user_role) < 1){
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ko 5');
            return Response::deny( __("You do not modify that record") );
        }

        $user_role_collection = collect($this->user_role);
        if ($user_role_collection->contains('organization_id', '=', $this->contest->organization_id)) {
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ok 6');
            return Response::allow();
        }
        if ($user_role_collection->contains('contest_id', '=', $this->contest->id)) {
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ok 7');
            return Response::allow();
        }

        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ko 8 - exit');
        return Response::deny( __("You do not modify that record") );
    }
}
