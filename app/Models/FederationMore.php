<?php

/**
 * Federation More reunite the One More Field
 * that federation ask over the UserContact fields.
 * because a FIAP card_id, a PSA card_id, IAAP id etc.
 *
 * related to Federation
 * related to UserContactMore
 *
 * 2026-01-21 PSR-12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $federation_id fk federations
 * @property string $field_name lowercase
 * @property string $field_label label for the field
 * @property string $field_validation_rules string or function(), validation rules for the field, nullable if none
 * @property string $field_default_value empty string as default default value
 * @property string $field_suggest message to explain what insert
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Federation|null $federation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContactMore> $userMores
 * @property-read int|null $user_mores_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereFederationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereFieldDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereFieldLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereFieldSuggest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereFieldValidationRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore withoutTrashed()
 * @method static \Database\Factories\FederationMoreFactory factory($count = null, $state = [])
 * @property string $referenced_table real pk - lowercase
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationMore whereReferencedTable($value)
 * @mixin \Eloquent
 */
class FederationMore extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'federation_mores';

    protected $fillable = [
        'id', //                     pk standard bigint
        'federation_id', //          fk federations.id
        'referenced_table', //       real pk - lowercase
        'field_name', //             code
        'field_label', //            label
        'field_validation_rules', // use in rules()
        'field_default_value', //    used in report when userContactRole is missing
        'field_suggest', //          plain text how fill field
        // created_at                reserved
        // updated_at                reserved
        // deleted_at                reserved
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'federation_id' => 'string',
            'referenced_table' => 'string',
            'field_name' => 'string',
            'field_label' => 'string',
            'field_validation_rules' => 'string',
            'field_default_value' => 'string',
            'field_suggest' => 'string',
            //
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // RELATIONSHIP

    // federation_mores.federation_id > federations.id
    public function federation(): BelongsTo
    {
        $federation = $this->belongsTo(
            Federation::class,
            'federation_id',
            'id'
        );
        // Log
        return $federation;
    }

    // federation_mores.related_table > federation_mores_related_tables.referenced_table
    // spoiler: no

    // federation_mores.federation_id > user_contact_mores.federation_id
    public function userMores(): HasMany
    {
        $moreFields = $this->hasMany(
            related: UserContactMore::class,
            foreignKey: 'federation_id',
            localKey: 'federation_id'
        );
        // log
        return $moreFields;
    }

    // IS...

    /**
     * Loop over the, few but dynamically listed, referenced_table in
     * federation_mores_referenced_tables to check if "is in use"
     * in the table itself - first true exit true
     */
    public function isInUse(): bool
    {
        // Recuperiamo tutte le tabelle di riferimento registrate
        $referencedTables = FederationMoresReferencedTable::all();

        foreach ($referencedTables as $ref) {
            $dataTable = $ref->referenced_table ?? null;

            if ($dataTable && DB::table($dataTable)
                ->where('federation_id', $this->federation_id)
                ->where('field_name', $this->field_name)
                ->exists()) {
                return true;
            }
        }

        return false;
    }
}
