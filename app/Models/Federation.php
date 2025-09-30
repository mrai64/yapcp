<?php
/**
 * 2025-08-27 add contact country_id
 * 2025-08-27 add contact field
 * 2025-09-20 add 4 char to code
 * 2025-09-30 add getter function
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Federation extends Model
{
    // use env('DB_TABLE_PREFIX')
    public const table_name = 'federations';

    use HasFactory, SoftDeletes;

    protected $fillable =[
        'country_id',
        'code',
        'name',
        'website',
        'contact',
    ];

    protected function casts(): array{
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER
    public static function listed_by_country_id_name() 
    {
        $federations = self::select('id', 'country_id', 'name')
            ->orderBy('country_id', 'asc')
            ->orderBy('name', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        Log::info(__FUNCTION__ .' '.__LINE__.' '.json_encode($federations) );
        return $federations;
    }
}
