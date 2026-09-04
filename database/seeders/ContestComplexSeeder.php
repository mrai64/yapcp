<?php

/**
 * Generazione di un concorso fake oer testare gli elenchi di concorsi
 *  ! TODO Va modificato che ogni volta genera lo stesso concorso
 *
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestJury;
use App\Models\ContestAward;
use App\Models\ContestPatronage;
use App\Models\Organization;
use App\Models\Country;
use App\Models\Timezone;
use App\Models\Federation;
use App\Models\UserContact;
use Illuminate\Support\Str;

class ContestComplexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Peschiamo elementi esistenti dal database (o fallback se vuoti)
        $organization = Organization::inRandomOrder()->first();
        $country = $organization->country;
        $timezone = Timezone::inRandomOrder()->first();
        ;
        $federations = Federation::take(2)->get();
        // Peschiamo alcuni contatti utente da usare come giurati
        $jurors = UserContact::take(15)->get();

        if (!$organization || !$country || !$timezone || $federations->count() < 2 || $jurors->count() < 3) {
            $this->command->warn("Assicurati di aver eseguito prima i seeder di base (Country, Timezone, Organization, Federation, User) per poter pescare i record.");
            return;
        }

        // 2. Creazione del Concorso principale
        $contest = Contest::create([
            'id' => Str::uuid(),
            'country_id' => $country->id,
            'name_en' => fake()->text(40) . ' 2026',
            'organization_id' => $organization->id,
            'is_circuit' => false,
            'federation_list' => '', // 'FIAP PSA',
            'contact_info' => 'email: info@photocontest2026.example',
            'timezone_id' => $timezone->id,
            'vote_rule' => 'num:1..10',
            'day_1_opening' => now()->subDays(15),
            'day_2_closing' => now()->addDays(30),
            'day_3_jury_opening' => now()->addDays(32),
            'day_4_jury_closing' => now()->addDays(40),
            'day_5_revelations' => now()->addDays(45),
            'day_6_awards' => now()->addDays(50),
            'day_7_catalogues' => now()->addDays(60),
            'day_8_closing' => now()->addDays(90),
            'fee_info' => 'Entry fee 20 EUR',
            'award_ceremony_info' => 'Online Streaming Platform',
        ]);

        // 3. Creazione di almeno 2 Patrocini per il concorso
        foreach ($federations as $index => $federation) {
            ContestPatronage::create([
                'contest_id' => $contest->id,
                'federation_id' => $federation->id,
                'patronage_code' => '2026/' . ($index + 105),
            ]);
        }

        // 4. Creazione dei 2 Premi Generali per il Concorso (codice sezione vuoto/null)
        $globalAwards = [
            ['code' => 'G-01', 'name' => 'Best Author of the Contest'],
            ['code' => 'G-02', 'name' => 'Grand Prix Trophy'],
        ];

        foreach ($globalAwards as $gAward) {
            ContestAward::create([
                'id' => Str::uuid(),
                'contest_id' => $contest->id,
                'section_id' => null,
                'section_code' => null, // Codice sezione vuoto come richiesto
                'award_code' => $gAward['code'],
                'award_name' => $gAward['name'],
                'is_award' => true,
            ]);
        }

        // 5. Creazione di almeno 3 Sezioni
        $sectionsData = [
            ['code' => 'COL', 'name' => 'Open Color'],
            ['code' => 'MON', 'name' => 'Open Monochrome'],
            ['code' => 'NAT', 'name' => 'Nature Wildlife'],
        ];

        $jurorIndex = 0;

        foreach ($sectionsData as $sData) {
            $section = ContestSection::create([
                'id' => Str::uuid(),
                'contest_id' => $contest->id,
                'code' => $sData['code'],
                'under_patronage' => true,
                'name_en' => $sData['name'],
                'synopsis' => 'General section description for ' . $sData['name'],
                'file_formats' => 'jpg,jpeg',
                'min_works' => 1,
                'max_works' => 4,
                'short_size_max' => 1080,
                'long_size_max' => 1920,
                'file_size_max' => 2048000,
                'monochromatic_required' => ($sData['code'] === 'MONO'),
                'raw_required' => false,
                'unique_prize' => false,
            ]);

            // 6. Creazione di una Giuria per ogni sezione (es. 3 giurati per sezione pescati dagli utenti)
            for ($j = 0; $j < 3; $j++) {
                if (isset($jurors[$jurorIndex])) {
                    ContestJury::create([
                        'id' => Str::uuid(),
                        'contest_id' => $contest->id,
                        'section_id' => $section->id,
                        'user_id' => $jurors[$jurorIndex]->id,
                        'is_president' => ($j === 0), // Il primo è il presidente
                    ]);
                    $jurorIndex++;
                }
            }

            // 7. Creazione di 5 Premi per ogni Sezione
            for ($p = 1; $p <= 5; $p++) {
                ContestAward::create([
                    'id' => Str::uuid(),
                    'contest_id' => $contest->id,
                    'section_id' => $section->id,
                    'section_code' => $section->code,
                    'award_code' => $section->code . '-AW-' . $p,
                    'award_name' => $section->name_en . ' Prize ' . $p,
                    'is_award' => ($p <= 3), // I primi 3 sono premi principali, gli ultimi 2 menzioni/altro
                ]);
            }
        }

        $this->command->info('Concorso, sezioni, giurie, patrocini e premi creati con successo!');
    }
}
