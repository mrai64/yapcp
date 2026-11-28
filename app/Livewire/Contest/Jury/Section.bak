<?php

/**
 * Contest Jury Section data
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
    public string $dataJson;

    public $data;

    public ContestSection $contest_section;

    public Contest $contest;

    public $today;

    public $open;

    /**
     * 1. Before the show
     */
    public function mount(string $dataJson) // @livewire
    {
        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called dataJson:'.$dataJson);
        $this->data = json_decode($dataJson);

        $this->contest_section = ContestSection::where('id', $this->data->section_it)->first();

        $this->contest = $this->contest_section->contest;

        // $this->today = (new CarbonImmutable("now"))->format("Y-m-d");
        $this->today = CarbonImmutable::now()->toDateTimeString(); // yyyy-mm-ddThh:ii:ss.000000
        if ($this->today < $this->contest->day_3_jury_opening) {
            $this->open = false;
        } elseif ($this->today > $this->contest->day_4_jury_closing) {
            $this->open = false;
        } else {
            $this->open = true;

        }

        Log::info('Component '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out this:'.json_encode($this));
    }

    /**
     * 2. Show adn done
     */
    public function render()
    {
        return view('livewire.contest.jury.section');
    }
}
