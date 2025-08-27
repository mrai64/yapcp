<?php

namespace Database\Seeders;

use App\Models\Federation;
use Database\Factories\FederationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Federation::factory()->create([
            'country_id' => 'LUX',
            'code' => 'FIAP',
            "name" => "Fédération Internationale de l'Art Photographique",
            "website" => 'https://www.fiap.net/en/',
        ]);
        Federation::factory()->create([
            'country_id' => 'ITA',
            'code' => 'FIAF',
            "name" => "Federazione Italiana Associazioni Fotografiche",
            "website" => 'https://www.fiaf.net/',
            "contact" => "corso San Martino, 8\n10122 Torino TO"
        ]);
        Federation::factory()->create([
            'country_id' => 'ITA',
            'code' => 'UIF',
            "name" => "Unione Italiana Fotoamatori",
            "website" => 'https://www.unioneitalianafotoamatori.it/',
            "contact" => "Via Acque 9\n17045 Mallare SV"
        ]);

        Federation::factory()->count(2)->create();
    }
}
