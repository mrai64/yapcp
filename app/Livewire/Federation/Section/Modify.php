<?php
/**
 * 
 */
namespace App\Livewire\Federation\Section;

use Livewire\Component;
use App\Models\FederationSection;
use Livewire\Attributes\Validate;

class Modify extends Component
{
    public FederationSection $sec;

    public int $id;

    #[Validate('required|int|min:1')]
    public int $federation_id;
    
    #[Validate('required|string|max:10')]
    public string $code;
    
    #[Validate('required|string|max:255')]
    public string $name;
    
    #[Validate('string')]
    public string $excerptum;
    
    /**
     * Before the show
     */
    public function mount(int $id) // id as in route()
    {
        $sec = new FederationSection();
        $this->sec = $sec->findOrFail($id);

        $this->id            = $this->sec->id;
        $this->federation_id = $this->sec->federation_id;
        $this->code          = $this->sec->code;
        $this->name          = $this->sec->name;
        $this->excerptum    = ($this->sec->excerptum === NULL) ? '' : $this->sec->excerptum;
    }

    /**
     * Show must go
     */
    public function render()
    {
        return view('livewire.federation.section.modify');
    }

    /**
     * After the show
     */
    public function update()
    {
        $this->validate();
        $this->sec->update(
            $this->only(['code', 'name', 'excerptum']) // $this->all()
        );
        // to list 
        return redirect()
            ->route('federation-section-list', ['fid' => $this->sec->federation_id])
            ->with('success', __('Federation Section data updated, thanks!') );
    }
}
