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
use App\Models\UserWork;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Attributes\Session;

class ContestSectionRule implements ValidationRule
{
    public $sectionId;

    public ContestSection $section;

    #[Session(key: 'sectionJson')]
    public $sectionJson;

    public $userWorkId;

    public $userWork;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' in: attribute:' . $attribute . ', value:' . $value);

        // sectionId first
        if ($attribute === 'sectionId') {
            $this->sectionId = $value;
            $this->section = ContestSection::where('id', $value)->get()[0];
            $this->sectionJson = json_encode($this->section);
            ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' section:' . $this->sectionJson);
            session()->put('sectionJson', $this->sectionJson);
        }

        // userWorkId follow
        if ($attribute === 'userWorkId') {
            $this->section = json_decode(session()->get('sectionJson'));
            ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' section:' . json_encode($this->section));
            $this->userWorkId = $value;
            $this->userWork = UserWork::where('id', $value)->get()[0];
            ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' work:' . json_encode($this->userWork));

            if ($this->userWork->long_side > $this->section->long_size_max) {
                $fail('🟥 Long side');
            }
            if ($this->userWork->short_side < $this->section->short_size_max) {
                $fail('🟥 Short side');
            }
            if (($this->section->monochoromatic_required) && ($this->userWork->monochromatic != true)) {
                $fail('🟥 Monochromatic');
            }
            if (($this->section->monochoromatic_required) && ($this->userWork->raw != true)) {
                $fail('🟥 RAW unavailable');
            }
            ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' ok ok');
        }

    }
}
