<?php

namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;
use Livewire\Attributes\Validate;

class Remove extends Component
{
    public Federation $federation;
    
    #[Validate('required|int')]
    public $id = 0;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string|min:3|max:6')]
    public $code = '';

    #[Validate('string|url|max:255')]
    public $website = '';

    public function mount(int $id)
    {
        $fed = New Federation();
        $this->federation =$fed->findOrFail($id);
        $this->name    = $this->federation->name;
        $this->code    = $this->federation->code;
        $this->website = $this->federation->website;
    }

    public function delete()
    {
        $this->validate();
        $fed = New Federation();
        $fed->findOrFail($this->id)->delete();
        // to list 
        return redirect()
            ->route('federation-list')
            ->with('success', __('Federation data safely removed, thanks!') );

    }

    public function render()
    {
        return view('livewire.federation.remove');
    }
}
