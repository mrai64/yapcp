<?php
/**
 * Contest (Section) Jury Add
 *
 *
 */
namespace App\Livewire\Contest\Jury;

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\Country;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Add extends Component
{
    // fields in form and other vars
    public        $contest_jury;

    public string $section_id;
    public        $section;
    public string $contest_id;
    public        $contest;
    public        $contest_section_list;

    public        $juror_list;
    public        $countries;

    public string $email;
    public string $first_name;
    public string $last_name;
    public string $country_id;
    public        $user;

    /**
     * 1. before the show
     * Not so simple
     * From section id pick contest_id then search first section without
     * juror list, and propose them. If all the section have a juror list
     * of 3 or more, propose to skip to next panel.
     */
    public function mount(string $sid) // as indicate in route section_id
    {
        $this->section_id = $sid;
        $this->section = ContestSection::whereNull('deleted_at')->where('id', $sid)->get()[0];
        Log::info( __FUNCTION__ . ' ' . __LINE__ . $this->section );

        $this->contest_id = $this->section['contest_id'];
        $this->contest = Contest::where('id', $this->contest_id)->get()[0];
        Log::info( __FUNCTION__ . ' ' . __LINE__ . ' contest_id: ' . $this->contest_id );
        Log::info( __FUNCTION__ . ' ' . __LINE__ . ' contest: ' . $this->contest );

        $this->contest_section_list = ContestSection::where('contest_id', $this->contest_id )->get();
        Log::info( __FUNCTION__ . ' ' . __LINE__ . ' contest_section_list: ' . $this->contest_section_list);
        
        $countries = new Country();
        $this->countries = $countries->allByCountry();
        
        $this->juror_list = [];
        if ( (int) ContestJury::count_juror( $sid ) > 0 ){
            $this->juror_list = ContestJury::where('section_id', $sid)->get('user_contact_id');
        }
        Log::info( __FUNCTION__ . ' ' . __LINE__ . ' contest_section_list: ' . $this->contest_section_list);

    }

    /**
     * 2. Show to go
     */
    public function render()
    {
        return view('livewire.contest.jury.add');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        return [
            // id
            'email'      => 'string|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];

    }

    /**
     * 4. after first validation a second validation step
     */
    public function after()
    {

    }

    /**
     * 5. at last validate n insert
     */
    public function add_contest_juror()
    {
        // first
        $validated = $this->validate();
        Log::info( __FUNCTION__ . ' ' . __LINE__);
        // is already in userContact?
        $is_in_user_contact = UserContact::whereNull('deleted_at')->where('email', $validated['email'])->count();
        Log::info( __FUNCTION__ . ' ' . __LINE__. ' is_in: ' . $is_in_user_contact);
        // missing
        if ($is_in_user_contact === 0) {
            Log::info( __FUNCTION__ . ' ' . __LINE__. ' ');
            // add to user & to usercontact
            $user = User::create(['email' => $validated['email'], 'name' => $validated['last_name'].', '.$validated['first_name'], 'password' => Hash::make($validated['email']) ]);
            Log::info( __FUNCTION__ . ' ' . __LINE__. ' ');

            $user_contact = UserContact::create(['user_id' => $user->id, 'country_id' => $validated['country_id'], 'first_name' => $validated['first_name'], 'last_name' => $validated['last_name'], 'email' => $validated['email'], ]);
            Log::info( __FUNCTION__ . ' ' . __LINE__. ' ');
        } else {
            Log::info( __FUNCTION__ . ' ' . __LINE__. ' ');
            // pick missing user_id
            $user_contact = UserContact::where('email', $validated['email'])->get()[0];
            Log::info( __FUNCTION__ . ' ' . __LINE__. ' ');
            $user = new User();
            $user->id = $user_contact['user_id'];
            Log::info( __FUNCTION__ . ' ' . __LINE__. ' user->id: '. $user->id);
        }

        // add to userRole
        Log::info( __FUNCTION__ . ' ' . __LINE__. ' user->id: '. $user->id);
        $user_role = UserRole::create(['user_id' => $user->id, 'role' => 'juror', 'contest_id' => $this->contest_id]);
        Log::info( __FUNCTION__ . ' ' . __LINE__. ' user->id: '. $user->id);

        $validated['user_contact_id'] = $user->id;
        $validated['section_id'] = $this->section_id;
        $validated['is_president'] = 'N';
        // add to ContestJury
        $section_juror = ContestJury::create($validated);
        Log::info( __FUNCTION__ . ' ' . __LINE__. ' user->id: '. $user->id);

        // redirect
        return redirect()
          ->route('contest-jury-add', ['sid' => $this->section_id ])
          ->with('success', __('New Juror added to list, enjoy!') );

    }
}
