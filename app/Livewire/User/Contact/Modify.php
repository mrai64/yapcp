<?php
/**
 * user/contact/modify
 * child of: user
 * 
 * use passport_photo so yes: upload file
 * 2025-09-10: rename col lang into lang_local
 */

namespace App\Livewire\User\Contact;

use Livewire\Component;
use App\Models\Country;
use App\Models\LangList;
use App\Models\TimezonesList;
use App\Models\User;
use App\Models\UserContact;
// use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // passport_photo
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
    public UserContact $user_contact;

    public int $id; //             readonly user_contacts.id bigint unsigned
    public string $user_id; //     readonly users.id        string uuid
    public string $country_id; //           countries.id.   char
    public string $first_name;
    public string $last_name;
    public string $nick_name;

    public string $email;
    public string $email_old; // to assure that 

    public string $cellular;

    public string $passport_photo;
    public $passport_photo_image; // readonly

    public string $address;
    public string $address_line2;
    public string $city;
    public string $region;
    public string $postal_code;

    public string $website;
    public string $facebook;
    public string $x_twitter;
    public string $instagram;
    public string $whatsapp;

    public string $lang_local;
    public array  $lang_list = [];

    public string $timezone;
    public array  $timezone_list = [];

    /**
     * Before the show
     */
    public function mount() // no params in route()
    {
        $user_contact          = New UserContact();
        $this->id              = $user_contact->where('user_id', Auth::id() )->pluck('id')[0];
        $this->user_contact    = $user_contact->find( $this->id );

        $this->id             = $this->user_contact->id;
        $this->user_id        = $this->user_contact->user_id;
        $this->country_id     = $this->user_contact->country_id;
        $this->first_name     = $this->user_contact->first_name;
        $this->last_name      = $this->user_contact->last_name;
        $this->nick_name      = $this->user_contact->nick_name;
        $this->email          = $this->user_contact->email;
        $this->email_old      = $this->user_contact->email;
        $this->cellular       = $this->user_contact->cellular;
        $photo_name           = $this->user_contact->passport_photo;
        // $photo_name = str_ireplace('%20', ' ', $photo_name);
        // $photo_name = str_ireplace('+',   '',  $photo_name);
        $this->passport_photo = $photo_name; // img path, not in form
        $this->address        = $this->user_contact->address;
        $this->address_line2  = $this->user_contact->address_line2;
        $this->city           = $this->user_contact->city;
        $this->region         = $this->user_contact->region;
        $this->postal_code    = $this->user_contact->postal_code;
        $this->lang_list      = LangList::lang_list;
        $this->lang_local     = $this->user_contact->lang_local;
        $this->timezone       = $this->user_contact->timezone;
        $this->timezone_list  = TimezonesList::timezones_list;
        $this->website        = $this->user_contact->website;
        $this->facebook       = $this->user_contact->facebook;
        $this->x_twitter      = $this->user_contact->x_twitter;
        $this->instagram      = $this->user_contact->instagram;
        $this->whatsapp       = $this->user_contact->whatsapp;
        //
        $this->passport_photo_image = null;
    }
    /**
     * Show on
     */
    public function render()
    {
        $countries = New Country();
        $this->countries = $countries->allByCountry();

        return view('livewire.user.contact.modify');
    }
    /**
     * Validation rules 1 / 2
     */
    public function rules() {
        return [
            'id' => 'required|exists:user_contacts,id',
            'user_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nick_name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'cellular' => 'integer|min_digits:6|max_digits:14|min:1',
            'passport_photo' => 'nullable|string|max:255',
            'passport_photo_image' => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'address' => 'string|max:255',
            'address_line2' => 'string|max:255',
            'city' => 'string|max:255',
            'region' => 'string|max:255',
            'postal_code' => 'string|max:10',
            'website' => 'string|active_url|max:255',
            'facebook' => 'string|active_url|max:255',
            'x_twitter' => 'string|active_url|max:255',
            'instagram' => 'string|active_url|max:255',
            'whatsapp' => 'string|active_url|max:255',
            'lang_local' => 'string|max:5',
            'timezone' => 'string|max:40',
        ];
    }
    /**
     * validation rules 2 / 2
     */
    public function after() 
    {
        return [
            function (Validator $validator) {
                // lang_local

                // timezone
                if (!in_array( $this->timezone, TimezonesList::timezones_list )){
                    $validator->errors()->add(
                        'timezone',
                        __('Must be one of list')
                    );
                }
            }
        ];
    }

    /**
     * After the show,... update?
     */
    public function update()
    {
        // apply the rules
        $validated = $this->validate();
        
        $this->user_contact->country_id     = $this->country_id;
        $this->user_contact->first_name     = $this->first_name;
        $this->user_contact->last_name      = $this->last_name;

        // where is him/her photo_box?
        $photo_path = $this->user_contact->photo_box();

        // see also: https://livewire.laravel.com/docs/uploads#storing-uploaded-files
        $photo_name = $photo_path .  '/' . '__passport_photo.jpg';
        $photo_name = str_ireplace(':', '-', $photo_name);
        $photo_name = str_ireplace('+', '',  $photo_name);
        $photo_name = str_ireplace(' ', '-', $photo_name);

        if ($this->passport_photo_image){
            $this->passport_photo_image->storePubliclyAs( 'photos', $photo_name, 'public' );
            $this->passport_photo = $photo_name;
        }

        // reset
        $this->email = $this->email_old;

        $this->user_contact->update(
            $this->all()
        );
        // 
        // back to dashboard 
        return redirect()
            ->route('dashboard', ['id' => $this->user_id ] )
            ->with('success', __('Your personal info has been updated, thanks!'));
    }
}
