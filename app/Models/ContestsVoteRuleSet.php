<?php

/**
 * Contests Vote Rule Set is a lookup table
 * for contests.vote_rule
 * Contests, not Contest, for rule Table+Field+Set
 *
 * related to Contest
 *
 * Don't add nor delete record from that table before made
 * change in ContestVoteRuleRule that decide if vote are valid
 * based on vote_rule value
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $vote_rule
 * @property string|null $synopsis
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contestVoteRule
 * @property-read int|null $contest_vote_rule_count
 * @method static \Database\Factories\ContestsVoteRuleSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet whereSynopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet whereVoteRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestsVoteRuleSet withoutTrashed()
 * @mixin \Eloquent
 */
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
