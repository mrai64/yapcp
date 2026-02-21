<?php

/**
 * (User) Work (manual) Validation (log)
 * Even if a work in a section should be validated for some rule
 * in an automatic way, some others are only human validation,
 * that table serve to avoid re-check works already validated.
 *
 * - work_id
 * - federation_section_id
 *
 * 2026-01-22 PSR-12
 *
 * TODO become UserWorkValidation
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property string $work_id fk: works.id
 * @property int $federation_section_id fk: federation_sections.id
 * @property string $validator_user_id fk: user_contacts.user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\FederationSection|null $federationSection
 * @property-read \App\Models\UserContact|null $userValidator
 * @property-read \App\Models\Work|null $work
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation whereFederationSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation whereValidatorUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation whereWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkValidation withoutTrashed()
 * @mixin \Eloquent
 */
class WorkValidation extends Model
{
    use SoftDeletes;

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', //                     pk bigint autoincrement
        'work_id', //                fk works.id
        'federation_section_id', //  fk federation_sections.id
        'validator_user_id', //      fk user_contacts.user_id
        // created_at                reserved
        // updated_at                reserved
        // deleted_at                reserved
    ];

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // RELATIONSHIP


    // work_validations.work_id > works.id
    public function work()
    {
        $work = $this->belongsTo(
            related: Work::class,
            foreignKey: 'user_id',
            ownerKey: 'user_id'
        );
        // log
        return $work;
    }

    // work_validations.federation_section_id > federation_sections.id
    // was federation_section
    public function federationSection()
    {
        $fedSec = $this->belongsTo(
            related: FederationSection::class,
            foreignKey: 'id',
            ownerKey: 'federation_section_id'
        );
        // log
        return $fedSec;
    }

    // work_validations.validator_user_id > user_contacts.user_id
    public function userValidator()
    {
        $uV = $this->belongsTo(
            related: UserContact::class,
            foreignKey: 'user_id',
            ownerKey: 'validator_user_id'
        );
        // log
        return $uV;
    }
}
