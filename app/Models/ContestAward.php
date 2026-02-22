<?php

/**
 * ContestAward define the award list for section(s),
 * and contest, using a filled/empty section_code.
 *
 * is_award mean that some prize are A prize, i.e. valid for some federations distinctions, others are "simple" prize.
 *
 * 2025-12-05 Log
 * 2026-01-17 PSR-12
 *
 * related to Contest
 * related to ContestSection
 * related to ContestWork
 * related to UserContact
 * related to Work
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @property string $id uuid assigned
 * @property string $contest_id fk: contests.id 1:N
 * @property string|null $section_id fk: contest_section.id
 * @property string|null $section_code from: section.id->code
 * @property string $award_code free but unique in contest
 * @property string $award_name free
 * @property string $is_award N/Y flag, Y=award prize, N=HM or other
 * @property string|null $winner_work_id fk: works.id
 * @property string|null $winner_user_id fk: users.id user_contacts.user_id
 * @property string $winner_name winner not in previous cols
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Contest $contest
 * @property-read \App\Models\ContestSection|null $section
 * @property-read \App\Models\UserContact|null $userContact
 * @property-read \App\Models\UserWork|null $work
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereAwardCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereAwardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereIsAward($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereSectionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereWinnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereWinnerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward whereWinnerWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestAward withoutTrashed()
 * @property-read \App\Models\ContestWork|null $contestWork
 * @mixin \Eloquent
 */

final class ContestAward extends Model
{
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'contest_awards';

    // primary key
    protected $primaryKey = 'id'; //  default, but 'real' pk is contest_id.award_code
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    // field list
    protected $fillable = [
        // id             pk uuid
        'contest_id', //  fk contests.id
        'section_id', //  fk contest_sections.id
        'section_code', //   contest_sections.code w/section_id
        'award_code', //     unique in contest sortable code first - major, last - minor
        'award_name', //     text
        'is_award', //       Prize <> HM
        'winner_work_id', // nullable
        'winner_user_id', // nullable
        'winner_name', //    nullable
        // created_at        reserved
        // updated_at        reserved
        // deleted_at        reserved
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // is_award as enum set, no boolean
    private const VALID_YN = [
        'N', // 0 false
        'Y', // 1 true
    ];

    // pk is uuid
    public static function booted()
    {
        //dbg Log::info('Model ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function casts()
    {
        //dbg Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ . ' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // VALIDATORS

    public static function checkIsAward(ContestAward $award): bool
    {
        return in_array(
            needle: $award->is_award, // as table field remain in snake_case
            haystack: self::VALID_YN,
            strict: true
        );
    }

    // GETTERS

    // RELATIONS

    // contest_awards.contest_id > contests.id
    public function contest()
    {
        $contest = $this->belongsTo(Contest::class);
        return $contest;
    }

    // contest_awards.section_id > contest_sections.id
    public function section()
    {
        $section = $this->belongsTo(ContestSection::class);
        return $section;
    }

    // contest_awards.winner_work_id > contest_works.id
    public function contestWork()
    {
        $work = $this->belongsTo(
            ContestWork::class, //  ext class
            'winner_work_id', //    int contest_awards.winner_work_id
            'id' //                 ext contest_works.id
        );
        return $work;
    }

    // contest_awards.winner_work_id > contest_works.id
    // contest_works.user_work_id > user_works.id

    // contest_awards.winner_user_id > user_contacts.user_id
    public function userContact()
    {
        $userContact = $this->belongsTo(
            UserContact::class, //  ext class
            'winner_user_id', //    int contest_awards.winner_user_id
            'id' //                 ext user_contacts.id
        );
        return $userContact;
    }
}
