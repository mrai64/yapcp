<?php

/**
 * Federation Section Modify
 *
 * 2025-10-16 federations and federation_sections refactorize
 */

namespace App\Livewire\Federation\Section;

use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Modify extends Component
{
    public Federation $federation;

    public FederationSection $section;

    public string $federation_id;

    public string $code;

    public string $name_en;

    public string $rule_definition;

    /**
     * 1. Before the show
     */
    public function mount(string $fid, string $sid) // as in route()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $this->federation = Federation::findOrFail($fid);
        $this->section = FederationSection::where('federation_id', $fid)->where('code', $sid)->first();
        // not found? not modify
        if (! isset($this->section->code)) {
            abort(404);
        }

        $this->federation_id = $this->section->federation_id;
        $this->code = $this->section->code;
        $this->name_en = $this->section->name_en;
        $this->rule_definition = ($this->section->rule_definition === null) ? '' : $this->section->rule_definition;
    }

    /**
     * 2. Show must go
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

        return view('livewire.federation.section.modify');
    }

    /**
     * 3. validate rules
     */
    public function rules()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

        return [
            // federation_id readonly
            // code          readonly
            'name_en' => 'required|string|max:255',
            'rule_definition' => 'string',
        ];

    }

    /**
     * After the show
     */
    public function update_federation_section()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $validated = $this->validate();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' validated:'.json_encode($validated));

        $this->section->update($validated);
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.json_encode($this->section));

        // to list
        return redirect()
            ->route('federation-section-list', ['fid' => $this->sec->federation_id])
            ->with('success', __('Federation Section data updated, thanks!'));
    }
}
