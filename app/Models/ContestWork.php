<?php

/**
 * Contest Works participant n admitted
 * relation between
 * - works
 *   - user_contact
 *     - country_id
 * - section
 *   - contest
 *
 * field is_admit have a limited-set-of-valid-value
 *
 * relationship
 * belongsTo father table Contest
 * hasOne    auxiliary table set is_admit Y/N true false
 * hasMany   child table jurors votes
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
    use HasFactory, SoftDeletes;

    public const table_name = 'contest_works';

    // pk uuid
    protected $keyType = 'string';

    public $incrementing = false;

    // is_admit
    public const valid_YN = [
        true,
        false,
    ];

    // field list fillable in factory
    protected $fillable = [
        // id - uuid assigned
        'contest_id', // uuid fk
        'section_id', // uuid fk
        'country_id', // char(3)
        'user_id', //    uuid fk
        'work_id', //    uuid fk
        'is_admit', //   true/false as boolean or 1/0 as unsignedTinyInteger
        'portfolio_sequence', // 0..255 as unsignedTinyInteger
        // created_at
        // updated_at
        // deleted_at
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
     * Check if a path/namefile has a twin path/300px_namefile, otherwise
     * pass original file
     *
     * @return string miniature|original
     *
     * TODO id not found pass a [?] mark img
     */
    public function miniature(string $original_file = ''): string
    {
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        if ($original_file === '') {
            $original_file = $this->contest_id.'/'.$this->section_id.'/300px_'.$this->work_id.$this->extension;
        }
        $last_slash_pos = strrpos($original_file, '/');
        $path = substr($original_file, 0, $last_slash_pos + 1);
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' path:'.$path);

        $name_file = '300px_'.substr($original_file, $last_slash_pos + 1);
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' name:'.$name_file);

        if (Storage::disk('public')->exists('contests/'.$path.$name_file)) {
            // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' found');

            return $path.$name_file;
        }
        // dbg Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' not found');

        return $original_file;
    }

    // public function get_participant_list_by_contest_id()
    // public function get_contest_id_list_by_user_id()
    public static function count_works_for_section_user(string $section_id, string $user_id): string
    {
        // dbg Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $count = self::where('user_id', $user_id)->where('section_id', $section_id)->count();
        // dbg Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.$count);

        return $count;
    }

    public static function get_user_for_contest_work(string $contest_id, string $work_id): string
    {
        // dbg Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' in: 1:'.$contest_id.' 2:'.$work_id);
        $participant = self::where('contest_id', $contest_id)->where('work_id', $work_id)->get('id');
        // dbg Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.$participant);

        $participant_id = (count($participant)) ? $participant[0]['id'] : '';
        // dbg Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.$participant_id);

        return $participant_id;
    }

    // RELATIONSHIP

    /**
     * Undocumented function
     *
     * @return UserContact contest_works.user_id user_contacts.user_id
     */
    public function author()
    {
        $user_contact = $this->belongsTo(UserContact::class, 'user_id', 'user_id');

        return $user_contact;
    }

    /**
     * Relation ContestWork >> ContestAward
     *
     * @return ContestAward contest_works.work_id contest_awards.winner_work_id
     *                      where contest_works.section_id = contest_awards.section_id
     */
    public function award()
    {
        $award_ = $this->hasMany(ContestAward::class, 'winner_work_id', 'work_id')
            ->where('section_id', $this->section_id);

        return $award_;
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
    public function contest_section()
    {
        $contest_section = $this->belongsTo(ContestSection::class, 'section_id');

        return $contest_section;
    }

    /**
     * Relation contest_works >> contest_sections
     *
     * @return ContestSection contest_works.section_id contest_sections.id
     */
    public function section()
    {
        $contest_section = $this->belongsTo(ContestSection::class, 'section_id');

        return $contest_section;
    }

    /**
     * relation user_works >> user_contacts
     *
     * @return UserContact contest_works.user_id user_contacts.user_id (actually not pk)
     */
    public function user_contact()
    {
        $user_contact = $this->hasOne(UserContact::class, 'user_id', 'user_id');

        return $user_contact;

    }

    /**
     * Relation contest_works>>contest_votes
     * ! check how is used that relation
     * ! 1 contest_works for 1 section id has one vote for every juror,
     * ! so must be hasMany, not hasOne
     *
     * @return ContestVotes contest_works.work_id 1:1 contest_votes.work_id
     */
    public function contest_vote()
    {
        $contest_votes = $this->hasOne(ContestVote::class, 'work_id', 'work_id')
            ->whereColumn();

        return $contest_votes;

    }

    // contest_works.work_id fk works.id
    public function work()
    {
        $work = $this->belongsTo(Work::class, 'work_id');

        return $work;
    }
}
