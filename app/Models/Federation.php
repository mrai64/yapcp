<?php
/**
 * 2025-08-27 add contact country_id
 * 2025-08-27 add contact field
 * 2025-09-20 add 4 char to code
 * 2025-09-30 add getter function
 * 2025-10-16 table changes - v.2
 *            old 'code' field become id, string 
 * Relationship 1:1 country_id
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Federation extends Model
{
    use HasFactory, SoftDeletes;
    // TODO remove - protected string $table
    public const table_name = 'federations';
    // pk it's not a bigint nor uuid
    protected     $keyType  = 'string';
    public    $incrementing = false;

    protected $fillable =[
        'id', 
        'country_id', // fk countries.id
        'name_en',
        'local_lang',
        'name_local',
        'timezone_id',
        'website',
        'contact_info',
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts(): array{
        Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    
    // GETTER
    public static function listed_by_country_id_name() 
    {
        Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $f_list = self::select()
            ->orderBy('country_id', 'asc')
            ->orderBy('name_en', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($f_list) );
        return $f_list;
    }
    
    public function country() : HasOne
    {
        // Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.json_encode($this) );
        $country_ = $this->hasOne(Country::class, 'id', 'country_id');
        Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($country_) );
        return $country_;
    }

    public function sections() : HasMany
    {
        Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $s_collection = $this->hasMany(FederationSection::class, 'federation_id', 'id');
        Log::info('Models '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($s_collection) );
        return $s_collection;
    }
}
