<?php

/**
 * The User Work Validation contains validation records for user works
 * either linked to a FederationSection or directly to a ContestSection.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id real pk is: user_work_id + federation_section_id
 * @property string $user_work_id fk: user_works.id
 * @property string|null $section_id fk: contest_sections.id
 * @property int|null $federation_section_id
 * @property string $validator_user_id contest organization members that validate the work for specific section
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ContestSection|null $contestSection
 * @property-read \App\Models\FederationSection|null $federationSection
 * @property-read \App\Models\UserContact|null $userValidator
 * @property-read \App\Models\UserWork|null $work
 * @method static \Database\Factories\UserWorkValidationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereFederationSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereUserWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation whereValidatorUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkValidation withoutTrashed()
 * @mixin \Eloquent
 */
class UserWorkValidation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',                     // pk bigint autoincrement
        'user_work_id',           // fk user_works.id
        'section_id',             // fk contest_sections.id (nullable se usata federation_section_id)
        'federation_section_id',  // fk federation_sections.id (nullable se sezione indipendente)
        'validator_user_id',      // fk user_contacts.user_id / users.id
        // created_at                reserved
        // updated_at                reserved
        // deleted_at                reserved
    ];

    protected function casts(): array
    {
        return [
            'id' => 'int',
            'user_work_id' => 'string',
            'section_id' => 'string',
            'federation_section_id' => 'int',
            'validator_user_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // RELATIONSHIPS

    /**
     * user_work_validation.user_work_id > user_works.id
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(
            related: UserWork::class,
            foreignKey: 'user_work_id',
            ownerKey: 'id'
        );
    }

    /**
     * user_work_validation.section_id > contest_sections.id
     */
    // user_work_validation.section:id > contest_sections.id
    public function contestSection(): BelongsTo
    {
        return $this->belongsTo(
            related: ContestSection::class,
            foreignKey: 'section_id',
            ownerKey: 'id'
        );
    }

    // user_work_validations.federation_section_id > federation_sections.id
    public function federationSection(): BelongsTo
    {
        return $this->belongsTo(
            related: FederationSection::class,
            foreignKey: 'federation_section_id',
            ownerKey: 'id'
        );
    }

    // work_validations.validator_user_id > user_contacts.user_id
    public function userValidator(): BelongsTo
    {
        return $this->belongsTo(
            related: UserContact::class,
            foreignKey: 'validator_user_id',
            ownerKey: 'id'
        );
    }
}
