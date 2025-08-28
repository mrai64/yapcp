<?php
/**
 * FederationSection
 * child of Federation
 * 
 * id             bigint u a+ pk
 * federation_id  bigint u
 * code           vchar 5
 * name           vchar 255
 * created_at     datetime
 * updated_at     datetime
 * deleted_at     datetime N
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FederationSection extends Model
{
    use HasFactory, SoftDeletes;

    public const table_name = 'federation_sections'; // see migration

    protected $fillable = [
        'federation_id',
        'code',
        'name',
        'excerptum',
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
