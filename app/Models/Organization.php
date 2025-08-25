<?php
/**
 * Organization | Organisation
 * They are Contest organizer
 *
 * uuid
 * hasFactory
 * softDelete
 * verifyEmail(?)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory, SoftDeletes ;

    //uuid
    protected $keyType = 'string';//     uuid string(36)
    public    $incrementing = false;//   uuid don't need ++
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }
    //uuid

    protected $fillable = [
        'country_code',
        'name',
        'email',
        'website',
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
