<?php
/**
 * UserContact is 
 * child of Users
 * 
 * user_id as uuid() should be primary key also for user_contact
 * 2025-09-03 photo_box where store user works and passport_photo
 * 2025-09-10 add timezone and lang_local (for search: local_lang)
 * 2025-09-21 add getter functions
 * 
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
        'passport_photo', // /photo_box/__passport_photo.jpg
        'address',
        'address_line2',
        'city',
        'region',
        'postal_code',
        'lang_local', //previously only 'lang'
        'timezone',
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

    /**
     * @return the string used to store works and passport_photo
     */
    public function photo_box() : string
    {
        $pb = $this->country_id . '/'
        . $this->last_name  . '/'
        . $this->first_name . '_'
        . $this->user_id; // substr( $this->id, 0, 4);

        $pb = str_ireplace(':', '-', $pb);
        $pb = str_ireplace('+', '',  $pb);
        $pb = str_ireplace(' ', '-', $pb);
        return $pb;
    }
    /**
     * 
     */
    public static function get_first_last_name(string $uid) : string
    {
        $user = self::where('user_id', $uid)->get()[0];
        return $user->first_name . ' ' . $user->last_name . ' /'. $user->country_id;
    }
    /**
     * 
     */
    public static function get_last_first_name(string $uid) : string
    {
        $user = self::where('id', $uid)->get()[0];
        return $user['last_name'] . ', ' . $user['first_name'] . ' /'. $user['country_id'];
    }
}
