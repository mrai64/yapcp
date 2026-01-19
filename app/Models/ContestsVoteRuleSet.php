<?php

/**
 * Contest Vote Rule Set is a lookup table
 * for contests.vote_rule
 *
 * Don't add nor delete record from auxiliary table before made
 * change in ContestVoteRuleRule that decide if vote are valid
 * based on vote_rule value
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestsVoteRuleSet extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contests_vote_rule_sets';

    // primary key
    protected $primaryKey = 'vote_rule'; //  default 'id'
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    // field list
    protected $fillable = [
        'vote_role',
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER

    // RELATIONSHIP
    // contests_vote_rule_sets.vote_rule > contests.vote_rule
    public function contestVoteRule()
    {
        $cvr = $this->hasMany(
            related: Contest::class,
            foreignKey: 'vote_rule',
            localKey: 'vote_rule'
        );
        return $cvr;
    }

}
