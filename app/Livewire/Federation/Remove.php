<?php
/**
 * 2025-08-30 Only show in read-only, add country_id and contact
 */

namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;

class Remove extends Component
{
    public Federation $federation;
    
    #[Validate('required|int')]
    public $id;

    public $name = '';
    public $code = '';
    public $website = '';
    public $country_id = '';
    public $country;
    public $contact = '';

    public function mount(int $id)
    {
        $fed = new Federation();
        $this->federation =$fed->findOrFail($id);
        $this->name    = $this->federation->name;
        $this->code    = $this->federation->code;
        $this->website = $this->federation->website;
        $this->country_id = $this->federation->country_id;
        $this->contact = $this->federation->contact;
        $this->country = DB::table( Country::table_name )
            ->whereNull('deleted_at')
            ->where('id', $this->country_id )
            ->pluck('id');
    }

    public function delete()
    {
        $this->validate();
        $fed = new Federation();
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
