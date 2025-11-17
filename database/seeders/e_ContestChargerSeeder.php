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

class e_ContestChargerSeeder extends Seeder
{
    public $today;
    public $opened_contest;
    public $contest_section_list;
    public $contest_section;
    public $user_in_user_role;
    public $user_in_contest;
    public $excluded_ids;
    public $work;
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

        if ($this->opened_contest === NULL) {
            echo "\n"."no open contest"."\n";
            return;
        }
        echo "\n"."{$this->opened_contest->name_en} \n";

        // 2. all section
        $this->contest_section_list = ContestSection::where('contest_id', $this->opened_contest->id)->get();
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' section_list:'. json_encode($this->contest_section_list) );
        
        // 4. user_id in user_roles
        $this->user_in_user_role = DB::table( UserRole::table_name)->get('user_id');
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' user_role_in:'. json_encode( $this->user_in_user_role) );

        // from collection to array - old way
        $this->excluded_ids = [];
        foreach($this->user_in_user_role as $key => $user_id){
            $this->excluded_ids[]=$user_id;
        }
        // 4.b already in 
        $this->user_in_contest = ContestParticipant::select('user_id')->where('contest_id', $this->opened_contest->id)->get();
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' already_in:'. ($this->user_in_contest) );
        // from collection to array - old way
        foreach($this->user_in_user_role as $key => $user_id){
            $this->excluded_ids[] = $user_id;
        }
        // Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' exclude_list:'. json_encode($this->excluded_ids) );
        
        // infinite loop risk is not zero dot zero periodic
        // i j k index more clear ind_i ind_j ind_k
        for ($i=0; $i < 24 ; ) { 

            // Random user
            // $this->work_participant = DB::table( UserContact::table_name)
            //     ->select('user_contacts.*')
            //     ->orderBy(DB::raw('RAND()'))
            //     ->take(5)
            //     ->first();
            $this->work_participant = UserContact::whereNull('deleted_at')->inRandomOrder()->first();
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' candidate:'. json_encode($this->work_participant) );

            // excluded_ids is user already in + user in user_roles 
            if ( in_array( $this->work_participant->user_id, $this->excluded_ids)) {
                Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' out:'. json_encode($this->work_participant->user_id) );
                continue;
            }
            echo "\n";

            // new, he's /she's must be added
            $this->user_participant = ContestParticipant::create([
                'contest_id' => $this->opened_contest->id,
                'user_id'    => $this->work_participant->user_id,
                'fee_payment_completed' => 'Y',
            ]);
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' new work_participant:'. json_encode($this->work_participant) );

            $i++;
            echo "\n ". sprintf('%03d', $i).' '.$this->work_participant->country_id.' | '.$this->work_participant->last_name.' '.$this->work_participant->first_name;
            echo "\n ". sprintf('%03d', $i);

            foreach ($this->contest_section_list as $this->contest_section) {
                Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' Section:'. ($this->contest_section->name_en) );
                echo " ".$this->contest_section->name_en . " ";

                for ($j=1; $j <= $this->contest_section->rule_max; ) { 

                    // picked casually from works table 
                    // $this->work = DB::table(Work::table_name)
                    //     ->select(Work::table_name.'.*')
                    //     ->orderBy(DB::raw('RAND()'))
                    //     ->take(5)->first();
                    $this->work = Work::whereNull('deleted_at')->inRandomOrder()->first();
                    Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' work_id:'. json_encode($this->work) );

                    $present = ContestWork::where('contest_id', $this->opened_contest->id)
                        ->where('section_id', $this->contest_section->id)
                        ->where('work_id', $this->work->id)
                        ->count();

                    if ($present){
                        echo ' DUP:' . $this->work->id;
                        continue;
                    }

                    $this->added_work = ContestWork::create([
                        'contest_id' => $this->opened_contest->id,
                        'section_id' => $this->contest_section->id,
                        'country_id' => $this->work_participant->country_id,
                        'user_id'    => $this->work_participant->user_id,
                        'work_id'    => $this->work->id,
                        'portfolio_sequence' => ($j),
                    ]);
                    $j++;
                    Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' new work_participant:'. json_encode($this->added_work) );

                    $this->file_to = 'contests/' . $this->opened_contest->id .'/'. $this->contest_section->id .'/'. $this->work->id .'.'. $this->work->extension;
                    $this->copy_result = Storage::disk('public')->copy( 'photos/'.$this->work->work_file, $this->file_to);
                    echo ($this->copy_result) ? '✅ ' : "\n".'🥸 from:'. $this->work->work_file .' to:'. $this->file_to."\n";

                } // for j
            } // foreach

        } //  for i
        echo "\n";
        echo "\n";
    } // run
} // class
