<?php
/**
 * auxiliary table to limit contests.vote_rule values
 * 
 * Don't add nor delete record from auxiliary table before made
 * change in ContestVoteRuleRule that decide if vote are valid
 * based on vote_rule value
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class ContestsVoteRuleSet extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey   = 'vote_rule'; // standard name 'id'
    public    $incrementing = false;
    protected $keyType      = 'string';
    protected $fillable = [
        'vote_role',
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts()
    {
        Log::info('Model ' . __CLASS__ .' f:'. __FUNCTION__.' l:' . __LINE__ . ' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER

    // RELATIONSHIP 

    // contests_vote_rule_set.vote_rule <-- 1:1 --> contests.vote_rule

}
