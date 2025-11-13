<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ContestVoteSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "\n" . __CLASS__;
        echo "\n" . "Find contest";
        $contests_set =  Contest::all();
        foreach($contests_set as $contest){
            
            echo "\n***********************************************************************************************************";
            echo "\n*** Contest:" . $contest->name_en;
            echo "\n***********************************************************************************************************";
            
            $sections_set = ContestSection::where('contest_id', $contest->id)->get();
            
            foreach($sections_set as $section) {
                echo "\n\n***********************************************************************************************************";
                echo "\nSection:" . $section->name_en;
                echo "\n***********************************************************************************************************";
                
                $jurors_set = ContestJury::where('section_id', $section->id)->get();
                
                $contest_works_set = ContestWork::where('section_id', $section->id)->where('contest_id', $contest->id)->get();
                
                foreach($contest_works_set as $contest_work){
                    
                    foreach($jurors_set as $juror){
                        
                        $already_voted = ContestVote::where('section_id', $section->id)->where('contest_id', $contest->id)->where('work_id', $contest_work->id)->where('juror_user_id', $juror->id)->count();
                        
                        if ($already_voted){
                            echo ' .';
                            continue;
                        }
                        
                        $vote = rand(2,6)+rand(2,6)+rand(2,6)+rand(2,6)+rand(2,6)+rand(0,6);
                        if ($vote > 30) {
                            $vote = 30;
                        }
                        
                        $inserted  = ContestVote::create([
                            'contest_id'    => $contest->id,
                            'section_id'    => $section->id,
                            'work_id'       => $contest_work->id,
                            'juror_user_id' => $juror->id,
                            'vote'          => $vote,
                        ]);
                        
                        echo ("\n".'Seeder '. __CLASS__ .' inserted '. $inserted->id . ' vote:'. $vote .' rec:'. json_encode($inserted) );
                        
                    } // $jurors_set
                } // contest_work_set
                echo "\n\n***********************************************************************************************************";
                echo "\n*** Section change ****************************************************************************************";
                echo "\n***********************************************************************************************************";
            } // sections_set
        } // contests_set
    }
}
