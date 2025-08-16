<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{
    use HasFactory;
    //
    protected $keyType = 'string';
    public    $incrementing = false;
    protected $fillable = [
        'iso3',
        'country',
    ];

    /**
     * 
    public static function booted() {
        static::creating(function ($model){
            $model->iso3->limit(3);
        });
    }
     */
}
