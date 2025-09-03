<?php
/**
 * 
 */
namespace App\Livewire\Work;

use Livewire\Component;
use App\Models\Country;
use App\Models\UserContact;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class Listed extends Component
{
    public $user_id      = null;
    public $user_contact = null;
    public $country      = [];
    public $work_list    = [];
    public $odd; // alterned background rows
    
    /**
     * Before the show
     * 
     */
    public function mount() 
    {
        $this->user_id      = Auth::id();

        $this->user_contact = UserContact::whereNull('deleted_at')
            ->where('user_id', $this->user_id)
            ->select('user_id', 'country_id', 'first_name', 'last_name')
            ->get()[0];

        $this->country = Country::where('id', $this->user_contact['country_id'] )
            ->select('id', 'country', 'flag_code')
            ->get()[0];

        $this->work_list    = Work::whereNull('deleted_at')
            ->where( 'user_id', $this->user_contact['user_id'])
            ->orderBy('title_en')
            ->get();
        
        $this->odd = true;
    }

    /**
     * The show
     */
    public function render()
    {
        return view('livewire.work.listed');
    }
}
