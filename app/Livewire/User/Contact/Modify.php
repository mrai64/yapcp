<?php

/**
 * user_contacts modify
 *
 * user/contact/modify
 * child of: user
 *
 * use passport_photo so yes: upload file
 * 2025-09-10 rename col lang into lang_local
 * 2025-09-28 fix
 * 2025-11-24 removed TimezonesList
 * 2025-12-28 review
 */

// blade <\Resource\Views\Livewire\User\Contact\Modify.Blade>

namespace App\Livewire\User\Contact;

use App\Models\Country;
use App\Models\LangList;
use App\Models\Timezone;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
// use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
// passport_photo
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Modify extends Component
{
    use WithFileUploads;

    // dati che viaggiano
    // Country
    // country_id
    public string $country; //     readonly

    public $countries; //          readonly

    // User
    // user_id
    public User $user; //          readonly

    public $userContact;

    public string $userId; //     readonly user_contacts.id        string uuid

    public string $countryId; //           countries.id.   char

    public string $firstName;

    public string $lastName;

    public string $nickName;

    public string $email;

    public string $previousEmail; // to assure that

    public string $cellular;

    public string $passportPhotoPathFile;

    public $passportPhotoImage; // readonly

    public string $address;

    public string $address2ndLine;

    public string $city;

    public string $region;

    public string $postalCode;

    public string $website;

    public string $facebook;

    public string $exTwitter;

    public string $instagram;

    public string $whatsapp;

    public string $localLang;

    public array $langSet = [];

    public string $localTimezone;

    public array $timezoneList = [];

    /**
     * 1. Before the show
     */
    public function mount() // no 'uid' param in route()
    {
        // insert if missing
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' Called id: ' . Auth::id());
        $this->userId = Auth::id();

        // countries list, sorted by country name
        $this->countries = Country::select('country')->orderBy('country')->get();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' countries: ' . json_encode($this->countries));

        $this->userContact = UserContact::where('user_id', $this->userId)->first();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' userContact: ' . json_encode($this->userContact));

        $this->userId = $this->userContact->id;
        $this->countryId = $this->userContact->country_id;
        $this->firstName = $this->userContact->first_name;
        $this->lastName = $this->userContact->last_name;
        $this->nickName = (is_null($this->userContact->nick_name)) ? '' : $this->userContact->nick_name;
        $this->email = $this->userContact->email;
        $this->previousEmail = $this->userContact->email;
        $this->cellular = $this->userContact->cellular;
        //
        $this->passportPhotoImage = null;
        $photoPathFile = $this->userContact->passport_photo;
        // $photoPathFile = str_ireplace('%20', ' ', $photoPathFile);
        // $photoPathFile = str_ireplace('+',   '',  $photoPathFile);
        $this->passportPhotoPathFile = $photoPathFile; // img path, not in form

        $this->address = $this->userContact->address;
        $this->address2ndLine = $this->userContact->address_line2;
        $this->city = $this->userContact->city;
        $this->region = $this->userContact->region;
        $this->postalCode = $this->userContact->postal_code;

        $this->langSet = LangList::LANGCODES;
        $this->localLang = $this->userContact->lang_local;

        $timezoneSet = Timezone::select('id')->get();
        $this->timezoneList = array_values(collect($timezoneSet)->toArray());
        $this->localTimezone = $this->userContact->timezone;

        $this->website = (is_null($this->userContact->website)) ? '' : $this->userContact->website;
        $this->facebook = (is_null($this->userContact->facebook)) ? '' : $this->userContact->facebook;
        $this->exTwitter = (is_null($this->userContact->exTwitter)) ? '' : $this->userContact->exTwitter;
        $this->instagram = (is_null($this->userContact->instagram)) ? '' : $this->userContact->instagram;
        $this->whatsapp = (is_null($this->userContact->whatsapp)) ? '' : $this->userContact->whatsapp;
    }

    /**
     * 2. Show on
     */
    public function render()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // countries list, sorted by country name
        $this->countries = Country::select('country')->orderBy('country')->get();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' countries: ' . json_encode($this->countries));

        return view('livewire.user.contact.modify');
    }

    /**
     * 3. Only Validation rules 1 / 2
     */
    public function rules()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return [
            'id' => 'required|exists:user_contacts,id',
            'userId' => 'required|exists:users,id',
            'countryId' => 'required|exists:countries,id',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'nickName' => 'string|max:255',
            'email' => 'string|email|max:255',
            'cellular' => 'integer|min_digits:6|max_digits:14|min:1',
            'passportPhotoPathFile' => 'nullable|string|max:255',
            'passportPhotoImage' => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'address' => 'string|max:255',
            'address2ndLine' => 'string|max:255',
            'city' => 'string|max:255',
            'region' => 'string|max:255',
            'postalCode' => 'string|max:10',
            'website' => 'string|active_url|max:255',
            'facebook' => 'string|active_url|max:255',
            'exTwitter' => 'string|active_url|max:255',
            'instagram' => 'string|active_url|max:255',
            'whatsapp' => 'string|active_url|max:255',
            'localLang' => 'string|max:5',
            'localTimezone' => 'required|exists:timezones,id',
        ];
    }

    /**
     * 4. After the show,... update?
     */
    public function updateUserContact()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->userContact = UserContact::where('id', $this->userId)->first();

        // apply the rules
        $validated = $this->validate();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' validated: ' . json_encode($validated));

        // data integration
        $validated['email'] = $this->previousEmail;
        // where is him/her photo_box?
        $photoPath = $this->userContact->photoBox();

        // see also: https://livewire.laravel.com/docs/uploads#storing-uploaded-files
        $photoPathFile = $photoPath . '/' . '__passport_photo.jpg';
        $photoPathFile = str_ireplace(':', '-', $photoPathFile);
        $photoPathFile = str_ireplace('+', '', $photoPathFile);
        $photoPathFile = str_ireplace(' ', '-', $photoPathFile);

        if ($this->passportPhotoImage) {
            $this->passportPhotoImage->storePubliclyAs('photos', $photoPathFile, 'public');
            $this->passportPhotoPathFile = $photoPathFile;
            $validated['passportPhotoPathFile'] = $photoPathFile;
        }
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' validated: ' . json_encode($validated));

        $this->userContact->update($validated);
        $this->userContact->save();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' userContact: ' . json_encode($this->userContact));

        //
        // back to dashboard
        return redirect()
            ->route('dashboard', ['id' => $this->userId])
            ->with('success', __('Your personal info has been updated, thanks!'));
    }
}
