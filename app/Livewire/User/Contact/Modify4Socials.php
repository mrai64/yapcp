<?php

/**
 * UserContact modify 4 - personal pages
 */

namespace App\Livewire\User\Contact;

use App\Models\FederationMore;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Modify4Socials extends Component
{
    public $user_contact;

    public $country;

    public string $first_name;

    public string $last_name;

    public string $country_id;

    // form fields
    public string $website;

    public string $facebook;

    public string $x_twitter;

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

        $this->user_contact = UserContact::where('user_id', $uid)->first();
        // form fields
        $this->first_name = $this->user_contact->first_name;
        $this->last_name = $this->user_contact->last_name;
        $this->country_id = ($this->user_contact->country_id ?? '***');
        $this->country = ($this->user_contact->country ?? null);

        $this->website = $this->user_contact->website ?? '';
        $this->facebook = $this->user_contact->facebook ?? '';
        $this->x_twitter = $this->user_contact->x_twitter ?? '';
        // $this->linkedin = $this->user_contact->linkedin ?? '';
        $this->instagram = $this->user_contact->instagram ?? '';
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
            'x_twitter' => 'nullable|string|active_url|max:100',
            // 'linkedin' => 'nullable|string|active_url|max:100',
            'instagram' => 'nullable|string|active_url|max:100',
        ];
    }

    // 4. update
    public function update_user_socials()
    {
        $this->validate();

        $this->user_contact->website = $this->website;
        $this->user_contact->facebook = $this->facebook;
        $this->user_contact->x_twitter = $this->x_twitter;
        // $this->user_contact->linkedin = $this->linkedin;
        $this->user_contact->instagram = $this->instagram;

        $this->user_contact->save();

        $firstFed = FederationMore::orderBy('federation_id', 'asc')->first();

        // no additional fields at all
        if ($firstFed === null) {
            return redirect()
                ->with('success', __("'Personal pages updated successfully.'"))
                ->route('user-contact-modify1', ['uid' => $this->user_contact->user_id]);
        }

        // additional fields form for first federation id
        return redirect()
            ->with('success', __("'Personal pages updated successfully.'"))
            ->route('user-contact-modify5', ['fid' => $firstFed->federation_id, 'uid' => $this->user_contact->user_id]);
    }
}
