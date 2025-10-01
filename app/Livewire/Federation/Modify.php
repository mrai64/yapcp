<?php
/**
 * 2025-07-28 add $id (readonly) for federation-section and other child tables
 * 2025-08-30 add country_id, contact
 * 2025-09-20 enlarge 6 > 10 code field
 */
namespace App\Livewire\Federation;

use Livewire\Component;
use App\Models\Federation;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;

class Modify extends Component
{
    public $federation;

    // readonly
    public $id;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:10')]
    public $code = '';

    #[Validate('string|url|max:255')]
    public $website = '';

    #[Validate('required|string|uppercase|min:3|exists:countries,id')]
    public $country_id;

    #[Validate('string')]
    public $contact;

    //readonly
    public $countries;

    /**
     * Before the show
     */
    public function mount(string $fid) // $fid as 'fid' in route()
    {
        // $this->federation = Federation::findOrFail($id);
        Log::info(__FUNCTION__.' '.__LINE__.' fid: '. $fid);
        $this->federation = Federation::where('id', $fid)->get()[0];
        Log::info(__FUNCTION__.' '.__LINE__.' found:'. json_encode($this->federation));

        $this->id         = $this->federation['id'];
        $this->name       = $this->federation['name'];
        $this->code       = $this->federation['code'];
        $this->website    = $this->federation['website'];
        $this->country_id = $this->federation['country_id'];
        $this->contact    = $this->federation['contact'];
    }

    /**
     * Show it
     */
    public function render()
    {
        $country = new Country();
        $this->countries = $country->allByCountry();

        return view('livewire.federation.modify');
    }

    /**
     * After the show
     */
    public function update()
    {
        $this->validate();
        //
        $this->federation->name       = $this->name;
        $this->federation->code       = $this->code;
        $this->federation->website    = $this->website;
        $this->federation->country_id = $this->country_id;
        $this->federation->contact    = $this->contact;

        $this->federation->update(
            $this->all()
        );
        // to list
        return redirect()
            ->route('federation-list')
            ->with('success', __('Federation data updated, thanks!') );

    }


}
