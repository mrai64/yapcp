<?php
/**
 * Lookup table for FederationAdditional
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FederationAdditionalFieldName extends Model
{
    use HasFactory,SoftDeletes;
    
    public const table_name = 'federation_additional_field_name_sets';
    
    protected $fillable = [
        'federation_id',
        'federation_field_name',
        'federation_field_label',
        'federation_field_validation_rules',
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    //
}
