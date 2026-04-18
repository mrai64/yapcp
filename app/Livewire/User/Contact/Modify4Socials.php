<?php

/**
 * UserContact modify 4 - personal pages
 */

namespace App\Livewire\User\Contact;

use App\Models\Country;
use App\Models\FederationMore;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Modify4Socials extends Component
{
    public UserContact $userContact;

    public Country $country;

    public string $firstName;

    public string $lastName;

    public string $countryId;

    // form fields
    public string $website;

    public string $facebook;

    public string $exTwitter;

    public string $linkedin;

    public string $instagram;

    // 1. mount
    public function mount(?UserContact $userContact = null) // as route
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        if ($userContact === null) {
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' no parm');
            $uid = Auth::id(); // user id
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' uid: ' . $uid);
            $this->userContact = UserContact::where('id', $uid)->first();
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' uC: ' . json_encode($this->userContact));
        } else {
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' parm');
            $this->userContact = $userContact;
        }

        // form fields
        $this->firstName = $this->userContact->first_name; // name         readonly
        $this->lastName = $this->userContact->last_name; //   surname      readonly
        // default value ITA as first developer he's italian 
        $this->countryId = ($this->userContact->country_id ?? 'ITA');
        $this->country = $this->userContact->country; //      nationality  readonly

        $this->website = $this->userContact->website ?? '';
        $this->facebook = $this->userContact->facebook ?? '';
        $this->exTwitter = $this->userContact->x_twitter ?? '';
        // $this->linkedin = $this->userContact->linkedin ?? '';
        $this->instagram = $this->userContact->instagram ?? '';
    }

    // 2. render
    public function render()
    {
        return view('livewire.user.contact.modify4-socials');
    }

    // 3. validate
    public function rules()
    {
        return [
            'website' => 'nullable|string|active_url|max:100',
            'facebook' => 'nullable|string|active_url|max:100',
            'exTwitter' => 'nullable|string|active_url|max:100',
            // 'linkedin' => 'nullable|string|active_url|max:100',
            'instagram' => 'nullable|string|active_url|max:100',
        ];
    }

    // 4. update
    // was: update_user_socials
    public function updateUserContact4th()
    {
        $validated = $this->validate();

        $this->userContact->website = $validated['website'];
        $this->userContact->facebook = $validated['facebook'];
        $this->userContact->x_twitter = $validated['exTwitter'];
        // $this->userContact->linkedin = $validated['linkedin'];
        $this->userContact->instagram = $this->instagram;

        $this->userContact->save();

        $firstFed = FederationMore::orderBy('federation_id', 'asc')->first();

        // no additional fields at all
        if ($firstFed === null) {
            return redirect()
                ->route('user-contact.modify1', ['userContact' => $this->userContact])
                ->with('success', __("Personal pages updated successfully"));
        }

        // additional fields form for first federation id
        return redirect()
            ->route('user-contact.modify5', ['federation' => $firstFed, 'userContact' => $this->userContact])
            ->with('success', __("Personal pages updated successfully"));
    }
}
