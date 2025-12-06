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

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Federation::factory()->create([
            'id' => 'FIAP',
            'country_id' => 'LUX',
            'name_en' => "Fédération Internationale de l'Art Photographique",
            // local_lang
            // name_local
            // timezone_id
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
            'website' => 'https://www.unioneitalianafotoamatori.it/',
            'contact_info' => "Via Acque 9\n17045 Mallare SV",
        ]);
        Federation::factory()->create([
            'country_id' => 'GRC',
            'id' => 'GPU',
            'name_en' => 'Global Photographic Union',
            'website' => 'https://www.gpuphoto.com/',
        ]);
        Federation::factory()->create([
            'country_id' => 'USA',
            'id' => 'PAA',
            'name_en' => 'Photographic Alliance of America',
            'website' => 'https://www.paausa.org/',
        ]);

    }
}
