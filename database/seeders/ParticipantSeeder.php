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

    public $photo_list = [
        'photo-1522614288668-a697127e9b21.jpg',
        'photo-1568208233063-c4248c650c80.jpg',
        'photo-1570483605254-05f03a791448.jpg',
        'photo-1588070868290-b7dd4472a042.jpg',
        'photo-1600185263071-89deb983edd8.jpg',
        'photo-1613454320437-0c228c8b1723.jpg',
        'photo-1646295433021-926281ff0d6f.jpg',
        'photo-1654073324684-be6e3fca457d.jpg',
        'photo-1682685797743-3a7b6b8d8149.jpg',
        'photo-1682686581551-867e0b208bd1.jpg',
        'photo-1682687220015-186f63b8850a.jpg',
        'photo-1682687220198-88e9bdea9931.jpg',
        'photo-1726137570616-580645d83ebe.jpg',
        'photo-1731331443866-8f6f72027157.jpg',
        'photo-1734842393602-832288710652.jpg',
        'photo-1735014986615-39f7d9aa8610.jpg',
        'photo-1739911013984-8b3bf696a182.jpg',
        'photo-1740231614830-30ce7f2e8dbb.jpg',
        'photo-1740421198589-f98aa30526ac.jpg',
        'photo-1740516367213-f2028a72b097.jpg',
        'photo-1740745492818-0ab54b709586.jpg',
        'photo-1741282198587-65bf77e6075d.jpg',
        'photo-1741509541812-5d8f3e96df23.jpg',
        'photo-1741546694630-b8b4408e3cba.jpg',
        'photo-1741807083060-39c641cd97fa.jpg',
        'photo-1742730709723-5dbb59ada518.jpg',
        'photo-1742816165627-6bcf56e747b1.jpg',
        'photo-1743102254783-e3ea5ffe910a.jpg',
        'photo-1744091212191-add5a525b380.jpg',
        'photo-1744561049964-ccb544a7bea7.jpg',
        'photo-1744690098560-87001ce7c217.jpg',
        'photo-1744749583027-eaef2cf563ba.jpg',
        'photo-1744762561513-6691932920fb.jpg',
        'photo-1744826874736-54ec3ff61a7b.jpg',
        'photo-1744877478622-a78c7a3336f6.jpg',
        'photo-1745276235358-8771fa7eafc5.jpg',
        'photo-1745316387172-63a809701ec9.jpg',
        'photo-1745367228695-a1c7a12df13f.jpg',
        'photo-1745827214444-87a9894fc6b7.jpg',
        'photo-1746022791473-aac2a0500d80.jpg',
        'photo-1746195722714-4987bcd4bdfc.jpg',
        'photo-1746311503228-893ff1507b75.jpg',
        'photo-1747134392756-96ac368ad361.jpg',
        'photo-1747629382448-fde8a1fc8391.jpg',
        'photo-1748357657816-cc98c9c1d552.jpg',
        'photo-1749117631912-df9d281e9744.jpg',
        'photo-1749137598868-94bde1951944.jpg',
        'photo-1749145584776-32db00047168.jpg',
        'photo-1749254995381-802fcc8a2aab.jpg',
        'photo-1749302860502-35be67c058c2.jpg',
        'photo-1750688650077-143cec3d0aa8.jpg',
        'photo-1750757822527-b5adab7136aa.jpg',
        'photo-1750797636255-8c939940bcad.jpg',
        'photo-1751220373368-a5e409ef5370.jpg',
        'photo-1751575004364-a983e57bb428.jpg',
        'photo-1751613453042-97815e9ab072.jpg',
        'photo-1752430038064-250d400e220f.jpg',
        'photo-1752432138935-05f94e6be8f8.jpg',
        'photo-1752867494754-f2f0accbc7d9.jpg',
        'photo-1752892982143-d753acf4a9ae.jpg',
        'photo-1753087451057-f5b21501deb9.jpg',
        'photo-1753379275451-604529ccc444.jpg',
        'photo-1753696053910-1166f7c6751e.jpg',
        'photo-1754597215918-b4b1f113ca77.jpg',
        'photo-1754824321161-764fb98adc71.jpg',
        'photo-1755009013004-a895eed229ef.jpg',
        'photo-1755234647026-ecd6f2e6f086.jpg',
        'photo-1755858454416-2b5513f3f960.jpg',
        'photo-1756213951869-8393128363a2.jpg',
        'photo-1756227584303-f1400daaa69d.jpg',
        'photo-1756634355260-b2f9df55cce1.jpg',
        'photo-1756745678835-00315541d465.jpg',
        'photo-1757532128043-5f52ebb172db.jpg',
        'photo-1758053800208-14eb0520b514.jpg',
        'photo-1758183583798-b7038bca9272.jpg',
        'photo-1758519873981-4638ff8ee79b.jpg',
        'photo-1758575603981-405bdc53c372.jpg',
        'photo-1758963335842-4b025d46f125.jpg',
        'photo-1759122840364-a67d08ff7138.jpg',
        'photo-1759352371478-6071563e058a.jpg',
        'photo-1759800805756-e7b392059a58.jpg',
        'photo-1759833307569-302d70652fd5.jpg',
        'photo-1759936802547-fe9b7df48a5e.jpg',
        'photo-1760276888172-f123e959d4f2.jpg'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->user = User::factory()->create();
        Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' user:' . json_encode($this->user) );
        [$this->last_name, $this->first_name] = explode(', ', $this->user->name );

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

        for ($i=0; $i < 12; $i++) {

            $this->work = Work::factory()->create([
                'user_id'    => $this->user_contact->user_id,
                'work_file'  => str_ireplace('photos/', '', $this->file_to),
                'extension'  => 'jpg',
                'long_side'  => '2500',
                'title_en'   => fake()->text(),
            ]);
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' work:' . json_encode($this->work) );
            $this->work_id = $this->work->id;

            $this->file_to = 'photos/'. $this->user_contact->country_id .'/'. $this->user_contact->last_name
            .'/'. $this->user_contact->first_name .'_'. $this->user_contact->user_id
            .'/'. $this->work_id .'.jpg';
            $this->file_to = str_ireplace(' ', '_', $this->file_to);
            Log::info('Seeder '. __CLASS__ .' f:'. __FUNCTION__.' l:'. __LINE__ . ' ..to:' . json_encode($this->file_to) );

            $this->file_from = 'photos/2500px/'. $this->photo_list[( rand(1,count($this->photo_list)) - 1)];
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
