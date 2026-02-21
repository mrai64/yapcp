<?php

/**
 * Modify only part of fields list.
 * NOT update work file
 */

namespace App\Livewire\User\Work;

use App\Models\UserContact;
use App\Models\UserWork;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Modify extends Component
{
    // don't use WithFileUploads;

    public UserWork $work;

    public UserContact $userContact;

    public string $workId; // uuid

    public string $userId; // uuid

    public string $workFileName;

    public string $titleEnglish;

    public string $titleLocal;

    public string $longSide;

    public string $shortSide;

    public string $extension;

    public string $referenceYear;

    public $image = []; // list($width, $height, $type, $attr)

    public $basedir;

    public function mount(string $wid) // see route()
    {

        $this->userId = Auth::id();
        $this->userContact = UserContact::where('id', Auth::id())->get()[0];
        $this->work = UserWork::findOrFail($wid);
        // and now form fields
        $this->workId = $this->work->id;
        $this->workFileName = $this->work->work_file;
        $this->titleEnglish = $this->work->title_en;
        $this->titleLocal = $this->work->title_local;
        // workaround __DIR__ from here to storage
        $this->basedir = str_ireplace('/app/Livewire/Work', '/public/storage/photos', __DIR__);
        $image = getimagesize($this->basedir.'/'.$this->workFileName);
        $this->longSide = ($image[0] >= $image[1]) ? $image[0] : $image[1];
        $this->shortSide = ($image[0] <= $image[1]) ? $image[0] : $image[1];
        $this->extension = str_ireplace('image/', '', $image['mime']);
        $this->referenceYear = $this->work->reference_year;

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
        $this->work = UserWork::findOrFail($this->workId);
        $this->work->title_en = $this->titleEnglish;
        $this->work->title_local = $this->titleLocal;
        $this->work->long_side = $this->longSide;
        $this->work->short_side = $this->shortSide;
        $this->work->extension = $this->extension;
        $this->work->reference_year = $this->referenceYear;
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
