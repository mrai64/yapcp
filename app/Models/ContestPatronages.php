<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Database\Factories\ContestPatronagesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages query()
 * @property int $id
 * @property string $contest_id fk for contests id
 * @property string $federation_id fk federations id
 * @property string $patronage_code
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages whereFederationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages wherePatronageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestPatronages whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContestPatronages extends Model
{
    /** @use HasFactory<\Database\Factories\ContestPatronagesFactory> */
    use HasFactory;
}
