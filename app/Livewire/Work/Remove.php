<?php
/**
 * Work/Remove
 * 
 */
namespace App\Livewire\Work;

use Livewire\Component;
use App\Models\UserContact;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class Remove extends Component
{
    /**
     * 
     */
    
    public Work $work;
    //
    public $work_id;
    public $user_id;
    public $work_file;

    #[Validate('string|max:255')]
    public $title_en;
    public $title_local;
    public $reference_year;
    public $long_side;
    public $short_side;
    public $extension;
    //
    public UserContact $user_contact;
    public $basedir;

    /**
     * Before the show
     */
    public function mount(string $wid) // see route()
    {
        $this->work = Work::findOrFail( $wid )->get()[0];

        $this->work_id = $this->work->id;
        // TODO check user_id 
        $this->user_id        = $this->work->user_id;

        $this->work_file      = $this->work->work_file;
        $this->title_en       = $this->work->title_en;
        $this->title_local    = $this->work->title_local;
        $this->reference_year = $this->work->reference_year;
        $this->long_side      = $this->work->long_side;
        $this->short_side     = $this->work->short_side;
        $this->extension      = $this->work->extension;
    }
    /**
     * Show
     */
    public function render()
    {
        return view('livewire.work.remove');
    }
    /**
     * Validation
     */

    /**
     * At last (soft)delete
     */
    public function delete() 
    {
        $this->validate();

        $work = new Work();
        $work->findOrFail( $this->work_id )->delete();
        // back to list
        return redirect()
            ->route('photo-box-list')
            ->with('success', __('Work safely removed, thanks!') );
    }
}
