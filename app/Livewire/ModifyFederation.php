<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Federation;
use Livewire\Attributes\Validate;

class ModifyFederation extends Component
{
    public Federation $federation;
    
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('required|string|max:6')]
    public $code = '';

    #[Validate('string|url|max:255')]
    public $website = '';

    public function setFederation(Federation $federation)
    {
        $this->federation = $federation;
        $this->name       = $federation->name;
        $this->code       = $federation->code;
        $this->website    = $federation->website;
    }

    public function mount(int $id) // $id as 'id' in route()
    {
        $this->federation = Federation::findOrFail($id);
        $this->name       = $this->federation->name;
        $this->code       = $this->federation->code;
        $this->website    = $this->federation->website;
    }

    public function update()
    {
        $this->validate();
        $this->federation->update(
            $this->all()
        );
        // to list 
        return redirect()
            ->route('federation-list')
            ->with('success', __('Federation data updated, thanks!') );

    }

    public function render() 
    {
        return view('livewire.modify-federation');
    }
}
