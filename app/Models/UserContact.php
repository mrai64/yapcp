<?php
/**
 * UserContact is 
 * child of Users
 * 
 * user_id as uuid() should be primary key also for user_contact
 * 2025-09-03 photo_box where store user works and passport_photo
 * 2025-09-10 add timezone and lang_local (for search: local_lang)
 * 2025-09-21 add getter functions
 * 2025-10-26 add relationship w/country
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

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
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
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
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $pb = $this->country_id . '/'
        . $this->last_name  . '/'
        . $this->first_name . '_'
        . $this->user_id; // substr( $this->id, 0, 4);
        
        $pb = str_ireplace(':', '-', $pb);
        $pb = str_ireplace('+', '',  $pb);
        $pb = str_ireplace(' ', '-', $pb);
        return $pb;
    }
    
    // GETTERS
    /**
     * get photo_box folder name
     * 
    */
    public static function get_photo_box(string $uid) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $uc = self::where('user_id', $uid)->firstOrFail();
        // compose pb
        $photo_box = $uc->country_id
        . '/' . $uc->last_name
        . '/' . $uc->first_name
        . '_' . $uc->user_id;
        $photo_box = str_ireplace(':', '-', $photo_box);
        $photo_box = str_ireplace('+', '',  $photo_box);
        $photo_box = str_ireplace(' ', '-', $photo_box);
        return $photo_box;
    }
    /**
     * 
     */
    public static function get_first_last_name(string $uid) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user = self::where('user_id', $uid)->first();
        return $user->first_name . ' ' . $user->last_name . ' /'. $user->country_id;
    }
    /**
     * 
     */
    public static function get_last_first_name(string $uid) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user = self::where('user_id', $uid)->first();
        return $user->last_name . ' ' . $user->first_name . ' /'. $user->country_id;
    }
    /** 
     * 
     */
    public static function get_email(string $uid) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user = self::where('user_id', $uid)->get('email')[0];
        return $user['email'];
    }
    /** 
     * 
     */
    public static function get_first_name(string $uid) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user = self::where('user_id', $uid)->get('first_name')[0];
        return $user['first_name'];
    }
    /** 
     * 
     */
    public static function get_last_name(string $uid) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user = self::where('user_id', $uid)->get('last_name')[0];
        return $user['last_name'];
    }
    /** 
     * 
     */
    public static function get_country_id(string $uid) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user = self::where('user_id', $uid)->get('country_id')[0];
        return $user['country_id'];
    }
    
    // RELATIONSHIP 
    
    public function user()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user = $this->belongsTo(User::class);
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' user:' . json_encode($user) );
        return $user;
    }

    // user_contact->country->country_flag
    public function country()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $country = $this->hasOne(Country::class, 'id', 'country_id');
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' country:' . json_encode($country));
        return $country;
    }
    
    // user_contact->juries
    public function juries()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $juries = $this->hasMany(ContestJury::class, 'user_contact_id', 'user_id');
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' juries:' . json_encode( $juries ));
        return $juries;
    }
}
