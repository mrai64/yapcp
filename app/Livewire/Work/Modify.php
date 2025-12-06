<?php

/**
 * Modify only part of fields list.
 * NOT update work file
 */

namespace App\Livewire\Work;

use App\Models\UserContact;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Modify extends Component
{
    // don't use WithFileUploads;

    public Work $work;

    public UserContact $user_contact;

    public string $work_id; // uuid

    public string $user_id; // uuid

    public string $work_file;

    public string $title_en;

    public string $title_local;

    public string $long_side;

    public string $short_side;

    public string $extension;

    public string $reference_year;

    public $image = []; // list($width, $height, $type, $attr)

    public $basedir;

    public function mount(string $wid) // see route()
    {

        $this->user_id = Auth::id();
        $this->user_contact = UserContact::where('user_id', Auth::id())->get()[0];
        $this->work = Work::findOrFail($wid);
        // and now form fields
        $this->work_id = $this->work->id;
        $this->work_file = $this->work->work_file;
        $this->title_en = $this->work->title_en;
        $this->title_local = $this->work->title_local;
        // workaround __DIR__ from here to storage
        $this->basedir = str_ireplace('/app/Livewire/Work', '/public/storage/photos', __DIR__);
        $image = getimagesize($this->basedir.'/'.$this->work_file);
        $this->long_side = ($image[0] >= $image[1]) ? $image[0] : $image[1];
        $this->short_side = ($image[0] <= $image[1]) ? $image[0] : $image[1];
        $this->extension = str_ireplace('image/', '', $image['mime']);
        $this->reference_year = $this->work->reference_year;

    }

    public function render()
    {
        return view('livewire.work.modify');
    }

    /**
     * After the show
     */
    public function update()
    {
        $this->work = Work::findOrFail($this->work_id);
        $this->work->title_en = $this->title_en;
        $this->work->title_local = $this->title_local;
        $this->work->long_side = $this->long_side;
        $this->work->short_side = $this->short_side;
        $this->work->extension = $this->extension;
        $this->work->reference_year = $this->reference_year;
        if ($this->work->reference_year < '1826') {
            $this->work->reference_year = date('Y');
        }
        $this->work->update();

        // back to list
        // Next!?
        return redirect()
            ->route('photo-box-list')
            ->with('success', __('Your personal Gallery has been updated, thanks! Another?'));

    }
}
