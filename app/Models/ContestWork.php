<?php

/**
 * Contest Works reunite all works participating to all section of all contests,
 * and register a is_admit Y/N result. Prizes and HM are in contest Awards.
 *
 * related to Contest
 * related to ContestSection
 * related to Country
 * related to userContact
 * related to Work
 * related to ContestWaiting
 * related to ContestVote
 * related to ContestAward
 *
 * 2025-10-21 Added portfolio_sequence, 0..255
 * 2026-01-21 PSR-12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // //dbg Log::info
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; //         pk uuid

class ContestWork extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contest_works';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    // field list fillable in factory
    protected $fillable = [
        'id', //              pk uuid
        'contest_id', //      fk contests.id
        'section_id', //      fk contest_sections.id
        'country_id', //      fk countries.id
        'user_id', //         fk user_contacts.user_id
        'work_id', //         fk works.id
        'is_admit', //        0 false 1 true
        'portfolio_sequence', // 1..contest_sections.rule_max
        // created_at         reserved
        // updated_at         reserved
        // deleted_at         reserved
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

    // GETTERS

    /**
     * Get a miniature file relate to full-size by a
     * '300px_' filename prefix, if present. The same filename otherwise.
     *
     * @return string miniature|original
     *
     */
    public function miniature(string $originalFileName = ''): string
    {
        // default for contest based on
        if ($originalFileName === '') {
            $originalFileName = $this->contest_id.'/'.$this->section_id.'/300px_'.$this->work_id.$this->extension;
        }
        $lastSlashPos = strrpos($originalFileName, '/');
        $path = substr($originalFileName, 0, $lastSlashPos + 1);
        $miniatureFileName = '300px_'.substr($originalFileName, $lastSlashPos + 1);

        if (Storage::disk('public')->exists('contests/'.$path.$miniatureFileName)) {
            // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' found');

            return $path.$miniatureFileName;
        }
        // otherwise
        return $originalFileName;
    }

    // was: count_works_for_section_user
    public static function sectionWorksCounter(string $sectionId, string $userId): string
    {
        $count = self::where('user_id', $userId)->where('section_id', $sectionId)->count();
        return $count;
    }

    // was: get_user_for_contest_work
    public static function userWorksCounter(string $contestId, string $workId): string
    {
        $participant = self::where('contest_id', $contestId)->where('work_id', $workId)->get('id');
        // log
        $participantId = (count($participant)) ? $participant[0]['id'] : '';
        // log
        return $participantId;
    }

    // RELATIONSHIP

    // contest_works.contest_id > contests.id
    public function contest()
    {
        $contest = $this->belongsTo(Contest::class);
        // log
        return $contest;
    }

    // was: contest_section
    // contest_works.section_id > contest_sections.id
    public function contestSection()
    {
        $section = $this->belongsTo(ContestSection::class, 'section_id');
        // log
        return $section;
    }

    // contest_works.country_id > user_contacts.country_id
    // contest_works.country_id > countries.id
    public function country()
    {
        $country = $this->belongsTo(Country::class, 'id', 'country_id');
        // log
        return $country;
    }

    // participant user
    // contest_works.user_id > user_contacts.user_id
    public function author()
    {
        $userContact = $this->belongsTo(UserContact::class, 'user_id', 'user_id');

        return $userContact;
    }

    // contest_works.work_id > works.id
    // contest_works.work_id > contest_awards.winner_work_id
    // w/contest_works.section_id = contest_awards.section_id
    public function award()
    {
        $awardReceived = $this->hasMany(ContestAward::class, 'winner_work_id', 'work_id')
            ->where('section_id', $this->section_id);

        return $awardReceived;
    }

    /**
     * Relation contest_works >> contest_sections
     *
     * @return ContestSection contest_works.section_id contest_sections.id
     */
    public function section()
    {
        $section = $this->belongsTo(ContestSection::class, 'section_id');

        return $section;
    }

    /**
     * relation user_works >> user_contacts
     *
     * @return UserContact contest_works.user_id user_contacts.user_id (actually not pk)
     */
    // was: user_contact
    public function userContact()
    {
        $contact = $this->hasOne(UserContact::class, 'user_id', 'user_id');

        return $contact;
    }


    // contest_works.work_id fk works.id
    public function work()
    {
        $work = $this->belongsTo(Work::class, 'work_id');

        return $work;
    }
}
