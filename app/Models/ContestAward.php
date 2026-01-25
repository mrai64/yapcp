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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContestAward extends Model
{
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

    // contest_awards.winner_work_id > works.id
    public function work()
    {
        $work = $this->belongsTo(Work::class, 'winner_work_id', 'id');
        return $work ?? '';
    }

    // contest_awards.winner_user_id > user_contacts.user_id
    public function userContact()
    {
        $userContact = $this->belongsTo(userContact::class, 'winner_user_id', 'user_id');
        return $userContact ?? '';
    }

}
