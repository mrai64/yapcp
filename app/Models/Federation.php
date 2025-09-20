<?php
/**
 * 2025-08-27 add contact country_id
 * 2025-08-27 add contact field
 * 2025-09-20 add 4 char to code
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
