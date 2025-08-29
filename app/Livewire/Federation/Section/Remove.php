<?php
/**
 * 
 */
namespace App\Livewire\Federation\Section;

use App\Models\FederationSection;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Remove extends Component
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
        $sec = New FederationSection();
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
        return view('livewire.federation.section.remove');
    }

    /**
     * After the show, remove confirmed
     * **it's a softdelete**
     */
    public function delete()
    {
        $this->validate();
        $sec = New FederationSection();
        $sec->findOrFail($this->id)->delete();
        // back to list
        return redirect()
            ->route('federation-section-list', ['fid' => $this->federation_id])
            ->with('success', __('Section safely removed from list, thanks!'));

    }
}
