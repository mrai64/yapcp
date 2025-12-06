<?php

namespace Database\Seeders;

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\ContestVote;
use App\Models\ContestWork;
use Illuminate\Database\Seeder;

class ContestVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "\n".__CLASS__;
        echo "\n".'Find contest';
        $contests_set = Contest::all();
        echo "\n".'§ contest #'.$contests_set->count();

        foreach ($contests_set as $contest) {

            echo "\n***********************************************************************************************************";
            echo "\n*** Contest:".$contest->name_en;
            echo "\n***********************************************************************************************************";

            $sections_set = ContestSection::where('contest_id', $contest->id)->get();
            echo "\n".'§ Section #:'.$sections_set->count();

            foreach ($sections_set as $section) {
                echo "\n\n***********************************************************************************************************";
                echo "\nSection:".$section->name_en;
                echo "\n***********************************************************************************************************";

                $jurors_set = ContestJury::where('section_id', $section->id)->get();
                echo "\n".'§ Jury members #: '.$jurors_set->count();

                $contest_works_set = ContestWork::where('contest_id', $contest->id)->where('section_id', $section->id)->get();
                echo "\n".'§ section_id:'.$section->id.' Work_set #: '.$contest_works_set->count();

                foreach ($contest_works_set as $contest_work) {

                    foreach ($jurors_set as $juror) {

                        $already_voted = ContestVote::where('section_id', $section->id)
                            ->where('work_id', $contest_work->work_id)
                            ->where('contest_id', $contest->id)
                            ->where('juror_user_id', $juror->user_contact_id)->count();

                        if ($already_voted) {
                            // $contest_work->delete();
                            // echo ' DUP DEL';
                            echo ' .';

                            continue;
                        }
                        // assuming $contest->vote_rule == 'num:1..10'
                        // $vote = rand(2,4)+rand(2,4)+rand(0,5)
                        // if ($vote > 10) {
                        //     $vote = 10;
                        // }

                        // assuming $contest->vote_rule == 'num:1..30'
                        $vote = rand(0, 1) + rand(0, 2) + rand(0, 6) + rand(3, 6) + rand(3, 6) + rand(3, 6);
                        if ($vote > 30) {
                            $vote = 30;
                        }

                        $inserted = ContestVote::create([
                            'contest_id' => $contest->id,
                            'section_id' => $section->id,
                            'work_id' => $contest_work->work_id,
                            'juror_user_id' => $juror->user_contact_id,
                            'vote' => $vote,
                        ]);

                        echo "\n".'Seeder '.__CLASS__.' inserted '.$inserted->id.' vote:'.$vote.' rec:'.json_encode($inserted);

                    } // $jurors_set
                } // contest_work_set
                echo "\n\n***********************************************************************************************************";
                echo "\n*** Section change ****************************************************************************************";
                echo "\n***********************************************************************************************************\n";
            } // sections_set
        } // contests_set
    }
}
