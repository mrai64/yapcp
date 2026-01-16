<?php

/**
 * Contest (users) participants
 *
 * 2025-10-10 created an auxiliary table contest_participants_fee_payment_completes_sets to manage
 *            previously value of valid_YN[]
 * 2025-10-11 add Gates n Policy
 * 2026-01-06 relationship review
 * 1:1 contest_participants.contest_id > contests.id
 * 1:1 contest_participants.user_id > user_contacts.user_id
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Log::info

class ContestParticipant extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contest_participants';

    // fee payment TODO
    public const valid_YN = [
        'Y',
        'N',
    ];

    // field list fillable in factory
    protected $fillable = [
        // id - unsigned bigint autoincrement assigned
        'contest_id', //            uuid fk
        'user_id', //               uuid fk
        'fee_payment_completed', // in auxiliary table user_participants_fee_payment_completes_sets Y/N
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS
    /**
     * ...order by country, last, first name
     *
     * @param  $contest_id  - uuid fk contests.id
     * @return array<string, string>
     */
    public static function get_participant_list(string $contest_id): array
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        // ! USE RELATIONSHIP
        $participant_list = [];

        $participants = self::where('contest_id', $contest_id)->get();
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' found: '.count($participants));
        if (count($participants) < 1) {
            return $participant_list;
        }

        // array_fill
        foreach ($participants as $participant) {
            $user_contact = UserContact::where('user_id', $participant->user_id)->get()[0];
            $participant_list[] = [
                // idx
                'country_id' => $user_contact->country_id,
                'last_name' => $user_contact->last_name,
                'first_name' => $user_contact->first_name,
                // payload
                'fee_payment_completed' => $participant->fee_payment_completed,
                'user_id' => $participant->user_id,
                'contest_id' => $participant->contest_id,
            ];
        }

        // sort array
        $participant_list = collect($participant_list)->sortBy(['country_id', 'last_name', 'first_name'])->toArray();

        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' exit participant_list:'.json_encode($participant_list));

        return $participant_list;
    }

    // RELATIONSHIP

    public function contest_works()
    {
        //                    contest_works.user_id contest_participants.user_id
        $contest_works = $this->hasMany(ContestWork::class, 'user_id', 'user_id');

        return $contest_works;
    }

    public function works()
    {
        //                    contest_works.user_id contest_participants.user_id
        $contest_works = $this->hasMany(ContestWork::class, 'user_id', 'user_id');

        return $contest_works;
    }

    public function user_contact()
    {
        //                     user_contacts.user_id contest_participants.user_id
        $user_contact = $this->belongsTo(UserContact::class, 'user_id', 'user_id');

        return $user_contact;
    }

    public function contact()
    {
        //                     user_contacts.user_id contest_participants.user_id
        $user_contact = $this->belongsTo(UserContact::class, 'user_id', 'user_id');

        return $user_contact;
    }

    public function user_contact_more()
    {
        //                       user_contact_mores.user_contact_user_id contest_participants.user_id
        $user_contact_more = $this->hasMany(UserContactMore::class, 'user_contact_user_id', 'user_id');

        return $user_contact_more;
    }

    public function contactMores()
    {
        //                       user_contact_mores.user_contact_user_id contest_participants.user_id
        $user_contact_more = $this->hasMany(UserContactMore::class, 'user_contact_user_id', 'user_id');

        return $user_contact_more;
    }
}
