<?php
/**
 * yyyy-mm-dd note
 */
namespace App\Livewire\Federation\Section;

use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Add extends Component
{
    /**
     * field list
     */
    public FederationSection $section;

    // id                      assigned
    public $federation_id; //  readonly

    #[Validate('required|string|max:10')]
    public $code = '';

    #[Validate('required|string|max:255')]
    public $name_en = '';

    #[Validate('string')]
    public string $rule_definition;

    /**
     * 1. Before the show
     */
    public function mount(string $fid) // fid as in route()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        $federation = new Federation();
        $federation->findOrFail($fid);
        
        $this->federation_id = $fid;
        $this->code          = '';
        $this->name_en       = '';
        $this->rule_definition     = '';
    }
    /**
     * 2. Sho must go
    */
    public function render()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        return view('livewire.federation.section.add');
    }
    /**
     * 3. validation rules
    */
    /**
     * 4. At last act
    */
    public function save_new_section()
    {
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' called');
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' in:' . json_encode($this) );
        //
        $validated = $this->validate();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' validated:' . json_encode($validated) );
        
        // integration
        $validated['federation_id'] = $this->federation_id;
        
        $sec = FederationSection::create($validated);
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.':'.__LINE__. ' out:' . json_encode($sec) );

        return redirect()
            ->route('federation-section-list', ['fid' => $this->federation_id ])
            ->with('success', __('New Federation Section inserted, enjoy!'));

    }
}
