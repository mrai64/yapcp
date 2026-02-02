<?php

/**
 * ContestParticipants is related to: users. For works in contest
 * see ContestWorks. It stores only the info, updated from
 * Organization, of fee payment completed, a Stop/Go flag for the
 * day before jury works.
 *
 * related to Contest
 * related to UserContact
 *
 * 2025-10-10 created an auxiliary table contest_participants_fee_payment_completes_sets to manage
 *            previously value of valid_YN[]
 * 2025-10-11 add Gates n Policy
 * 2026-01-06 relationship review
 * 1:1 contest_participants.contest_id > contests.id
 * 1:1 contest_participants.user_id > user_contacts.user_id
 *
 * 2026-01-17 PSR-12 instead of snake_case everywhere
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property string $contest_id fk: contests.id
 * @property string $user_id fk: user_contacts.user_id
 * @property string $fee_payment_completed N/Y flag
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\UserContact $contact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContactMore> $contactMores
 * @property-read int|null $contact_mores_count
 * @property-read \App\Models\Contest $contest
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWork> $contestWorks
 * @property-read int|null $contest_works_count
 * @property-read \App\Models\UserContact $userContact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContactMore> $userContactMores
 * @property-read int|null $user_contact_mores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWork> $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant whereFeePaymentCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestParticipant withoutTrashed()
 * @mixin \Eloquent
 */
class ContestParticipant extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contest_participants';

    // default id unsigned bigint autoincrement

    // no boolean
    private const VALID_YN = [
        'N', // 0 false
        'Y', // 1 true
    ];

    // field list fillable in factory
    protected $fillable = [
        'id', //                     pk unsigned bigint a+
        'contest_id', //             fk contests.id
        'user_id', //                fk user_contacts.user_id
        'fee_payment_completed', //  Y/N
        // created_at                reserved
        // updated_at                reserved
        // deleted_at                reserved
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

    // was: get_participant_list
    /**
     * Contest user Participant list (complete, no paginated),
     * sorted by country, last_name, first_name
     *
     * @param string $contestId
     * @return array
     */
    public static function contestParticipantsArray(string $contestId): array
    {
        //dbg Log::infoLog::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        if (Contest::exists($contestId) === false) {
            return [];
        }

        $results = ContestParticipant::query()
            ->leftJoin('pcp_user_contacts', 'pcp_contest_participants.user_id', '=', 'pcp_user_contacts.user_id')
            ->where('contest_id', 'e8ac5674-c3d1-4afa-adaf-a7d5ed82d292')
            ->select([
                'pcp_user_contacts.country_id',
                'pcp_user_contacts.last_name',
                'pcp_user_contacts.first_name',
                'pcp_user_contacts.user_id',
                'pcp_contest_participants.fee_payment_completed'
            ])
            ->orderBy('pcp_user_contacts.country_id')
            ->orderBy('pcp_user_contacts.last_name')
            ->orderBy('pcp_user_contacts.first_name')
            ->orderBy('pcp_user_contacts.user_id')
            ->get();
        // sort array
        $contestParticipantsArray = collect($results)->sortBy(['country_id', 'last_name', 'first_name'])->toArray();

        //dbg Log::infoLog::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' exit contestParticipantsArray:'.json_encode($contestParticipantsArray));

        return $contestParticipantsArray;
    }

    // RELATIONSHIP


    public function contest()
    {
        $contest = $this->belongsTo(
            related: Contest::class,
            foreignKey: 'contest_id', //  contest_participants.contest_id
            ownerKey: 'id' //             contests.id
        );
        return $contest;
    }

    // was: contest_works
    public function contestWorks(): HasMany
    {
        $contestWorks = $this->hasMany(
            ContestWork::class, //
            'user_id', //           contests.user_id
            'user_id' //            contest_works.user_id
        );

        return $contestWorks;
    }

    public function works(): HasMany
    {
        $contestWorks = $this->hasMany(
            ContestWork::class,
            'user_id',
            'user_id'
        );

        return $contestWorks;
    }

    // was: user_contact
    public function userContact()
    {
        $userContact = $this->belongsTo(
            UserContact::class,
            'user_id',
            'user_id'
        );

        return $userContact;
    }

    // doubled as used in query as contact
    public function contact()
    {
        //                     user_contacts.user_id contest_participants.user_id
        $userContact = $this->belongsTo(
            UserContact::class,
            'user_id',
            'user_id'
        );

        return $userContact;
    }

    // was: user_contact_more
    public function userContactMores()
    {
        //                       user_contact_mores.user_contact_user_id contest_participants.user_id
        $userContactMores = $this->hasMany(
            UserContactMore::class,
            'user_id', //              contest_participants.user_id
            'user_contact_user_id' //  user_contact_mores.user_contact_user_id
        );

        return $userContactMores;
    }

    public function contactMores()
    {
        //                       user_contact_mores.user_contact_user_id contest_participants.user_id
        $userContactMores = $this->hasMany(
            UserContactMore::class,
            'user_id',
            'user_contact_user_id'
        );

        return $userContactMores;
    }
}
