<?php

/**
 * Add Jury member to Contest for a specific section-theme.
 * When missing, add also in users and user_contacts tables.
 * TODO should be used the Notification for new user
 *
 * After validate check if user email is missing in user_contact
 * then insert into users and user_contact
 *
 * 2025-10-14 Set user_role begin n ending at 00:00 and 23:59
 * 2025-12-05 review Log n Country::countriesSorted()
 * 2026-02-16 PSR-12
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
use Livewire\Component;

class Add extends Component
{
    // fields in form and other vars
    public $contest_jury;

    public string $sectionId;

    public $section;

    public string $contest_id;

    public $contest;

    public $contestSectionSet;

    public $juryWorkStart;

    public $juryWorkEnd;

    public $jurySet;

    public $countries;

    public string $jurorEmail;

    public string $jurorFirstName;

    public string $jurorLastName;

    public string $countryId;

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
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $this->sectionId = $sid;
        $this->section = ContestSection::where('id', $sid)->first(); // was: ->get()[0];
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' ' . json_encode($this->section));

        // TODO hasOne() $this->section>contest
        $this->contestId = $this->section['contest_id'];
        $this->contest = Contest::where('id', $this->contestId)->get()[0];
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' ' . $this->contestId);
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contest: ' . json_encode($this->contest));
        $this->juryWorkStart = $this->contest->day_3_jury_opening->format('Y-m-d');
        $this->juryWorkStart .= ' 00:00:00'; // TODO timezone timezone
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' juryWorkStart: ' . json_encode($this->juryWorkStart));
        $this->juryWorkEnd = $this->contest->day_4_jury_closing->format('Y-m-d');
        $this->juryWorkEnd .= ' 23:59:59'; // TODO timezone timezone
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' juryWorkStart: ' . json_encode($this->juryWorkEnd));

        $this->contestSectionSet = ContestSection::where('contest_id', $this->contestId)->get();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contestSectionSet: ' . $this->contestSectionSet);

        $this->countries = Country::countriesSorted();

        // juror user_id list
        $this->jurySet = [];
        if ((int) ContestJury::jurorCount($sid) > 0) { // TODO use exist() instead?
            $this->jurySet = ContestJury::where('section_id', $sid)->get('user_contact_id');
        }
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contestSectionSet: ' . json_encode($this->contestSectionSet));

    }

    /**
     * 2. Show to go
     */
    public function render()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return view('livewire . contest . jury . add');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return [
            // id
            'jurorEmail' => 'string|jurorEmail|max:255',
            'jurorFirstName' => 'required|string|max:255',
            'jurorLastName' => 'required|string|max:255',
            'countryId' => 'required|exists:countries,id',
        ];
    }

    /**
     * 4. at last validate n insert
     *
     * - make users n user_contact if missing
     * - fix day_3_jury_opening time to 00:00:00 timezone timezone
     * - fix day_4_jury_closing time to 23:59:59 timezone timezone
     */
    // was: add_contest_juror
    public function addContestJuror()
    {
        // $juror
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        // first
        $validated = $this->validate();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' validated: ' . json_encode($validated));

        // missing record with that email
        if (UserContact::where('email', $validated['jurorEmail'])->doesntExist()) {
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' try to insert ');

            // add to user & to usercontact
            $juror = User::create([
                'email' => $validated['jurorEmail'],
                'name' => $validated['jurorLastName'] . ', ' . $validated['jurorFirstName'],
                'password' => Hash::make($validated['jurorEmail'])
            ]);
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' user:' . json_encode($juror));

            $jurorUserContact = UserContact::create([
                'id' => $juror->id,
                'country_id' => $validated['countryId'],
                'first_name' => $validated['jurorFirstName'],
                'last_name' => $validated['jurorLastName'],
                'email' => $validated['jurorEmail'],
            ]);
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' user_contact:' . json_encode($jurorUserContact));

        } else {
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' found ');

            // pick missing user_id
            $jurorUserContact = UserContact::where('email', $validated['jurorEmail'])->first(); // was: ->get()[0];
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' user_contact: ' . json_encode($jurorUserContact));

            $juror = User::where('email', $validated['jurorEmail'])->first();
            ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' user: ' . json_encode($juror));
        }

        // add to userRole or update to avoid dup line when in jury for more than one section
        ds('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' user->id: ' . $juror->id);
        if (UserRole::where('user_id', $juror->id)->where('role', 'juror')->where('contest_id', $this->contestId)->doesntExist()) {
            $jurorUserRole = UserRole::create([
                'user_id' => $juror->id,
                'role' => 'juror',
                'contest_id' => $this->contestId,
                'role_opening' => $this->juryWorkStart,
                'role_closing' => $this->juryWorkEnd,
            ]);
            ds('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' juror: ' . $juror_role);

        }
        ds('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' user->id: ' . $juror->id);

        $validated['user_contact_id'] = $juror->id;
        $validated['section_id'] = $this->sectionId;
        $validated['is_president'] = 'N'; // TODO change Y/N to 1/0 true/false

        // add to ContestJury
        $jurorContestAdd = ContestJury::create($validated);
        ds('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' user->id: ' . $juror->id);

        // redirect
        return redirect()
            ->route('contest-jury-add', ['sid' => $this->sectionId])
            ->with('success', __('New Juror added to list, enjoy!'));
    }
}
