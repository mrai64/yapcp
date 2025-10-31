<?php
/**
 * Contest Jury Votes
 * 
 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class ContestVote extends Model
{
    use SoftDeletes;
    public const table_name = 'contest_vote';
    // public $primaryKey 'id'
    // protected $keyType = unsigned int
    // public $incrementing = true 

    protected $fillable = [
        // id
        'contest_id', // uuid fk
        'section_id', // uuid fk
        'work_id', //    uuid fk
        'juror_user_id', // uuid fk
        'vote', //       varchar(255)
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS 
    public static function voted_ids(string $contest_id, string $section_id)
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $vote_ids = self::where('section_id', $section_id)->where('contest_id', $contest_id)->get(['work_id']);

        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' vote_ids:' . json_encode($vote_ids) );
        return $vote_ids;

    }

    public static function section_vote_board(string $contest_id, string $section_id)
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $vote_board = self::where('section_id', $section_id)->where('contest_id', $contest_id)->orderBy('vote', 'desc')->orderBy('updated_at', 'desc')->get(['work_id', 'vote', 'id']);

        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' vote_board:' . json_encode($vote_board) );
        return $vote_board;

    }

    // RELATIONSHIPs
    public function contest()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $contest = $this->hasOne(Contest::class, 'id',             'contest_id');
        // . . . . . . . . . . . . . . . .contest.id  contest_works.contest_id
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' contest_section:' . json_encode($contest) );
        return $contest;
    }

    public function contest_section()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' section_id:' . json_encode($this->section_id));
        $contest_section = $this->hasOne(ContestSection::class, 'id',             'section_id');
        // . . . . . . . . . . . . . . .contest_sections.id  contest_works.section_id
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' contest_section:' . json_encode($contest_section));
        return $contest_section;
    }

    public function work() 
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $work = $this->belongsTo(Work::class);
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' work:' . json_encode($work));
        return $work;
    }
    
    public function user_contact()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $user_contact = $this->hasOne(UserContact::class, 'user_id',               'user_id');
        // . . . . . . . . . . . . . . . . . user_contacts.user_id    contest_works.user_id
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' user_contact:' . json_encode($user_contact) );
        return $user_contact;

    }

}
