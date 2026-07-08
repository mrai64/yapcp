<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id table
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\FederationMoresReferencedSetsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMoresReferencedSets withoutTrashed()
 * @mixin \Eloquent
 */
class FederationMoresReferencedSets extends Model
{
    /** @use HasFactory<\Database\Factories\FederationMoresReferencedSetsFactory> */
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false; // Fondamentale
    protected $keyType = 'string';
}
