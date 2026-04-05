<?php

/**
 * Federation Section Add
 *
 * 2025-10-16 federations and federation_sections refactorize
 * 2026-04-04 federation instance, instead of federation_id string
 *
 * @see /resources/views/livewire/federation/section/add.blade.php
 *
 */

namespace App\Livewire\Federation\Section;

use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Add extends Component
{
    public Federation $federation;

    public FederationSection $section;

    /**
     * field list
     */
    public string $federation_id; //  readonly

    #[Validate('required|string|max:10')]
    public string $sectionCode = '';

    #[Validate('required|string|max:255')]
    public string $sectionNameEn = '';

    // TODO local lang
    // TODO name_local

    #[Validate('string')]
    public string $ruleDefinition; // free text

    // TODO file formats
    // ext, ext, ext w/all the item in

    #[Validate('required|integer|min:0|max:12')]
    public int $minWorks = 0;

    #[Validate('required|integer|min:0|max:12')]
    public int $maxWorks = 4;

    /**
     * 1. Before the show
     */
    public function mount(Federation $federation)
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->federation = $federation;
        // fields set defaults
        $this->federation_id = $federation->id;
        $this->sectionCode = '';
        $this->sectionNameEn = '';
        $this->ruleDefinition = '';
        $this->minWorks = 0;
        $this->maxWorks = 4;
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' federation:' . json_encode($federation));
    }

    /**
     * 2. Show must go
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' this:' . json_encode($this));
        return view('livewire.federation.section.add');
    }

    /**
     * 3. validation rules
     *
     * Are in form fields definition
     *
     */

    /**
     * 4. At last act
     */
    public function saveNewFederationSection()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' in:' . json_encode($this));
        //
        $validated = $this->validate();
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' validated:' . json_encode($validated));

        // integration
        $validated['federation_id'] = $this->federation_id;

        $sec = FederationSection::create([
            'federation_id' => $this->federation_id,
            'code' => $this->sectionCode,
            'name_en' => $this->sectionNameEn,
            'rule_definition' => $this->ruleDefinition,
            'min_works' => $this->minWorks,
            'max_works' => $this->maxWorks,
        ]);
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($sec));

        return redirect()
            ->route('federation-section.list', ['federation' => $this->federation])
            ->with('success', __('New Federation Section inserted, enjoy!'));

    }
}
