<?php

/**
 * ContestPatronage define the list of almost one Federation
 *   sponsoring a contest, with its code
 *
 * !!! it's ContestPatronage! not ContestPatronage, ContestPatronage.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @method static \Database\Factories\ContestPatronageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage query()
 * @property int $id
 * @property string $contest_id fk for contests id
 * @property string $federation_id fk federations id
 * @property string $patronage_code
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage whereFederationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage wherePatronageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronage withoutTrashed()
 * @mixin \Eloquent
 */

class ContestPatronage extends Model
{
    /** @use HasFactory<\Database\Factories\ContestPatronageFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'contest_id',
        'federation_id',
        'patronage_code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'contest_id' => 'string', // fk contests.id
            'federation_id' => 'string', // fk federations.id
            'patronage_code' => 'string', // text
            //
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // RELATIONS
    public function contest(): BelongsTo
    {
        $contest = $this->belongsTo(Contest::class);
        // Log
        return $contest;
    }
    public function federation(): BelongsTo
    {
        $federation = $this->belongsTo(Federation::class);
        // Log
        return $federation;
    }
}
