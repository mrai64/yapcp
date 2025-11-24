<?php
/**
 * 2025-08-29 picked from iso.org open broad data
 * 2025-09-17 flag_code added to fillable fields
 * 2025-09-22 add getter function
 * 2025-09-29 add getter function
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    public const table_name = 'countries';
    // protected $primaryKey = 'id';
    protected $keyType   = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'country',
        'flag_code',
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts(): array{
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * like Country::all() but sorted by country
     */
    public function allByCountry()
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        $countries = DB::table(self::table_name)
            ->whereNull('deleted_at')
            ->orderBy('country','asc')
            ->get();

        return $countries; 
    }
    public static function country_list_by_country()
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        $countries = self::select('country')->orderBy('country')->get();
        return $countries;
    }
    /**
     * inline
     */
    public static function country_name(string $country_id) : string
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        $country = self::where('id', $country_id)->get()[0];
        return $country->country . ' /' . $country->flag_code;
    }

    public static function country_flag(string $country_id) : string
    {
        Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        $flag = self::where('id', $country_id)->get('flag_code')[0];
        Log::info(__FUNCTION__ . ' ' . __LINE__ . ' ' . $country_id . ' ' . $flag );
        return (is_null($flag['flag_code'])) ? '🏳️' : $flag['flag_code'];
    }
}
