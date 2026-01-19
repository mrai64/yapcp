<?php

/**
 * Contest Works reunite all works participating to contest for any section
 * and register a is_admit Y/N result. Prizes and HM are in contest Awards.
 *
 * related to contests
 * related to contest_sections
 * related to countries
 * related to user_contacts
 * related to works
 * related to contest_waitings?
 * related to contest_votes?
 * related to contest_awards?
 *
 * 2025-10-21 Added portfolio_sequence, 0..255
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
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        if ($originalFileName === '') {
            $originalFileName = $this->contest_id.'/'.$this->section_id.'/300px_'.$this->work_id.$this->extension;
        }
        $lastSlashPos = strrpos($originalFileName, '/');
        $path = substr($originalFileName, 0, $lastSlashPos + 1);
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' path:'.$path);

        $miniatureFileName = '300px_'.substr($originalFileName, $lastSlashPos + 1);
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' name:'.$miniatureFileName);

        if (Storage::disk('public')->exists('contests/'.$path.$miniatureFileName)) {
            // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' found');

            return $path.$miniatureFileName;
        }
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' not found');

        return $originalFileName;
    }

    // was: count_works_for_section_user
    public static function sectionWorksCounter(string $sectionId, string $userId): string
    {
        // dbg Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $count = self::where('user_id', $userId)->where('section_id', $sectionId)->count();
        // dbg Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.$count);

        return $count;
    }

    // was: get_user_for_contest_work
    public static function userWorksCounter(string $contestId, string $workId): string
    {
        $participant = self::where('contest_id', $contestId)->where('work_id', $workId)->get('id');
        $participantId = (count($participant)) ? $participant[0]['id'] : '';
        return $participantId;
    }

    // RELATIONSHIP

    /**
     * Undocumented function
     *
     * @return UserContact contest_works.user_id user_contacts.user_id
     */
    public function author()
    {
        $userContact = $this->belongsTo(UserContact::class, 'user_id', 'user_id');

        return $userContact;
    }

    /**
     * Relation ContestWork >> ContestAward
     *
     * @return ContestAward contest_works.work_id contest_awards.winner_work_id
     *                      where contest_works.section_id = contest_awards.section_id
     */
    public function award()
    {
        $awardReceived = $this->hasMany(ContestAward::class, 'winner_work_id', 'work_id')
            ->where('section_id', $this->section_id);

        return $awardReceived;
    }

    /**
     * Undocumented function
     *
     * @return Contest contest_works.contest_id contests.id
     */
    public function contest()
    {
        $contest = $this->belongsTo(Contest::class);

        return $contest;
    }

    /**
     * Undocumented function
     *
     * @return ContestSection contest_works.section_id contest_sections.id
     */
    // was: contest_section
    public function contestSection()
    {
        $section = $this->belongsTo(ContestSection::class, 'section_id');

        return $section;
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
