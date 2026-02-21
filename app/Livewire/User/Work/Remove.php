<?php

/**
 * Work/Remove
 */

namespace App\Livewire\User\Work;

use App\Models\UserContact;
use App\Models\UserWork;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Remove extends Component
{
    public UserWork $work;

    //
    public $workId;

    public $userId;

    public $workFile;

    #[Validate('string|max:255')]
    public $titleEnglish;

    public $titleLocal;

    public $referenceYear;

    public $longSide;

    public $shortSide;

    public $extension;

    //
    public UserContact $user_contact;

    public $basedir;

    /**
     * Before the show
     */
    public function mount(string $wid) // see route()
    {
        $this->work = UserWork::findOrFail($wid)->get()[0];

        $this->workId = $this->work->id;
        // TODO check user_id
        $this->userId = $this->work->user_id;

        $this->workFile = $this->work->work_file;
        $this->titleEnglish = $this->work->title_en;
        $this->titleLocal = $this->work->title_local;
        $this->referenceYear = $this->work->reference_year;
        $this->longSide = $this->work->long_side;
        $this->shortSide = $this->work->short_side;
        $this->extension = $this->work->extension;
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

        $work = new UserWork(); // empty
        $work->findOrFail($this->workId)->delete();

        // back to list
        return redirect()
            ->route('photo-box-list')
            ->with('success', __('Work safely removed, thanks!'));
    }
}
