<?php
/**
 * user for lazy livewire to load voted works
 * 
 */

namespace App\Livewire\Contest\Jury;

use App\Models\ContestVote;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Voteddias extends Component
{

    public $vid;
    public $contest_work;

    /**
     * check if a path/namefile has a twin path/300px_namefile 
     * @return string miniature|original
     */
    public static function miniature(string $original_file) : string 
    {
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' called');
        $last_slash_pos = strrpos($original_file, '/');
        $path = substr($original_file, 0, $last_slash_pos + 1);
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' path:' . $path);
        $name_file  = '300px_'.substr($original_file, $last_slash_pos + 1);
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' name:' . $name_file);
        if (Storage::disk('public')->exists('contests/'.$path.$name_file) ) {
            Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' found' );
            return $path . $name_file;
        }
        Log::info('Component '. __CLASS__ .' f/'. __FUNCTION__.':'.__LINE__ . ' not found' );
        return $original_file;
    }

    public function mount( string $vid) // livewire voted_id
    {
        $this->contest_work = ContestVote::where('id', $vid)->first();
    }

    /**
     * @return string html  
     */
    public function placeholder()
    {
        return "\n".'<div style="float:left;width:300px;height:calc(300px + 2rem);display:block;text-center;background-color:#f0f0f0;margin-top:.5rem;margin-right:.5rem;"> <p style="float:left;" class="fyk text-xl z-50">{{ __("Assigned vote: ") }}<span class="text-black font-semibold">##</span></p> <span class="inline-flex justify-end"><a href="#" >[ + / - ]</a></span> <div style="width:300px !important;height:300px !important;background-color:#f0f0f0;border:10px solid #ccc;display:flex;justify-content: center;align-items: center;box-shadow: 0 0 10px rgba(0,0,0,0.2);"> Loading </div> </div>';
    }

    public function render()
    {
        return view('livewire.contest.jury.voteddias');
    }
}
