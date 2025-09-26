<?php
/**
 * Basic and simplest set check rule for Y/N fields
 * preferred instead of a bool true/false
 * 
 */
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class setYNRule implements ValidationRule
{
    /**
     * valid values set
     */
    private const valid_values = [
        'N',
        'Y',
    ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $in_val = Str::of($value);
        Log::info(__FUNCTION__ . ' ' . __LINE__ . $attribute .':'. $in_val); 
        if ( ! in_array( $in_val, self::valid_values) ) {
            Log::alert(__FUNCTION__ . ' '. __LINE__ . 'received in input:' . $in_val );
            $fail( "You must pass a valid value" );
        }
    }
}
