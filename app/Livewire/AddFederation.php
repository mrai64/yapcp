<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attribute\Validate;
use App\Models\Federation;

class AddFederation extends Component
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
        Federation::create($validated);

        return redirect()->route('federation-list')->with('success', __('New Federation added to list, enjoy!') );
    }

    /** 
     * list of validation rules
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'code' => 'required|string|max:6',
            'website' => 'string|url|max:255',
        ];
    }

    public function render()
    {
        return view('livewire.add-federation');
    }

}
