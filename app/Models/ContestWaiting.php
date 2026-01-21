<?php

/**
 * Contest Waiting
 * Works Parked away from contest
 * "wait a moment: that work had a problem, solve"
 *
 * related to Contest
 * related to ContestSection
 * related to Work
 * related to UserContact participant
 * related to UserContact examiner
 *
 * 2026-01-18 PSR-12
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class ContestWaiting extends Model
{
    use Notifiable;
    use SoftDeletes;

    public const TABLENAME = 'contest_waitings';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    // field list
    protected $fillable = [
        'id', //                   pk uuid
        'contest_id', //           fk contests.id
        'section_id', //           fk contest_sections.id
        'participant_user_id', //  fk user_contacts.user_id
        'work_id', //              fk contest_works.work_id
        'portfolio_sequence', //   1..contest_sections.rule_max
        'email', //                user_contacts.email of participant
        'because', //              warning text
        'organization_user_id', // fk user_contacts.user_id
        // created_at              reserved
        // updated_at              reserved
        // deleted_at              reserved
    ];

    // pk uuid
    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid7(); // uuid generator
        });
    }

    protected function casts()
    {
        return [
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
        $contest = $this->hasOne(Contest::class, 'id', 'contest_id');
        return $contest;
    }

    // contest_waitings.section_id > contest_sections.id
    public function section()
    {
        $section = $this->hasOne(ContestSection::class, 'id', 'section_id');
        return $section;
    }

    // contest_waitings.work_id > user_contacts.id
    public function work()
    {
        $work = $this->hasOne(Work::class, 'id', 'work_id');
        return $work;
    }

    // was: participant_user
    // contest_waitings.participant_user_id > user_contacts.id
    public function participantUser()
    {
        $participant = $this->hasOne(UserContact::class, 'user_id', 'participant_user_id');
        return $participant;
    }

    // contest_waitings.organization_user_id > user_contacts.id
    public function organizationExaminer()
    {
        $userContact = $this->belongsTo(
            related: UserContact::class,
            foreignKey: 'user_id',
            ownerKey: 'organization_user_id'
        );
        return $userContact;
    }
}
