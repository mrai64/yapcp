<?php

/**
 * UserContact modify 4 - personal pages
 */

namespace App\Livewire\User\Contact;

use App\Models\Country;
use App\Models\FederationMore;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
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
    public function mount(?string $uid = '')
    {
        if ($uid === '') {
            $uid = Auth::id();
        }

        // if uid is not Auth::id(), auth::id() must be in user_admins.id
        // otherwise -and temporary- abort 403
        if ($uid != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->userContact = UserContact::where('user_id', $uid)->first();
        // form fields
        $this->firstName = $this->userContact->first_name;
        $this->lastName = $this->userContact->last_name;
        $this->countryId = ($this->userContact->country_id ?? '***');
        $this->country = ($this->userContact->country ?? null);

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
                ->with('success', __("'Personal pages updated successfully.'"))
                ->route('user-contact-modify1', ['uid' => $this->userContact->user_id]);
        }

        // additional fields form for first federation id
        return redirect()
            ->with('success', __("'Personal pages updated successfully.'"))
            ->route('user-contact-modify5', ['fid' => $firstFed->federation_id, 'uid' => $this->userContact->user_id]);
    }
}
