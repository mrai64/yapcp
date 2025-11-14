<?php
/**
 * 2025-10-16 based on new table release
 */
namespace Database\Seeders;

use App\Models\Federation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;

class FederationSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // FederationSection::factory()->count(10)->create();
        // $federation_id = Federation::where('code', 'FIAF')->get('id')->first();
        // Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' FND id:' . $federation_id );

        Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called' );
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'BN',
            'name_en'       => 'Open M',
            'local_lang'    => 'it',
            'name_local'    => 'Libero Bianconero',
            'file_formats'  => 'jpg',
            'monochromatic_required' => true,
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'VR',
            'name_en'       => 'Mandatory M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Obbligato (unico)',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'VRA',
            'name_en'       => 'Mandatory M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Obbligato 1',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'VRB',
            'name_en'       => 'Mandatory M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Obbligato 2',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'VRC',
            'name_en'       => 'Mandatory M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Obbligato 3',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'CL',
            'name_en'       => 'Open C',
            'local_lang'    => 'it',
            'name_local'    => 'Libero Colore',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'CL/TRAD',
            'name_en'       => 'Open C',
            'local_lang'    => 'it',
            'name_local'    => 'Libero Colore TRADITIONAL',
            'file_formats'  => 'jpg',
            'raw_required'  => true,
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'LB',
            'name_en'       => 'Open M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Libero',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'LB/TRAD',
            'name_en'       => 'Open M & C TRADITIONAL',
            'local_lang'    => 'it',
            'name_local'    => 'Libero TRADITIONAL',
            'file_formats'  => 'jpg',
            'raw_required'  => true,
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'NA',
            'name_en'       => 'Nature (w/RAW)',
            'local_lang'    => 'it',
            'name_local'    => 'Natura (c/RAW)',
            'file_formats'  => 'jpg',
            'raw_required'  => true,
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'NW',
            'name_en'       => 'Wildlife Nature (w/RAW)',
            'local_lang'    => 'it',
            'name_local'    => 'Natura Wildlife (c/RAW)',
            'file_formats'  => 'jpg',
            'raw_required'  => true,
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'CR',
            'name_en'       => 'Creativity M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Creatività',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'AE',
            'name_en'       => 'Aerial (drone allowed) M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Aerea',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'SM',
            'name_en'       => 'Smartphone cameras M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Smartphone o tablet',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'PN',
            'name_en'       => 'Landscape M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Panoramica',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'PA',
            'name_en'       => 'Landscape M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Paesaggio',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'PA/TRAD',
            'name_en'       => 'Landscape M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Paesaggio TRADITIONAL',
            'file_formats'  => 'jpg',
            'raw_required'  => true,
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'ST',
            'name_en'       => 'Street M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Street Photography',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'RF',
            'name_en'       => 'Studio, Portrait M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Ritratto e Figura ambientata',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'AR',
            'name_en'       => 'Architecture M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Architettura',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'SL',
            'name_en'       => 'Still Life M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Still Life',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'NU',
            'name_en'       => 'Nude, Glamour M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Nudo e Glamour',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'SP',
            'name_en'       => 'Sport M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Sport',
            'file_formats'  => 'jpg',
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'RP',
            'name_en'       => 'Photojournalism, Reportage M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Reportage e Fotogiornalismo',
            'file_formats'  => 'jpg',
            'min_works'     => 8,
            'max_works'     => 12,
        ]);
        FederationSection::factory()->create([
            'federation_id' => 'FIAF',
            'code'          => 'TR',
            'name_en'       => 'Travel M & C',
            'local_lang'    => 'it',
            'name_local'    => 'Viaggi',
            'file_formats'  => 'jpg',
        ]);

    }
}
