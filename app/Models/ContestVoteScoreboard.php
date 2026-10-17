<?php

/**
 * ContestVote Socreboard is the model associated to a VIEW,
 * so it's phisically read-only
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContestVoteScoreboard extends Model
{
    //
    protected $table = 'contest_vote_scoreboards';
    // no id pk
    public $incrementing = false;
    // no softdelete and timestamps
    public $timestamps   = false;

    protected $casts = [
        'total_votes' => 'integer',
    ];

    // RELATIONSHIP
    public function contestWork(): BelongsTo
    {
        return $this->belongsTo(
            ContestWork::class,
            'contest_work_id', // contest_vote_scoreboards.contest_work_id
            'id' //               contest_works.id
        );
    }
    //
    public function contestSection(): BelongsTo
    {
        return $this->belongsTo(
            ContestSection::class,
            'section_id', //       contest_vote_scoreboards.section_id
            'id' //                contest_sections.id
        );
    }
}
