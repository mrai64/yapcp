<?php

/**
 * Federation Sections Remove
 */

namespace App\Livewire\Federation\Section;

use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Remove extends Component
{
    public FederationSection $sec;

    public int $id;

    public string $federation_id;

    public string $code;

    public string $name_en;

    public string $rule_definition;

    public FederationSection $section;

    /**
     * 1. Before the show
     */
    public function mount(string $sid) // id as in route()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $this->section = FederationSection::where('id', $sid)->first();
        if (! isset($this->section->code)) {
            abort(404);
        }

        $this->id = $this->section->id;
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

        return view('livewire.federation.section.remove');
    }
    /**
     * 3. validation rules
     * None- it's all readonly
     */

    /**
     * 4. Do the job
     */
    public function delete_federation_section()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

        $this->section->delete();

        // back to list
        return redirect()
            ->route('federation-section-list', ['fid' => $this->federation_id])
            ->with('success', __('Section safely removed from list, thanks!'));

    }
}
