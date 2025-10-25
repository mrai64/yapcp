<?php
/**
 * (User) Work (manual) Validation (log)
 * Even if a work in a section should be validated for some rule
 * in an automatic way, some others are only human validation,
 * but why validate twice the same work?
 * 
 * - work_id
 * - federation_section_id 
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class WorkValidation extends Model
{
    use SoftDeletes;
    // primaryKey   id
    // keyType      integer
    // incrementing true

    protected $fillable = [
        // id 
        'work_id',
        'federation_section_id',
        'validator_user_id',
        // created_at
        // updated_at
        // deleted_at
    ];

    protected function casts()
    {
        Log::info('Model '. __CLASS__ .' f/'.__FUNCTION__.':'.__LINE__.' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    
    // RELATIONSHIP 
    public function work() 
    {
        Log::info('Model '. __CLASS__ .' f/'.__FUNCTION__.':'.__LINE__.' called');
        $work = $this->hasOne(Work::class);
        Log::info('Model '. __CLASS__ .' f/'.__FUNCTION__.':'.__LINE__.' work:' . json_encode($work));
        return $work;        
    }
    
    public function federation_section()
    {
        Log::info('Model '. __CLASS__ .' f/'.__FUNCTION__.':'.__LINE__.' called');
        $federation_section = $this->hasOne(FederationSection::class);
        Log::info('Model '. __CLASS__ .' f/'.__FUNCTION__.':'.__LINE__.' federation_section:' . json_encode($federation_section));
        return $federation_section;
    }

}
