<?php
/**
 * 2025-08-29 picked from iso.org open broad data
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    use HasFactory, SoftDeletes;
    // use env('DB_TABLE_PREFIX')
    public const table_name = 'countries';

    protected $fillable = [
        'id',
        'country',
    ];

    protected function casts(): array{
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * like Country::all() but sorted by country
     */
    public function allByCountry(){

        $countries = DB::table(self::table_name)
            ->whereNull('deleted_at')
            ->orderBy('country','asc')
            ->get();

        return $countries; 
    }
}
