<?php
/**
 * There is no Participant table to seed, but
 * that a complex seeder run that need
 * - generate a user
 * - cenerate a user_contacts related to new user
 * - generare almost a 20 images to put in new user Photobox
 *
 */
namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use App\Models\UserContact;
use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParticipantSeeder extends Seeder
{
    public $user;
    public $country = [
        'ITA',
        'ITA',
        'ITA',
        'ITA',
        'ITA',
        'FRA',
        'VAT',
        'AUS',
        'AUT',
        'CHN',
        'CHN',
        'CHN',
        'CHN',
        'CHN',
        'IND'
    ];
    public $user_contact;
    public $first_name;
    public $last_name;
    public $work;

    public $work_id;
    public $file_from;
    public $file_to;
    public $copy_result;

    public $photo_list;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->user = User::factory()->create();
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' user:' . json_encode($this->user) );
        [$this->last_name, $this->first_name] = explode(', ', $this->user->name );
        $this->photo_list = Storage::disk('public')->files('photos/2500px');
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' user:' . json_encode($this->photo_list) );

        $this->user_contact = UserContact::where('user_id', $this->user->id)->first();
        $this->user_contact->update([
            'country_id' => $this->country[( rand(1,count($this->country)) - 1)],
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'nick_name'  => '',
            'cellular'   => fake()->PhoneNumber(),
            'website'    => '',
            'facebook'   => '',
            'x_twitter'  => '',
            'instagram'  => '',
            'whatsapp'   => '',
        ]);
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' user:' . json_encode($this->user_contact) );
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' user:' . json_encode($this->user_contact) );

        for ($i=0; $i < 12; $i++) {

            $this->work = Work::factory()->create([
                'user_id'    => $this->user_contact->user_id,
                'work_file'  => '',
                'extension'  => 'jpg',
                'long_side'  => '2500',
                'title_en'   => fake('en')->text(rand(15,40)),
            ]);
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' work:' . json_encode($this->work) );
            $this->work_id = $this->work->id;

            $this->file_to = 'photos/'. $this->user_contact->country_id .'/'. $this->user_contact->last_name
            .'/'. $this->user_contact->first_name .'_'. $this->user_contact->user_id
            .'/'. $this->work_id .'.jpg';
            $this->file_to = str_ireplace(' ', '_', $this->file_to);
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' ..to:' . json_encode($this->file_to) );

            $this->file_from = $this->photo_list[( rand(1,count($this->photo_list)) - 1)];
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' from:' . json_encode($this->file_from) );
            // Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' from?:' . (Storage::disk('public')->fileExists($this->file_from) ?"✅":"🟥") );

            // $this->copy_result = Storage::copy( $this->file_from, $this->file_to );
            $this->copy_result = Storage::disk('public')->copy( $this->file_from, $this->file_to );
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' copy res:' . ($this->copy_result ?"✅":"🟥") );

            $this->work->update([
                'work_file' => str_ireplace('photos/', '', $this->file_to )
            ]);
            $this->work->save();
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' work:' . json_encode($this->work) );
        }
    }
}
