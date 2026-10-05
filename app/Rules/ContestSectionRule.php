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
use App\Models\ContestWork;
use App\Models\UserWork;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Livewire\Attributes\Session;

class ContestSectionRule implements ValidationRule
{
    #[Session(key: 'sectionJson')]
    public $sectionJson;

    public $contestWorkCount = 0;
    public ContestSection $section;
    public $sectionId;
    public $userWorkId;
    public $userWork;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' in: attribute:' . $attribute . ', value:' . $value);

        // sectionId first
        if ($attribute === 'sectionId') {
            $this->sectionId = $value;
            $this->section = ContestSection::where('id', $value)->first();
            //ds(__CLASS__ . ' ' . __FUNCTION__ . ':' . __LINE__ . ' section:' . $this->sectionJson);
            session()->put('sectionId', $this->sectionId);
        }

        // userWorkId follow
        if ($attribute === 'userWorkId') {
            $this->sectionId  = session()->get('sectionId');
            $this->userWorkId = $value;
            $this->section    = ContestSection::find($this->sectionId);
            $this->userWork   = UserWork::find($value);
            $this->contestWorkCount = ContestWork::where('section_id', $this->sectionId)
                ->where('user_id', $this->userWork->user_id)
                ->count();

            if ($this->contestWorkCount >= $this->section->max_works) {
                $fail('🟥 Too much works');
            }
            if ($this->userWork->long_size > $this->section->long_size_max) {
                $fail('🟥 Long size');
            }
            if ($this->userWork->short_size < $this->section->short_size_max) {
                $fail('🟥 Short size');
            }
            if (($this->section->monochromatic_required) && ($this->userWork->is_monochromatic != true)) {
                $fail('🟥 Monochromatic');
            }
            if (($this->section->raw_required) && ($this->userWork->has_raw_file != true)) {
                $fail('🟥 RAW MUST BE available');
            }
        }
    }
}
