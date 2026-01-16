<?php

/**
 * Countries w/flag
 * auxiliary table for some tables
 * . user_contacts
 * . federations
 * . organizations
 * . contests
 *
 * 2025-08-29 picked from iso.org open broad data
 * 2025-09-17 flag_code added to fillable fields
 * 2025-09-22 add getter function
 * 2025-09-29 add getter function
 * 2025-12-04 completed unicode flag manual fills
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLENAME = 'countries';

    // protected $primaryKey = 'id'; default
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'country',
        'flag_code',
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts(): array
    {
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERs

    public static function country_list_by_country()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $countries = self::select('country')->orderBy('country')->get();

        return $countries;
    }

    public static function country_name(string $country_id): string
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $country = self::where('id', $country_id)->get()[0];

        return $country->country.' /'.$country->flag_code;
    }

    /**
     * @return string $flag | 🏳️ (empty flag)
     */
    public static function country_flag(string $country_id): string
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $flag = self::where('id', $country_id)->get('flag_code')[0];
        Log::info(__FUNCTION__.' '.__LINE__.' '.$country_id.' '.$flag);

        return (is_null($flag['flag_code'])) ? '🏳️' : $flag['flag_code'];
    }

    // RELATIONS

    public function contest(): BelongsToMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $contest_set = $this->belongsToMany(Contest::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest_set'.json_encode($contest_set));

        return $contest_set;
    }

    public function federation(): BelongsToMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $federation_set = $this->belongsToMany(Federation::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' federation_set'.json_encode($federation_set));

        return $federation_set;
    }

    public function organization(): BelongsToMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $organization_set = $this->belongsToMany(Organization::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' organization_set'.json_encode($organization_set));

        return $organization_set;
    }

    public function user_contact(): BelongsToMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $user_contact_set = $this->belongsToMany(UserContact::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' user_contact_set'.json_encode($user_contact_set));

        return $user_contact_set;
    }
}
