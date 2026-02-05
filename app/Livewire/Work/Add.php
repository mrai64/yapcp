<?php

/**
 * (User) Works Add
 * w/upload in photo_box directory
 * - adopted by user_contact table
 *
 * 2025-09-27 reformat rules()
 * 2025-10-19 rewrite partially the last function saveUserWorkPhoto
 *            add intervention package
 * TODO PSR-12 - form fields are in snake_case as db columns
 */

namespace App\Livewire\Work;

use App\Models\UserContact;
use App\Models\Work;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    // form fields and tmp vars
    public Work $work;

    public UserContact $user_contact;

    public string $id; // generated filename

    public string $user_id;

    public string $photoBox; // user folder

    // the image file
    public $work_image = null; // max: 64MB, enough?

    // the generated filename of uploaded file
    public string $work_file;

    public string $extension;

    public string $reference_year;

    public string $title_en;

    public string $title_local;

    public string $monochromatic;

    /**
     * 1. Before the show
     */
    public function mount()
    {
        Log::info('Component '.__CLASS__.' from '.__FILE__);
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $this->id = Str::uuid(); // no
        $this->user_id = Auth::id();
        $this->photoBox = UserContact::getPhotoBox($this->user_id);
        $this->extension = '';
        $this->reference_year = date('Y');
        $this->title_en = '';
        $this->title_local = '';
        $this->monochromatic = 'N';
    }

    /**
     * 2. Show must go
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');

        return view('livewire.work.add');
    }

    /**
     * 3. Validation rules
     */
    public function rules()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');

        return [
            // id             assigned uuid
            // user_id        assigned from Auth::id()
            'work_image' => 'required|image|max:65536',
            'extension' => 'string|lowercase|max:6',
            'reference_year' => 'int|min:1900|max:'.date('Y'),
            'title_en' => 'required|string|max:255',
            'title_local' => 'string|max:255',
            // 'long_side',   assigned from image.size
            // 'short_side',  assigned from image.size
            'monochromatic' => 'required|string|uppercase|max:1|in:Y,N',
        ];
    }

    /**
     * 4. After the show, validate n save
     * Save record
     * update record w/file name
     * build a 300px miniature
     */
    public function saveUserWorkPhoto()
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $validated = $this->validate();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' validated:'.json_encode($validated));
        // data integration
        $validated['user_id'] = $this->user_id;
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' validated:'.json_encode($validated));

        $validated['extension'] = Str::lower(pathinfo($this->work_image->getClientOriginalName(), PATHINFO_EXTENSION));
        if (! in_array($validated['extension'], Work::VALIDEXT)) {
            $validated['extension'] = 'jpg';
        }
        // construct from work_image for work_file
        $wh = $this->work_image->dimensions();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' size 0:'.$wh[0].' 1:'.$wh[1]);
        $validated['long_side'] = ($wh[0] >= $wh[1]) ? $wh[0] : $wh[1];
        $validated['short_side'] = ($wh[0] <= $wh[1]) ? $wh[0] : $wh[1];
        $validated['monochromatic'] = ($validated['monochromatic'] === 'Y') ? 'Y' : 'N';
        $validated['work_file'] = 'anon.jpg';

        // 1. insert and give uuid
        // was: with snake_case fields $this->work = Work::create($validated);
        $this->work = Work::create($validated);



        $validated['id'] = $this->work->id; // uuid assigned
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' validated:'.json_encode($validated));

        $validated['work_file'] = $this->photoBox.'/'.$validated['id'].'.'.$validated['extension'];
        Log::info(__FUNCTION__.' '.__LINE__.' '.$validated['work_file']);
        $this->work_image->storePubliclyAs('photos', $validated['work_file'], 'public');
        $validated['work_image'] = '';

        // 2. update file name
        $this->work->update(['work_file' => $validated['work_file']]);
        $this->work->save();
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' work:'.json_encode($this->work));

        // 3. made a thumbs
        // if ($wh[0]> 300 || $wh[1] > 300) {
        // }
        $img_man = new ImageManager(Driver::class);
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' resize:1');

        $resized = $img_man->read($this->work_image);
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' resize:2');
        if ($wh[0] >= $wh[1]) {
            $resized->scale(width: 300);
        } else {
            $resized->scale(height: 300);
        }

        $resized_filename = $this->photoBox.'/'.$validated['id'].'_300_.'.$validated['extension'];
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' resize_file: '.$resized_filename);

        // NO $path_resized = Storage::putFileAs('photos', new File($this->photoBox . '/' . $validated['id'] . '_300_.' . $validated['extension']), $validated['id'] . '_300_.' . $validated['extension'] );
        //    put non va, putFile putFileAs funzionano con file che arrivano dal form

        $resized_encoded = (string) $resized->encode(new JpegEncoder(quality: 90)); // quality 0..100
        // NO $put_file = Storage::put('/public/storage/photos/'.$resized_filename , $resized_encoded, 'public');
        //    anche dichiarandolo /public lo mette in /private
        // NO Storage::disk('photos')->put($resized_filename , $resized_encoded, 'public');
        //    non è definito un disco 'photos'
        // NO Storage::disk('public')->put($resized_filename , $resized_encoded, 'public');
        //    e questo non ha fatto ...niente
        // NO Storage::disk('public')->put('/public/storage/photos/'.$resized_filename , $resized_encoded, 'public');
        //    Questo salva in /public/public/storage/photos/
        // SI FINALMENTE SI
        Storage::disk('public')->put('/photos/'.$resized_filename, $resized_encoded, 'public');

        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' fine');

        //
        // All done right, go to next upload
        return redirect()
            ->route('photo-box-add')
            ->with('success', __('Your personal Gallery has been updated, thanks! Another upload?'));

    }
}
