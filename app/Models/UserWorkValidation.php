<?php

/**
 * The User Work Validation contains
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Database\Factories\UserWorkValidationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation query()
 * @property-read \App\Models\FederationSection|null $federationSection
 * @property-read \App\Models\UserContact|null $userValidator
 * @property-read \App\Models\UserWork|null $work
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation withoutTrashed()
 * @mixin \Eloquent
 */
class UserWorkValidation extends Model
{
    /** @use HasFactory<\Database\Factories\UserWorkValidationFactory> */
    use HasFactory;
    use SoftDeletes;

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', //                     pk bigint autoincrement
        'user_work_id', //           fk user_works.id
        'federation_section_id', //  fk federation_sections.id
        'validator_user_id', //      fk user_contacts.user_id
        // created_at                reserved
        // updated_at                reserved
        // deleted_at                reserved
    ];

    protected function casts()
    {
        return [
            'id' => 'int',
            'user_work_id' => 'string',
            'federation_section_id' => 'string',
            'validator_user_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // RELATIONSHIP


    // work_validations.work_id > user_works.id
    public function work()
    {
        $work = $this->belongsTo(
            related: UserWork::class,
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
