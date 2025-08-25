<?php

namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;


class Add extends Component
{
    public string $code = '';
    public string $name = '';
    public string $website = '';
    
    /**
     * Receive form data then back w/error or
     * redirect to list
     */
    public function save()
    {
        $validated = $this->validate();
        // Federation::create($validated);
        $fed = New Federation();
        $fed->create($validated);

        return redirect()
          ->route('federation-list')
          ->with('success', __('New Federation added to list, enjoy!') );
    }

    /** 
     * list of validation rules
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'code' => 'required|string|min:3|max:6',
            'website' => 'string|url|max:255',
        ];
    }

    public function render()
    {
        return view('livewire.federation.add');
    }
}
