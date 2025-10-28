<?php
/**
 * Contest Jury Section data
 *
 */

namespace App\Livewire\Contest\Jury;

use App\Models\Contest;
use App\Models\ContestSection;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Section extends Component
{
    // input
    public string          $data_json;
    public                 $data;
    public ContestSection  $contest_section;
    public Contest         $contest;
    public                 $today;
    public                 $open;
    /**
     * 1. Before the show
     */
    public function mount(string $data_json) // @livewire
    {
        Log::info('Component ' . __CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called data_json:'. $data_json);
        $this->data = json_decode($data_json);

        $this->contest_section = ContestSection::where('id', $this->data->section_it )->first();

        $this->contest         = $this->contest_section->contest;

        $this->today           = (new CarbonImmutable("2025-11-13"))->format("Y-m-d");
        if ( $this->today < $this->contest->day_3_jury_opening ){
            $this->open = false;
        } elseif ( $this->today > $this->contest->day_4_jury_closing ) {
            $this->open = false;
        } else {
            $this->open = true;

        }

        Log::info('Component ' . __CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out this:'. json_encode($this));
    }
    /**
     * 2. Show adn done
     */
    public function render()
    {
        return view('livewire.contest.jury.section');
    }
}
