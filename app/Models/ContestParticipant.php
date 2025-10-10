<?php
/**
 * Contest users participants 
 * 
 * 2025-10-10 created an auxiliary table contest_participants_fee_paymen_completes_sets to manage
 *            previously value of valid_YN[]
 * 
 */
namespace App\Models;

use App\Models\UserContact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Log::info

class ContestParticipant extends Model
{
    //
    use HasFactory, SoftDeletes;

    public const table_name = 'contest_participants';

    // fee payment
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
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    // GETTERS
    /**
     * @param $contest_id - uuid fk contests.id
     * @return array<string, string>
     * 
     */
    public static function get_participant_list(string $contest_id) : array
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $participant_list = [];

        $participants = self::where('contest_id', $contest_id)->get();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' found: '.count($participants));
        if (count($participants) < 1) {
            return $participant_list;
        }

        // array_fill
        foreach($participants as $participant) {
            $user_contact = UserContact::where('user_id', $participant->user_id)->get()[0];
            $participant_list[] = [
                // idx
                'country_id' => $user_contact->country_id,
                'last_name'  => $user_contact->last_name,
                'first_name' => $user_contact->first_name,
                // payload
                'fee_payment_completed' => $participant->fee_payment_completed,
                'user_id' => $participant->user_id,
                'contest_id' => $participant->contest_id,
            ];
        }

        // sort array
        $participant_list = collect($participant_list)->sortBy(['country_id', 'last_name', 'first_name'])->toArray();

        return $participant_list;
    }
}
