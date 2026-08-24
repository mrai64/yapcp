<?php

/**
 * Lookup table for federation_mores.referenced field
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id table
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FederationMore> $federationMores
 * @property-read int|null $federation_mores_count
 * @method static \Database\Factories\FederationMoresReferencedSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSet withoutTrashed()
 * @mixin \Eloquent
 */
class FederationMoresReferencedSet extends Model
{
    /** @use HasFactory<\Database\Factories\FederationMoresReferencedSetFactory> */
    use HasFactory;
    use SoftDeletes;

    // 'id' standard but not unsigned bigint auto increment
    protected $keyType = 'string';
    public $incrementing = false;
    //
    protected $fillable = [
        'id',
        // created_at
        // updated_at
        // deleted_at
    ];
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER

    // RELATIONSHIP

    public function federationMores(): HasMany
    {
        $federationMoresSet = $this->hasMany(
            related: FederationMore::class,
            foreignKey: 'referenced', // federation_mores.referenced
            localKey: 'id' // federation_mores_referenced_sets.id
        );
        // Log
        return $federationMoresSet;
    }
}
