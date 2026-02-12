<?php

/**
 * auxiliary table
 * - for user_contacts
 * - for federations
 * - for organizations
 * - for contests
 */

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dload external source from https://github.com/mledoze/countries
        $json = file_get_contents('https://raw.githubusercontent.com/mledoze/countries/master/countries.json');
        $countries = json_decode($json, true);

        foreach ($countries as $c) {
            Country::updateOrCreate(
                ['id' => $c['cca3']], // iso-3166 alpha-3
                [
                    'country'      => $c['name']['common'],
                    'flag_code'    => $c['flag'] ?? '',
                    'lang_code'    => array_key_first($c['languages'] ?? ['en' => '']),
                    'locale'       => array_key_first($c['languages'] ?? ['en' => '']) . '_' . $c['cca2'],
                    'calling_code' => ($c['idd']['root'] ?? '') . ($c['idd']['suffixes'][0] ?? ''),
                ]
            );
        }
    }
}
