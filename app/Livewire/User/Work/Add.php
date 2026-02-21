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
 *
 * TODO become UserWork or User\Work
 *
 */

namespace App\Livewire\User\Work;

use App\Models\UserContact;
use App\Models\UserWork;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
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
    public UserWork $work;

    public UserContact $user_contact;

    public string $id; // used to generate filename

    public string $userId;

    public string $photoBox; // user folder

    // the image file
    public $userWorkImage = null; // max: 64MB, enough?

    // the generated filename of uploaded file
    public string $work_file;

    public string $extension;

    public string $reference_year;

    public string $titleEn;

    public string $titleLocal;

    public string $monochromatic;

    /**
     * 1. Before the show
     */
    public function mount()
    {
        ds('Component ' . __CLASS__ . ' from ' . __FILE__);
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');
        $this->id = Str::uuid(); // no
        $this->userId = Auth::id();
        $this->photoBox = UserContact::getPhotoBox($this->userId);
        $this->extension = '';
        $this->reference_year = date('Y');
        $this->titleEn = '';
        $this->titleLocal = '';
        $this->monochromatic = 'N';
    }

    /**
     * 2. Show must go
     */
    public function render()
    {
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');

        return view('livewire.work.add');
    }

    /**
     * 3. Validation rules
     */
    public function rules()
    {
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');

        return [
            // id            work_id assigned uuid
            // userId        user_id assigned from Auth::id()
            'userWorkImage' => 'required|image|max:65536',
            'extension' => 'string|lowercase|max:6',
            'reference_year' => 'int|min:1900|max:' . date('Y'), // TODO IS A FIAF requirement
            'titleEn' => 'required|string|max:255',
            'titleLocal' => 'string|max:255',
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
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' called');
        $validated = $this->validate();
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' validated:' . json_encode($validated));
        // data integration
        $validated['user_id'] = $this->userId;
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' validated:' . json_encode($validated));

        $validated['extension'] = Str::lower(pathinfo($this->userWorkImage->getClientOriginalName(), PATHINFO_EXTENSION));
        if (! in_array($validated['extension'], UserWork::VALIDEXT)) {
            $validated['extension'] = 'jpg';
        }
        // construct from userWorkImage for work_file
        $wh = $this->userWorkImage->dimensions();
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' size 0:' . $wh[0] . ' 1:' . $wh[1]);
        $validated['long_side'] = ($wh[0] >= $wh[1]) ? $wh[0] : $wh[1];
        $validated['short_side'] = ($wh[0] <= $wh[1]) ? $wh[0] : $wh[1];
        $validated['monochromatic'] = ($validated['monochromatic'] === 'Y') ? 'Y' : 'N';
        $validated['work_file'] = 'anon.jpg';

        // 1. insert and give uuid, then update with uuid
        // was: with snake_case fields $this->work = Work::create($validated);
        $validated['title_en'] = $validated['titleEn'];
        $validated['title_local'] = $validated['titleLocal'];
        $this->work = UserWork::create($validated);

        $validated['id'] = $this->work->id; // uuid assigned
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' validated:' . json_encode($validated));

        $validated['work_file'] = $this->photoBox . '/' . $validated['id'] . '.' . $validated['extension'];
        ds(__FUNCTION__ . ' ' . __LINE__ . ' ' . $validated['work_file']);
        $this->userWorkImage->storePubliclyAs('photos', $validated['work_file'], 'public');
        $validated['work_image'] = ''; // free space?

        // 2. update file name
        $this->work->update(['work_file' => $validated['work_file']]);
        $this->work->save();
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' work:' . json_encode($this->work));

        // 3. made a thumbs
        // if ($wh[0]> 300 || $wh[1] > 300) {
        // }
        $imageManager = new ImageManager(Driver::class);
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' resize:1');

        $resized = $imageManager->read($this->userWorkImage);
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' resize:2');
        if ($wh[0] >= $wh[1]) {
            $resized->scale(width: 300);
        } else {
            $resized->scale(height: 300);
        }

        $resizedFilename = $this->photoBox . '/' . $validated['id'] . '_300_.' . $validated['extension'];
        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' resize_file: ' . $resizedFilename);

        // NO
        //  Storage::put non va, ::putFile ::putFileAs funzionano con file che arrivano dal form
        //  $resizedPath = Storage::putFileAs(
        //      path: 'photos',
        //      file: new File(
        //          $this->photoBox . '/'
        //          . $validate['id'] . '_300_.' . $validated['extension']
        //      ),
        //      name: $validate['id'] . '_300_.' . $validated['extension']
        //  );

        $resizedEncoded = (string) $resized->encode(new JpegEncoder(quality: 90)); // quality 0..100
        // NO $put_file = Storage::put('/public/storage/photos/'.$resizedFilename , $resizedEncoded, 'public');
        //    anche dichiarandolo /public lo mette in /private
        // NO Storage::disk('photos')->put($resizedFilename , $resizedEncoded, 'public');
        //    non è definito un disco 'photos'
        // NO Storage::disk('public')->put($resizedFilename , $resizedEncoded, 'public');
        //    e questo non ha fatto ...niente
        // NO Storage::disk('public')->put('/public/storage/photos/'.$resizedFilename , $resizedEncoded, 'public');
        //    Questo salva in /public/public/storage/photos/
        // SI FINALMENTE SI
        Storage::disk('public')->put('/photos/' . $resizedFilename, $resizedEncoded, 'public');

        ds('Component ' . __CLASS__ . ' f/' . __FUNCTION__ . ':' . __LINE__ . ' fine');

        //
        // All done right, go to next upload
        return redirect()
            ->route('photo-box-add')
            ->with('success', __('Your personal Gallery has been updated, thanks! Another upload?'));
    }
}
