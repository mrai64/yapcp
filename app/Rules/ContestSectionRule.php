<?php

/**
 * Contest Subscribe ADD validation rule
 *
 * Give from mixed $value a section_id and a userWorkId,
 * then check if userWorkId respect all rules coded in
 * section_id
 *
 * source: https://www.youtube.com/watch?v=TXYCtTfouPg
 *
 * That validation rules apply to 2 form fields, then "abuse"
 * session() to store data from first field to check it to 2nd
 * field because it's check a field at time.
 */

namespace App\Rules;

use App\Models\ContestSection;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Session;

class ContestSectionRule implements ValidationRule
{
    public $section_id;

    public $section;

    #[Session(key: 'section_json')]
    public $section_json;

    public $userWorkId;

    public $work;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in: attribute:'.$attribute.', value:'.$value);

        // section_id first
        if ($attribute === 'section_id') {
            $this->section_id = $value;
            $this->section = ContestSection::where('id', $value)->get()[0];
            $this->section_json = json_encode($this->section);
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' section:'.$this->section_json);
            session()->put('section_json', $this->section_json);
        }

        // userWorkId follow
        if ($attribute === 'userWorkId') {
            $this->section = json_decode(session()->get('section_json'));
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' section:'.json_encode($this->section));
            $this->userWorkId = $value;
            $this->work = Work::where('id', $value)->get()[0];
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' work:'.json_encode($this->work));

            if ($this->work->long_side > $this->section->rule_max_size) {
                $fail('🟥 Long side');
            }
            if ($this->work->short_side < $this->section->rule_min_size) {
                $fail('🟥 Short side');
            }
            if (($this->section->rule_monochromatic === 'Y') && ($this->work->monochromatic != 'Y')) {
                $fail('🟥 Monochromatic');
            }
            Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ok ok');
        }

    }
}
