<?php
/**
 * UserContact is 
 * child of Users
 * 
 * user_id as uuid() should be primary key also for user_contact 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContact extends Model
{
    use HasFactory, SoftDeletes;

    public const table_name = 'user_contacts';
    
    // attributes mass assignable in factory and seeder
    protected $fillable = [
        // id            pk
        'user_id', //    fk users.id
        'country_id', // fk countries.id
        'first_name',
        'last_name',
        'nick_name',
        'email', //      users.email
        'cellular', //   [0-9]{7..20}
        'passport_photo', // \path\file.ext
        'address',
        'address_line2',
        'city',
        'region',
        'postal_code',
        'website', //     url
        'facebook', //    url
        'x_twitter', //   url
        'instagram', //   url
        'whatsapp', //    url
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
}
