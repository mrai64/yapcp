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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FederationMore extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'federation_mores';

    protected $fillable = [
        'id', //                     pk standard bigint
        'federation_id', //          fk federations.id
        'field_name', //             code
        'field_label', //            label
        'field_validation_rules', // use in rules()
        'field_default_value', //    used in report when userContactRole is missing
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

    // GETTERS

    // RELATIONSHIP

    // federation_mores.federation_id > federations.id
    public function federation()
    {
        $federation = $this->belongsTo(Federation::class, 'id', 'federation_id');
        // Log
        return $federation;
    }

    // federation_mores.federation_id > user_contact_mores.federation_id
    public function userMores()
    {
        $moreFields = $this->hasMany(
            related: UserContactMore::class,
            foreignKey: 'federation_id',
            localKey: 'federation_id'
        );
        // log
        return $moreFields;
    }


}
