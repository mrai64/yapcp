<?php
/**
 * yyyy-mm-dd note
 */
namespace App\Livewire\Federation\Section;

use App\Models\Federation;
use App\Models\FederationSection;
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
    public $name = '';
    
    #[Validate('string')]
    public string $excerptum;
    
    /**
     * Before the show
     */
    public function mount(int $fid) // fid as in route()
    {
        $federation = New Federation();
        $federation->findOrFail($fid);

        $this->federation_id = $fid;
        $this->code          = '';
        $this->name          = '';
        $this->excerptum     = '';
    }
    /**
     * Sho must go 
     */
    public function render()
    {
        return view('livewire.federation.section.add');
    }
    /**
     * At last 
     */
    public function save()
    {
        // 
        $validated = $this->validate();
        $validated['federation_id'] = $this->federation_id;
        $sec = New FederationSection();
        $sec->create($validated);

        return redirect()
            ->route('federation-section-list', ['fid' => $this->federation_id ])
            ->with('success', __('New Federation Section inserted, enjoy!'));

    }
}
