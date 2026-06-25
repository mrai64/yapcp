<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidFileFormats implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if ($attribute === 'contestSectionFileFormats') {
            $proposedSet = explode(',', $value);
            foreach ($proposedSet as $proposed) {
                if (!in_array(trim($proposed), config('app-yapcp.formats.allowed'))) {
                    $fail(__("{$proposed} not allowed"));
                }
            }
        }
        //
    }
}
