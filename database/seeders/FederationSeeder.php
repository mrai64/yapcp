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
        Federation::truncate();
        Schema::enableForeignKeyConstraints();
        //
        Federation::factory()->create([
            'id' => 'FIAP',
            'country_id' => 'LUX',
            'name_en' => "Fédération Internationale de l'Art Photographique",
            // local_lang
            // name_local
            'timezone_id' => 'Europe/Rome',
            'website' => 'https://www.fiap.net/en/',
            'contact_info' => ' ',
        ]);
        Federation::factory()->create([
            'id' => 'FIAF',
            'country_id' => 'ITA',
            'name_en' => "Italian Photographic Society' Federation",
            'local_lang' => 'it',
            'name_local' => 'Federazione Italiana Associazioni Fotografiche',
            'timezone_id' => 'Europe/Rome',
            'website' => 'https://www.fiaf.net/',
            'contact_info' => "corso San Martino, 8\n10122 Torino TO",
        ]);
        Federation::factory()->create([
            'id' => 'UIF',
            'country_id' => 'ITA',
            'name_en' => 'Italian Photoamateurs Union',
            'local_lang' => 'it',
            'name_local' => 'Unione Italiana Fotoamatori',
            'timezone_id' => 'Europe/Rome',
            'website' => 'https://www.unioneitalianafotoamatori.it/',
            'contact_info' => "Via Acque 9\n17045 Mallare SV",
        ]);
        Federation::factory()->create([
            'country_id' => 'GRC',
            'id' => 'GPU',
            'name_en' => 'Global Photographic Union',
            'website' => 'https://www.gpuphoto.com/',
            'timezone_id' => 'Europe/Athens',
            ]);
        Federation::factory()->create([
            'country_id' => 'USA',
            'id' => 'PAA',
            'name_en' => 'Photographic Alliance of America',
            'website' => 'https://www.paausa.org/',
            'timezone_id' => 'America/Chicago',
        ]);
        Federation::factory()->create([
            'country_id' => 'MKD', // North Macedonia
            'id' => 'IAAP',
            'name_en' => 'International Association of Art Photographers',
            'website' => 'https://theiaap.com/',
            'timezone_id' => 'Europe/Skopje',
            'contact_info' => 'e: officeiaap@gmail.com, t: +389 78240006',
        ]);
        Federation::factory()->create([
            'country_id' => 'GBR', // Great Britain - United Kingdom
            'id' => 'RPS',
            'name_en' => 'Royal Photographic Society, The -',
            'website' => 'https://rps.org/',
            'timezone_id' => 'Europe/London',
            'contact_info' => 'HERE _ 470 Bath Road - Bristol - United Kingdom, t: +44 117 316 4450',
        ]);
        Federation::factory()->create([
            'country_id' => 'IND', // India
            'id' => 'IIG',
            'name_en' => 'India International Group',
            'website' => 'https://indiainternationalgroup.com/',
            'timezone_id' => 'Asia/Kolkata', // formerly Asia/Calcutta
            'contact_info' => 'e: email@threedots.in, t: +91 880 116 6930',
        ]);

    }
}
