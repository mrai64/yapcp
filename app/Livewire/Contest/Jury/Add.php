<?php

/**
 * Organization add Jury member to Contest for a specific section-theme.
 * Juror may be picked from platform users but
 * when missing, add also in users and user_contacts tables.
 * Validation is based on user email, when is missing in user_contact
 * must be added / insert into User and UserContact models
 *
 * TODO should be used the Notification for new user
 *
 * 2025-10-14 Set user_role begin n ending at 00:00 and 23:59
 * 2025-12-05 review Log n Country::countriesSorted()
 * 2026-02-16 PSR-12
 * 2026-04-21 reformat addContestJuror()
 *
 * @see /resources/views/livewire/contest/jury/add.blade.php
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
    public ContestSection $section;

    public string $sectionId;

    public Contest $contest;

    public $contestSectionSet;

    // fields in form and other vars
    public $contest_jury;

    public string $contestId;

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
    public function mount(ContestSection $section) // as in route())
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ .' called');
        $this->section = $section;
        $this->sectionId = $section->id;
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' ' . json_encode($this->section));

        $this->contest = $this->section->contest;
        $this->contestId = $this->section->contest_id;
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contest: ' . json_encode($this->contest));
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contest id:' . $this->contestId);
        $this->juryWorkStart = $this->contest->day_3_jury_opening->format('Y-m-d');
        $this->juryWorkStart .= ' 00:00:00'; // TODO timezone timezone
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' juryWorkStart: ' . json_encode($this->juryWorkStart));
        $this->juryWorkEnd = $this->contest->day_4_jury_closing->format('Y-m-d');
        $this->juryWorkEnd .= ' 23:59:59'; // TODO timezone timezone
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' juryWorkStart: ' . json_encode($this->juryWorkEnd));

        $this->contestSectionSet = ContestSection::where('contest_id', $this->contestId)
            ->orderBy('code', 'asc')
            ->get();
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' contestSectionSet: ' . $this->contestSectionSet);

        $this->countries = Country::countriesSorted();
    }

    /**
     * 2. Show to go
     */
    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        // juror user_id list
        $this->jurySet = ContestJury::where('section_id', $this->sectionId)
            ->with('userContact')
            ->get();
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' jurySet: ' . json_encode($this->jurySet));

        return view('livewire.contest.jury.add');
    }

    /**
     * 3. validation rules
     */
    public function rules()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return [
            // id
            'jurorEmail' => 'required|email|max:255',
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
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        // first
        $validated = $this->validate();
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' validated: ' . json_encode($validated));

        // new or know
        $juror = User::firstOrCreate(
            ['email' => $validated['jurorEmail']],
            [
                'name' => $validated['jurorLastName'] . ', ' . $validated['jurorFirstName'],
                'password' => Hash::make($validated['jurorEmail']) // temporary password based on email
            ]
        );
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' User instance: ' . json_encode($juror));

        // Gestione Contatto: crea o aggiorna i dettagli anagrafici
        $jurorUserContact = UserContact::updateOrCreate(
            ['id' => $juror->id],
            [
                'country_id' => $validated['countryId'],
                'first_name' => $validated['jurorFirstName'],
                'last_name' => $validated['jurorLastName'],
                'email' => $validated['jurorEmail'],
            ]
        );
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' UserContact instance: ' . json_encode($jurorUserContact));

        // add to userRole or update to avoid dup line when in jury for more than one section
        Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' user->id: ' . $juror->id);
        $jurorUserRole = UserRole::updateOrCreate(
            [
                'user_id' => $juror->id,
                'role' => 'juror',
                'contest_id' => $this->contestId,
            ],
            [
                'role_opening' => $this->juryWorkStart,
                'role_closing' => $this->juryWorkEnd,
            ]
        );
        Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' jurorUserRole: ' . json_encode($jurorUserRole));

        // add to ContestJury
        $jurorContestJury = ContestJury::updateOrCreate(
            [
                'section_id' => $this->sectionId,
                'user_contact_id' => $juror->id,
            ],
            [
                'is_president' => 'N',
            ]
        );
        Log::info('Component ' . __CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' jurorContestJury: ' . json_encode($jurorContestJury));

        // redirect
        return redirect()
            ->route('organization.contest-jury.add', ['sid' => $this->sectionId])
            ->with('success', __('New Juror added to list, enjoy!'));
    }
}
