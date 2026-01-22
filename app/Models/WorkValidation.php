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
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

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
