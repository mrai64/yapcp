<?php

/**
 * As User_contact maintain only fields that are common to all contests
 * when a federation ask for a proprietary fields as card_id that field
 * is defined in federation_mores model
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FederationMore extends Model
{
    //
    use HasFactory, SoftDeletes;

    public const TABLENAME = 'federation_mores';

    protected $fillable = [
        // id
        'federation_id',
        'field_name',
        'field_label',
        'field_validation_rules',
        'field_default_value',
        // created_at
        // updated_at
        // deleted_at
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

}
