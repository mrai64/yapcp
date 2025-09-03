<?php
/**
 * user/contact/modify
 * child of: user
 * 
 * 
 */

namespace App\Livewire\User\Contact;

use Livewire\Component;
use App\Models\Country;
use App\Models\User;
use App\Models\UserContact;
use Livewire\Attributes\Validate;
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

    // UserContact
    public UserContact $user_contact;

    #[Validate('required|exists:user_contacts,id')]
    public int $id; //             readonly user_contacts.id bigint unsigned

    #[Validate('required|exists:users,id')]
    public string $user_id; //     readonly users.id        string uuid

    #[Validate('required|exists:countries,id')]
    public string $country_id; //           countries.id.   char

    #[Validate('required|string|max:255')]
    public string $first_name;

    #[Validate('required|string|max:255')]
    public string $last_name;

    #[Validate('string|max:255')]
    public string $nick_name;

    #[Validate('string|email|max:255')]
    public string $email;
    public string $email_old; // to assure that 

    #[Validate('integer|min_digits:6|max_digits:14|min:1')]
    public string $cellular;

    #[Validate('nullable|string|max:255')]
    public string $passport_photo;
    
    #[Validate('nullable|image|mimes:jpg,png,webp|max:2048')]
    public $passport_photo_image; // readonly

    #[Validate('string|max:255')]
    public string $address;

    #[Validate('string|max:255')]
    public string $address_line2;

    #[Validate('string|max:255')]
    public string $city;

    #[Validate('string|max:255')]
    public string $region;

    #[Validate('string|max:10')]
    public string $postal_code;

    #[Validate('string|active_url|max:255')]
    public string $website;

    #[Validate('string|active_url|max:255')]
    public string $facebook;

    #[Validate('string|active_url|max:255')]
    public string $x_twitter;

    #[Validate('string|active_url|max:255')]
    public string $instagram;

    #[Validate('string|active_url|max:255')]
    public string $whatsapp;

    /**
     * Before the show
     */
    public function mount(string $uid) // named uid as in route()
    {
        $user_contact          = New UserContact();
        $this->id              = $user_contact->where('user_id', $uid)->pluck('id')[0];
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
        $this->website        = $this->user_contact->website || '';
        $this->facebook       = $this->user_contact->facebook || '';
        $this->x_twitter      = $this->user_contact->x_twitter || '';
        $this->instagram      = $this->user_contact->instagram || '';
        $this->whatsapp       = $this->user_contact->whatsapp || '';
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
     * Validation rules
     * 
     * See definition fields
     * 
     */

    /**
     * After the show,... update?
     */
    public function update()
    {
        // apply the rules
        $this->validate();
        
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
