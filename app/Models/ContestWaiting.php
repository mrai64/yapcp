<?php

/**
 * Contest Waiting
 * Works Parked away from contest
 * "wait a moment: that work had a problem, solve"
 *
 * related to Contest
 * related to ContestSection
 * related to UserWork
 * related to UserContact participant
 * related to UserContact examiner
 *
 * 2026-01-18 PSR-12
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property string $id real pk: contest_work_id
 * @property string $contest_id fk: contests.id
 * @property string $section_id fk: contest_sections.id
 * @property string $user_work_id fk: user_works.id
 * @property int $portfolio_sequence to ripristinate original record
 * @property string $participant_user_id fk: user_contacts.id author
 * @property string $email for notification
 * @property string $locked_by_user_id fk: user_works.id organization member
 * @property string $locked_because why that work is out
 * @property string|null $resolved_by_user_id fk: user_works.id organization member
 * @property string|null $resolved_because why that work is in
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Contest|null $contest
 * @property-read \App\Models\ContestSection|null $contestSection
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\UserContact|null $organizationLocker
 * @property-read \App\Models\UserContact|null $organizationResolver
 * @property-read \App\Models\UserContact|null $participantUser
 * @property-read \App\Models\UserWork|null $userWork
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereLockedBecause($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereLockedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereParticipantUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting wherePortfolioSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereResolvedBecause($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereResolvedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting whereUserWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestWaiting withoutTrashed()
 * @mixin \Eloquent
 */
class ContestWaiting extends Model
{
    use Notifiable;
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'contest_waitings';

    // field list
    protected $fillable = [
        'id', //                   pk uuid
        'contest_id', //           fk contests.id
        'section_id', //           fk contest_sections.id
        'participant_user_id', //  fk user_contacts.user_id
        'user_work_id', //              fk user_works.work_id
        'portfolio_sequence', //   1..contest_sections.max_works
        'email', //                user_contacts.email of participant
        'locked_by_user_id', //    fk user_contacts.user_id
        'locked_because', //       warning text
        'resolved_by_user_id', //  fk user_contacts.user_id
        'resolved_because', //     solution text
        // created_at              reserved
        // updated_at              reserved
        // deleted_at              reserved
    ];

    // generate id only when uuid is miss
    public function newUniqueId(): string
    {
        return (string) Str::uuid7();
    }

    protected function casts()
    {
        return [
            'id' => 'string',
            'contest_id' => 'string',
            'section_id' => 'string',
            'participant_user_id' => 'string',
            'user_work_id' => 'string',
            'portfolio_sequence' => 'int',
            'email' => 'string',
            'locked_by_user_id' => 'string',
            'locked_because' => 'string',
            'resolved_by_user_id' => 'string',
            'resolved_because' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER

    // RELATIONSHIPS

    // contest_waitings.contest_id > contests.id
    public function contest()
    {
        $contest = $this->hasOne(
            Contest::class, //  ext class
            'id', //            ext contests.id
            'contest_id' //     int contest_waitings.contest_id
        );

        return $contest;
    }

    // contest_waitings.section_id > contest_sections.id
    public function contestSection()
    {
        $section = $this->hasOne(
            ContestSection::class, //  ext class
            'id', //                   ext contes_sections.id
            'section_id' //            int contest_waitings.section_id
        );
        return $section;
    }

    // contest_waitings.work_id > user_contacts.id
    public function userWork()
    {
        $work = $this->hasOne(
            UserWork::class, //  ext class
            'id', //             ext user_works.id
            'user_work_id' //    int contest_waitings.user_work_id
        );
        return $work;
    }

    // was: participant_user
    // contest_waitings.participant_user_id > user_contacts.id
    public function participantUser()
    {
        $participant = $this->hasOne(
            related: UserContact::class, //     ext class
            foreignKey: 'id', //                ext user_contacts.id
            localKey: 'participant_user_id' //  int contest_waitings.participant_user_id
        );
        return $participant;
    }
    // contest_waitings.organization_user_id > user_contacts.id
    public function organizationLocker()
    {
        $userContact = $this->belongsTo(
            related: UserContact::class, //      ext class
            foreignKey: 'id', //                 ext user_contacts.id
            ownerKey: 'locked_by_user_id' //  int contest_waitings.organization_user_id
        );
        return $userContact;
    }
    //
    public function organizationResolver()
    {
        $userContact = $this->belongsTo(
            related: UserContact::class, //      ext class
            foreignKey: 'id', //                 ext user_contacts.id
            ownerKey: 'recolved_by_user_id' //  int contest_waitings.organization_user_id
        );
        return $userContact;
    }
}
