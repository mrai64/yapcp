<?php

/**
 * Contest definition (Section) Jury Add
 *
 * After validate check if user email s missing in user_contact
 * then insert into
 *
 * 2025-10-14 Set user_role begin n ending at 00:00 and 23:59
 * 2025-12-05 review Log n Country::country_list_by_country()
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
    public $contest_jury;

    public string $section_id;

    public $section;

    public string $contest_id;

    public $contest;

    public $contest_section_list;

    public $jury_opening;

    public $jury_closing;

    public $juror_list;

    public $countries;

    public string $email;

    public string $first_name;

    public string $last_name;

    public string $country_id;

    public $juror;

    /**
     * 1. before the show
     * Not so simple
     * From section id pick contest_id then search first section without
     * juror list, and propose them. If all the section have a juror list
     * of 3 or more, propose to skip to next panel.
     */
    public function mount(string $sid) // as indicate in route section_id
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->section_id = $sid;
        $this->section = ContestSection::where('id', $sid)->get()[0];
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' '.json_encode($this->section));

        // TODO hasOne() $this->section>contest
        $this->contest_id = $this->section['contest_id'];
        $this->contest = Contest::where('id', $this->contest_id)->get()[0];
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' '.$this->contest_id);
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest: '.json_encode($this->contest));
        $this->jury_opening = $this->contest->day_3_jury_opening->format('Y-m-d');
        $this->jury_opening .= ' 00:00:00';
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' jury_opening: '.json_encode($this->jury_opening));
        $this->jury_closing = $this->contest->day_4_jury_closing->format('Y-m-d');
        $this->jury_closing .= ' 23:59:59';
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' jury_opening: '.json_encode($this->jury_closing));

        $this->contest_section_list = ContestSection::where('contest_id', $this->contest_id)->get();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest_section_list: '.$this->contest_section_list);

        $this->countries = Country::country_list_by_country();

        // juror user_id list
        $this->juror_list = [];
        if ((int) ContestJury::count_juror($sid) > 0) {
            $this->juror_list = ContestJury::where('section_id', $sid)->get('user_contact_id');
        }
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' contest_section_list: '.json_encode($this->contest_section_list));

    }

    /**
     * 2. Show to go
     */
    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return view('livewire.contest.jury.add');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return [
            // id
            'email' => 'string|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * 4. at last validate n insert
     *
     * - make users n user_contact if missing
     * - fix day_3_jury_opening time to 00:00:00
     * - fix day_4_jury_closing time to 23:59:59
     */
    public function add_contest_juror()
    {
        // $juror
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        // first
        $validated = $this->validate();
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' validated: '.json_encode($validated));

        // he/she's already in user_contacts?
        $is_in_user_contact = UserContact::where('email', $validated['email'])->count();
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.' '.__LINE__.' is_in: '.$is_in_user_contact);
        // missing
        if ($is_in_user_contact === 0) {
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' try to insert ');

            // add to user & to usercontact
            $juror = User::create(['email' => $validated['email'], 'name' => $validated['last_name'].', '.$validated['first_name'], 'password' => Hash::make($validated['email'])]);
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' user:'.json_encode($juror));

            $juror_contact = UserContact::create(['user_id' => $juror->id, 'country_id' => $validated['country_id'], 'first_name' => $validated['first_name'], 'last_name' => $validated['last_name'], 'email' => $validated['email']]);
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' user_contact:'.json_encode($juror_contact));

        } else {
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' found ');
            // pick missing user_id
            $juror_contact = UserContact::where('email', $validated['email'])->get()[0];
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' user_contact: '.json_encode($juror_contact));

            $juror = new User; // empty
            $juror->id = $juror_contact['user_id'];
            Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' user: '.json_encode($juror));
        }

        // add to userRole or update to avoid dup line when in jury for more than one section
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.' '.__LINE__.' user->id: '.$juror->id);
        if (UserRole::where('user_id', $juror->id)->where('role', 'juror')->where('contest_id', $this->contest_id)->count() === 0) {
            $juror_role = UserRole::create([
                'user_id' => $juror->id,
                'role' => 'juror',
                'contest_id' => $this->contest_id,
                'role_opening' => $this->jury_opening,
                'role_closing' => $this->jury_closing,
            ]);
            Log::info('Component '.__CLASS__.' '.__FUNCTION__.' '.__LINE__.' juror: '.$juror_role);

        }
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.' '.__LINE__.' user->id: '.$juror->id);

        $validated['user_contact_id'] = $juror->id;
        $validated['section_id'] = $this->section_id;
        $validated['is_president'] = 'N'; // TODO change Y/N to 1/0 true/false

        // add to ContestJury
        $section_juror = ContestJury::create($validated);
        Log::info('Component '.__CLASS__.' '.__FUNCTION__.' '.__LINE__.' user->id: '.$juror->id);

        // redirect
        return redirect()
            ->route('contest-jury-add', ['sid' => $this->section_id])
            ->with('success', __('New Juror added to list, enjoy!'));
    }
}
