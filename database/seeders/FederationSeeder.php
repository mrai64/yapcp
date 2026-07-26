<?php

/**
 * after
 * - countries
 *
 * 2025-10-16 based on new table release
 */

namespace Database\Seeders;

use App\Models\Federation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        //
        Federation::firstOrCreate(
            [ 'id' => 'FIAP', ],
            [
            'country_id' => 'LUX',
            'name_en' => "Fédération Internationale de l'Art Photographique",
            // local_lang
            // name_local
            'timezone_id' => 'Europe/Luxembourg',
            'website' => 'https://www.fiap.net/en/',
            'contact_info' => ' ',
        ]
        );
        Federation::firstOrCreate(
            [ 'id' => 'FIAF', ],
            [
            'country_id' => 'ITA',
            'name_en' => "Italian Photographic Society' Federation",
            'local_lang' => 'it',
            'name_local' => 'Federazione Italiana Associazioni Fotografiche',
            'timezone_id' => 'Europe/Rome',
            'website' => 'https://www.fiaf.net/',
            'contact_info' => "Via Vallaraita, 3\n10126 Torino TO",
        ]
        );
        Federation::firstOrCreate(
            [ 'id' => 'UIF', ],
            [
            'country_id' => 'ITA',
            'name_en' => 'Italian Photoamateurs Union',
            'local_lang' => 'it',
            'name_local' => 'Unione Italiana Fotoamatori',
            'timezone_id' => 'Europe/Rome',
            'website' => 'https://www.unioneitalianafotoamatori.it/',
            'contact_info' => "Via Acque 9\n17045 Mallare SV",
        ]
        );
        Federation::firstOrCreate(
            [ 'id' => 'GPU', ],
            [
            'country_id' => 'GRC',
            'name_en' => 'Global Photographic Union',
            'website' => 'https://www.gpuphoto.com/',
            'timezone_id' => 'Europe/Athens',
            ]
        );
        Federation::firstOrCreate(
            [ 'id' => 'PAA', ],
            [
            'country_id' => 'USA',
            'name_en' => 'Photographic Alliance of America',
            'website' => 'https://www.paausa.org/',
            'timezone_id' => 'America/Chicago',
        ]
        );
        Federation::firstOrCreate(
            [ 'id' => 'IAAP', ],
            [
            'country_id' => 'MKD', // North Macedonia
            'name_en' => 'International Association of Art Photographers',
            'website' => 'https://theiaap.com/',
            'timezone_id' => 'Europe/Skopje',
            'contact_info' => 'e: officeiaap@gmail.com, t: +389 78240006',
        ]
        );
        Federation::firstOrCreate(
            [ 'id' => 'RPS', ],
            [
            'country_id' => 'GBR', // Great Britain - United Kingdom
            'name_en' => 'Royal Photographic Society, The -',
            'website' => 'https://rps.org/',
            'timezone_id' => 'Europe/London',
            'contact_info' => 'HERE _ 470 Bath Road - Bristol - United Kingdom, t: +44 117 316 4450',
            ]
        );
        Federation::firstOrCreate(
            [ 'id' => 'IIG', ],
            [
            'country_id' => 'IND', // India
            'name_en' => 'India International Group',
            'website' => 'https://indiainternationalgroup.com/',
            'timezone_id' => 'Asia/Kolkata', // formerly Asia/Calcutta
            'contact_info' => 'e: email@threedots.in, t: +91 880 116 6930',
        ]
        );
        //
        Schema::enableForeignKeyConstraints();
        //
    }
}
