<?php
/**
 * TODO rules() to check monochromatic in ['Y', 'N'] and file size H x W
 */
namespace App\Livewire\Work;

use App\Models\UserContact;
use App\Models\Work;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;

class Add extends Component
{
    use WithFileUploads;
    /**
     * form fields and tmp vars 
     */
    public Work        $work;
    public UserContact $user_contact;
    // some value are via form but not all
    public string $id;
    public string $user_id;
    public string $photo_box;

    #[Validate('required|image|max:65536')]
    public $work_image = null; // max: 64MB, enough?

    public string $work_file;
    public string $extension;
    public string $reference_year;

    #[Validate('required|string|max:255')]
    public string $title_en;

    #[Validate('string|max:255')]
    public string $title_local;

    #[Validate('string|uppercase|max:1')]
    public string $monochromatic;

    /**
     * Before the show
     * 
     */
    public function mount()
    {
        $this->user_id = Auth::id();
        $this->user_contact = UserContact::where( 'user_id', Auth::id() )->get()[0];
        $this->photo_box = $this->user_contact->photo_box();
        $this->extension = '';
        $this->reference_year = date("Y");
        $this->title_en = '';
        $this->title_local = '';
        $this->monochromatic = 'N';
    }

    /**
     * Show must go
     */
    public function render()
    {
        return view('livewire.work.add');
    }

    /**
     * After the show, 
     * ...Really simple
     */
    public function save() 
    {
        $this->validate();

        // for each in [] 
        $this->id = Str::uuid();
        $this->extension = strtolower(pathinfo( $this->work_image->getClientOriginalName(), PATHINFO_EXTENSION ));
        if (!$this->extension){
            $this->extension = 'jpg';
        }
        $this->work_file = $this->photo_box . '/' . $this->id . '.' . $this->extension;
        $this->work_image->storePubliclyAs( 'photos', $this->work_file, 'public');
        $this->monochromatic = strtoupper($this->monochromatic) === 'Y' ? strtoupper($this->monochromatic) : 'N';

        $this->work                 = New Work();
        $this->work->id             = $this->id;
        $this->work->user_id        = $this->user_id;
        $this->work->work_file      = $this->work_file;
        $this->work->extension      = $this->extension;
        $this->work->reference_year = $this->reference_year;
        $this->work->title_en       = $this->title_en;
        $this->work->title_local    = $this->title_local;
        $this->work->long_side      = 0;
        $this->work->short_side     = 0;
        $this->work->monochromatic  = $this->monochromatic;

        $this->work->save();

        // Next!?
        return redirect()
            ->route('photo-box-add')
            ->with('success', __('Your personal Gallery has been updated, thanks! Another upload?'));

    }

}
