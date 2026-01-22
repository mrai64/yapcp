<?php

/**
 * Some field are common to all contest, but some contest
 * because are sponsored from a national o inernational Federation
 * for federation requirements needs "One More Field(s)".
 * i.e. card_id for FIAP, GPU, PSA etc.
 *
 * That's a KV table to maintain that "more fields"
 *
 * 2026-01-22 PSR-12
 *
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
        'id', //                   pk bigint autoincrement
        'user_contact_user_id', // TODO user_contacts.id
        'federation_id', //        fk federations.id federation_mores.federation_id
        'field_name', //           fk                federation_mores.field_name
        'field_value', //          text
        // created_at              reserved
        // updated_at              reserved
        // deleted_at              reserved
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

    // user_contact_mores.user_contact_user_id > user_contacts.user_id
    public function userContact()
    {
        $uc = $this->belongsTo(
            related: userContact::class,
            foreignKey: 'user_id',
            ownerKey: 'user_contact_user_id'
        );
        // log
        return $uc;
    }

    // user_contact_mores.federation_id > federations.id
    public function federation()
    {
        $federation = $this->belongsTo(
            related: Federation::class,
            foreignKey: 'id',
            ownerKey: 'federation_id'
        );
        // log
        return $federation;
    }

}
