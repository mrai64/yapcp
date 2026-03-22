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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Use a local file or
     * Download external source from https://github.com/mledoze/countries
     *
     */
    public function run()
    {
        $this->command->info(__CLASS__ . "...");
        $filePath = 'private/countries.json';
        $remoteUrl = 'https://raw.githubusercontent.com/mledoze/countries/master/countries.json';

        // check local file
        if (!Storage::disk('local')->exists($filePath)) {
            $this->command->info("Missing local file - Give reference json from github");
            try {
                // pick
                $response = Http::get($remoteUrl);
                if ($response->successful()) {
                    Storage::disk('local')->put($filePath, $response->body());
                    $this->command->info("Saved local");
                } else {
                    throw new \Exception("Not saved local file - Countries reference json from github status:"
                        . $response->status());
                }
                //
            } catch (\Throwable $th) {
                // throw $th;
                Log::error("Error in CountrySeeder picking remote json file with: " . $th->getMessage());
                $this->command->error("Blocked bu error: " . $th->getMessage());
                return;
            }
        }
        //
        $json = Storage::disk('local')->get($filePath);
        $countries = json_decode($json, true);
        if (is_array($countries)) {
            $this->command->getOutput()->progressStart(count($countries));

            foreach ($countries as $c) {
                Country::updateOrCreate(
                    ['id' => $c['cca3']], // country code alpha 3 >> iso-3166 alpha-3
                    [
                        'country'      => $c['name']['common'],
                        'flag_code'    => $c['flag'] ?? '',
                        'lang_code'    => Str::limit(array_key_first($c['languages'] ?? ['en' => '']), 2, ''),
                        'locale'       => Str::limit(array_key_first($c['languages'] ?? ['en' => '']), 2, '')
                            . '_' . $c['cca2'],
                        'calling_code' => ($c['idd']['root'] ?? '') . ($c['idd']['suffixes'][0] ?? ''),
                    ]
                );
                $this->command->getOutput()->progressAdvance();
            }
            //
            $this->command->getOutput()->progressFinish();
            $this->command->info("Done");
        }
    }
}
