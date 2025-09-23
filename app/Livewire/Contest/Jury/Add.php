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
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserRole;
use Livewire\Component;

class Add extends Component
{
    // fields in form and other vars 
    public        $contest_jury;
    public        $juror_list = Null;

    public        $contest_section;
    public array  $contest_section_id_list;
    public string $section_id;

    public        $contest;
    public string $contest_id;

    public        $user;
    public string $user_id;
    public        $user_contact;
    public        $user_role;

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
        $this->contest_section = ContestSection::whereNull('deleted_at')->where('id', $sid)->get();
        /**
         * cerco la section passando dal contest_id > elenco delle section > lettura giurie per ogni section
         * > quando trovo meno di 3 giurati passo fuori.
         */
        $this->contest = Contest::whereNull('deleted_at')->where('id', $this->contest_section['contest_id']);
        $this->contest_section_id_list = $this->contest_section->get_section_list( $this->contest_section->contest_id );
        foreach($this->contest_section_id_list as $section) {
            $this->section_id = $section->id;
            $this->juror_list = ContestJury::juror_list_for_section( $section->id);
            if (count($this->juror_list) < 3) {
                $this->contest_section = ContestSection::whereNull('deleted_at')->where('id', $section->id )->get();
                break;
            }
        }
        // Se ci sono già giurati? se ne voglio mettere 11?
        if ($this->juror_list === Null){

        }
        
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
    public function addContestJuror()
    {

    }
}
