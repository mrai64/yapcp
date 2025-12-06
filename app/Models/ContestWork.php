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
use Illuminate\Support\Facades\Log; // Log::info
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
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        static::creating(function ($model) {
            $model->id = Str::uuid7(); // uuid generator
        });
    }

    protected function casts()
    {
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__.' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS
    /**
     * Miniature path+name
     * img:       name
     * miniature: 300px_name
     */
    public function miniature(): string
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return $this->contest_id.'/'.$this->section_id.'/300px_'.$this->work_id.$this->extension;
    }

    // public function get_participant_list_by_contest_id()
    // public function get_contest_id_list_by_user_id()
    public static function count_works_for_section_user(string $section_id, string $user_id): string
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $count = self::where('user_id', $user_id)->where('section_id', $section_id)->count();
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.$count);

        return $count;
    }

    public static function get_user_for_contest_work(string $contest_id, string $work_id): string
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' in: 1:'.$contest_id.' 2:'.$work_id);
        $participant = self::where('contest_id', $contest_id)->where('work_id', $work_id)->get('id');
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.$participant);
        $participant_id = (count($participant)) ? $participant[0]['id'] : '';
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out:'.$participant_id);

        return $participant_id;
    }

    // RELATIONSHIP

    /**
     * @return Contest works.contest_id 1:1 contests.id
     */
    public function contest()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $contest = $this->hasOne(Contest::class, 'id', 'contest_id');
        // . . . . . . . . . . . . . . . .contest.id  contest_works.contest_id
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest_section:'.json_encode($contest));

        return $contest;
    }

    /**
     * @return ContestSection contest_works.section_id 1:1 contest_sections.id
     */
    public function contest_section()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' section_id:'.json_encode($this->section_id));
        $contest_section = $this->hasOne(ContestSection::class, 'id', 'section_id');
        // . . . . . . . . . . . . . . .contest_sections.id  contest_works.section_id
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest_section:'.json_encode($contest_section));

        return $contest_section;
    }

    /**
     * @return Work works.work_id 1:1 contest_works.work_id
     */
    public function work()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $work = $this->hasOne(Work::class, 'id', 'work_id');
        // . . . . . . . . . . . . . . works.id    contest_works.work_id
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' work:'.json_encode($work));

        return $work;
    }

    /**
     * @return UserContact works.user_id 1:1 user_contacts.user_id
     */
    public function user_contact()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $user_contact = $this->hasOne(UserContact::class, 'user_id', 'user_id');
        // . . . . . . . . . . . . . . . . . user_contacts.user_id    contest_works.user_id
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' user_contact:'.json_encode($user_contact));

        return $user_contact;

    }

    /**
     * @return ContestVote works.work_id 1:1 contest_votes.work_id
     */
    public function contest_vote()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $contest_votes = $this->hasOne(ContestVote::class, 'work_id', 'work_id');
        // . . . . . . . . . . . . . . . . . .contest_votes.work_id    contest_works.work_id
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' user_contact:'.json_encode($contest_votes));

        return $contest_votes;

    }
}
