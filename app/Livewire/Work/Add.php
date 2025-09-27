<?php
/**
 * (User) Works Add
 * w/upload in photo_box directory
 * - adopted by user_contact table
 *
 * 2025-09-27 reformat rules()
 */
namespace App\Livewire\Work;

use App\Models\UserContact;
use App\Models\Work;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Add extends Component
{
    use WithFileUploads;

    // form fields and tmp vars
    public Work        $work;

    public UserContact $user_contact;

    public string $id; // generated filename
    public string $user_id;
    public string $photo_box; // user folder

    public $work_image = null; // max: 64MB, enough?

    public string $work_file;
    public string $extension;
    public string $reference_year;

    public string $title_en;
    public string $title_local;
    public string $monochromatic;

    /**
     * 1. Before the show
     *
     */
    public function mount()
    {
        Log::info( __FUNCTION__ .' '. __LINE__ );
        $this->id             = Str::uuid();
        $this->user_id        = Auth::id();
        $this->photo_box      = UserContact::get_photo_box( $this->user_id );
        $this->extension      = '';
        $this->reference_year = date("Y");
        $this->title_en       = '';
        $this->title_local    = '';
        $this->monochromatic  = 'N';
    }
    /**
     * 2. Show must go
    */
    public function render()
    {
        Log::info( __FUNCTION__ .' '. __LINE__ );
        return view('livewire.work.add');
    }
    /**
     * 3. Validation rules
    */
    public function rules()
    {
        Log::info( __FUNCTION__ .' '. __LINE__ );
        return [
            // id             assigned uuid
            // user_id        assigned from Auth::id()
            'work_image'    => 'required|image|max:65536',
            'extension'     => 'string|lowercase|max:6',
            'reference_year'=> 'int|min:1900|max:'.date('Y'),
            'title_en'      => 'required|string|max:255',
            'title_local'   => 'string|max:255',
            // 'long_side',   assigned from image.size
            // 'short_side',  assigned from image.size
            'monochromatic' => 'required|string|uppercase|max:1|in:Y,N',
        ];
    }
    
    /**
     * 4. After the show, validate n save
    */
    public function save_photo_box()
    {
        Log::info( __FUNCTION__ .' '. __LINE__ );
        $validated = $this->validate();
        // construct from work_image for work_file
        $wh = $this->work_image->dimensions();
        $validated['long_side']  = ($wh[0] >= $wh[1] ) ? $wh[0] : $wh[1];
        $validated['short_side'] = ($wh[0] <= $wh[1] ) ? $wh[0] : $wh[1];

        // missing data integration
        $validated['id'] = $this->id;
        $validated['user_id'] = $this->user_id;

        $validated['extension'] = Str::lower( pathinfo( $this->work_image->getClientOriginalName(), PATHINFO_EXTENSION) );
        if ( !in_array($validated['extension'], Work::valid_extensions) ){
            $validated['extension'] = 'jpg';
        }

        $validated['work_file'] = $this->photo_box . '/' . $validated['id'] . '.' . $validated['extension'];
        Log::info( __FUNCTION__ .' '. __LINE__ . ' ' . $validated['work_file']);
        $this->work_image->storePubliclyAs( 'photos', $validated['work_file'], 'public');
        $validated['work_image'] = '';

        $validate['monochromatic'] = ($validated['monochromatic'] === 'Y') ? $validated['monochromatic'] : 'N';

        $this->work = Work::create($validated);
        Log::info( __FUNCTION__ .' '. __LINE__ . ' ' . $this->work );
        // Next!?
        return redirect()
            ->route('photo-box-add')
            ->with('success', __('Your personal Gallery has been updated, thanks! Another upload?'));

    }

}
