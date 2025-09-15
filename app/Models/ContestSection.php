<?php
/**
 * Contest Sections is a child table for Contest
 * pk uuid
 * fk uuid
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestSection extends Model
{
    public const table_name = 'contest_sections';
    use SoftDeletes;
    // pk is uuid, and don'need ++
    protected $keyType = 'string'; // char(36)
    public    $incrementing = false;

    protected $fillable = [
        // id 
        'contest_id',
        'code',
        // under_patronage,
        'name_en',
        'name_local',
    ]; 

    // pk is uuid
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    
}
