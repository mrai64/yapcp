<?php

/**
 * Contest Jury Votes, section by section, work by work
 * 
 * related to Contest
 * related to ContestSection
 * related to Work
 * related to ContestWork
 * related to UserContact
 *
 * 2025-11-18 table_name fix
 * 2026-01-20 PSR-12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class ContestVote extends Model
{
    use SoftDeletes;

    public const TABLENAME = 'contest_votes';

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', //             pk unsigned bigint
        'contest_id', //     fk contests.id
        'section_id', //     fk contest_sections.id
        'work_id', //        fk works.id contest_works.work_id
        'juror_user_id', //  fk user_contact.id
        'vote', //           following contests.vote_rule
        // created_at        reserved
        // updated_at        reserved
        // deleted_at        reserved
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

    // was: voted_ids
    /**
     * Get array of voted contest_works in contest_votes
     *
     * @param string $contestId
     * @param string $sectionId
     * @return array
     */
    public static function votedIds(string $contestId, string $sectionId): array
    {
        $voteIds = self::select(['work_id'])
            ->where('section_id', $sectionId)
            ->where('contest_id', $contestId)
            ->get();

        $arrayIds = array_values(collect($voteIds)->toArray());

        return $arrayIds;

    }

    public static function section_vote_board(string $contestId, string $sectionId)
    {
        Log::info('Model '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $vote_board = self::where('section_id', $sectionId)->where('contest_id', $contestId)->orderBy('vote', 'desc')->orderBy('updated_at', 'desc')->get(['work_id', 'vote', 'id']);

        Log::info('Model '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' vote_board:'.json_encode($vote_board));

        return $vote_board;

    }

    // RELATIONSHIPs

    public function contest()
    {
        $contest = $this->hasOne(Contest::class, 'id', 'contest_id');

        return $contest;
    }

    // was: contest_section
    public function contestSection()
    {
        $contestSection = $this->hasOne(ContestSection::class, 'id', 'section_id');

        return $contestSection;
    }

    public function work()
    {
        $work = $this->belongsTo(Work::class);

        return $work;
    }

    // was: user_contact
    public function userContact()
    {
        $userContact = $this->hasOne(UserContact::class, 'user_id', 'user_id');
        return $userContact;
    }
}
