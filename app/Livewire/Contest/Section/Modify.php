<?php

namespace App\Livewire\Contest\Section;

use App\Models\Contest;
use App\Models\ContestSection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Modify extends Component
{
    public Contest $contest;

    public $contestSectionSet;

    public ContestSection $section;

    // form fields
    public string $code;
    public string $underPatronage; // ( 'Y', 'N')
    public string $sectionNameEn;
    public string $sectionNameLang;



    // 1. before the show
    public function mount(ContestSection $section) // as in route()
    {
        $this->section = $section;
        $this->contest = Contest::find($section->contest_id);
        $this->contestSectionSet = ContestSection::whereNull('deleted_at')
            ->where('contest_id', $this->contest->id)
            ->orderBy('code')
            ->get();
        //
        $this->code = $section->code;
        $this->underPatronage = $section->under_patronage;
        $this->sectionNameEn  = $section->name_en;
        $this->sectionNameLang = $section->name_local;

    }

    // 2. the show
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return view('livewire.contest.section.modify');
    }

    // 3. rules to validate form fields

    // 4. validate then update contest section data
    public function updateContestSection()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

    }

}
