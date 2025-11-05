<?php
/**
 * Contest charger seeder
 *
 * 1. Search fr a open contest
 * 2. find all its sections
 * 3. for every section
 * 4. find 4 dozen of participants
 * 5. find for every participant 4 works
 * 6. add works to contest.
 * 7. add user participant
 *
 * php artisan db:seed --class=ContestChargerSeeder
 *
 *
 */
namespace Database\Seeders;

use App\Models\Contest;
use App\Models\ContestParticipant;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserRole;
use App\Models\Work;
use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContestChargerSeeder extends Seeder
{
    public $today;
    public $opened_contest;
    public $contest_section_list;
    public $contest_section;
    public $user_in_user_role;
    public $user_in_contest;
    public $excluded_ids;
    public $id;
    public $work_participant;
    public $added_work;
    public $copy_result;
    public $file_to;
    public $user_participant;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->today = CarbonImmutable::now()->toDateTimeString(); // yyyy-mm-ddThh:ii:ss.000000
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' today:'. $this->today );

        // 1. open contest
        $this->opened_contest = Contest::where('day_3_jury_opening', '<=', $this->today)->where('day_4_jury_closing', '>=', $this->today )->inRandomOrder()->first();
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' contest:'. json_encode($this->opened_contest) );

        echo "{$this->opened_contest->name_en} \n";

        // 2. all section
        $this->contest_section_list = ContestSection::where('contest_id', $this->opened_contest->id)->get();
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' section_list:'. json_encode($this->contest_section_list) );
        
        // 4. user_id in user_roles
        $this->user_in_user_role = DB::table( UserRole::table_name)->get('user_id');
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' user_role_in:'. json_encode( $this->user_in_user_role) );
        $this->excluded_ids = [];
        foreach($this->user_in_user_role as $key => $user_id){
            $this->excluded_ids[]=$user_id;
        }
        $this->user_in_contest = ContestParticipant::select('user_id')->where('contest_id', $this->opened_contest->id)->get();
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' already_in:'. ($this->user_in_contest) );
        foreach($this->user_in_user_role as $key => $user_id){
            $this->excluded_ids[] = $user_id;
        }
        // Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' exclude_list:'. json_encode($this->excluded_ids) );
        
        // infinite loop risk is not zero dot zero periodic
        // i j k index
        for ($i=0; $i < 24 ; ) { 
            # code...
            $this->work_participant = DB::table( UserContact::table_name)
                ->select('user_contacts.*')
                ->orderBy(DB::raw('RAND()'))
                ->take(5)
                ->first();
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' candidate:'. json_encode($this->work_participant) );
            // out if already in or had any (too large) role as juror, organizatin etc.
            // right exclusion only if role is in organization and juror in conest
            if ( in_array( $this->work_participant->user_id, $this->excluded_ids)) {
                Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' out:'. json_encode($this->work_participant->user_id) );
                continue;
            }
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' new work_participant:'. json_encode($this->work_participant) );
            $i++;
            echo "\n ". sprintf('%d03', $i);

            foreach ($this->contest_section_list as $this->contest_section) {
                Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' Section:'. ($this->contest_section->name_en) );
                echo " ".$this->contest_section->name_en . " ";
                for ($j=0; $j < $this->contest_section->rule_max; $j++) { 
                    $this->id = DB::table(Work::table_name)
                        ->select(Work::table_name.'.*')->orderBy(DB::raw('RAND()'))
                        ->take(5)->first();
                    Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' work_id:'. json_encode($this->id) );
                    $this->added_work = ContestWork::create([
                        'contest_id' => $this->opened_contest->id,
                        'section_id' => $this->contest_section->id,
                        'country_id' => $this->work_participant->country_id,
                        'user_id'    => $this->work_participant->user_id,
                        'work_id'    => $this->id->id,
                        'portfolio_sequence' => ($j + 1),
                    ]);
                    Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' new work_participant:'. json_encode($this->added_work) );

                    $this->file_to = 'contests/' . $this->opened_contest->id .'/'. $this->contest_section->id .'/'. $this->id->id .'.'. $this->id->extension;
                    $this->copy_result = Storage::disk('public')->copy( 'photos/'.$this->id->work_file, $this->file_to);
                    echo ($this->copy_result) ? '✅ ' : '🥸 ';

                } // for j
            } // foreach

            // 7. add user contest participant 
            if ( ContestParticipant::where('contest_id', $this->opened_contest->id )->where('user_id', $this->work_participant->user_id )->count() === 0) {
                $this->user_participant = ContestParticipant::create([
                    'contest_id' => $this->opened_contest->id,
                    'user_id'    => $this->work_participant->user_id,
                    'fee_payment_completed' => 'Y',
                ]);
            }
        } //  for i
        echo "\n";
    } // run
} // class
