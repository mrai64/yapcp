<?php

/**
 * User contacts maintain a min set of values that are
 * required in all contest, but for every
 * sponsor federation they require some fields
 * i.e. card_id that should have anyone a different
 * definition.
 *
 * That's a KV table to maintain that "more fields"
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContactMore extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'user_contact_mores';

    // standard id
    protected $fillable = [
        // id
        'user_contact_user_id', // TODO user_contacts.id
        'federation_id',
        'field_name',
        'field_value',
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
