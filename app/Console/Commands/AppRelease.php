<?php

/**
 * Build app version
 * - make version as yyyy.mm.n
 * - register in storage app/version.json
 *
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AppRelease extends Command
{
    // Questo definisce come chiamerai il comando
    protected $signature = 'app:release';
    protected $description = '🇮🇹 Aggiorna la versione del progetto (YYYY.MM.Patch)';

    public function handle()
    {
        $fileName = 'version.json';
        $year = date('Y');
        $month = date('n'); // m: mese con zeri iniziali 01-12 | n: Mese senza zeri iniziali (1-12)

        // Carica i dati esistenti o crea default
        if (Storage::disk('local')->exists($fileName)) {
            $data = json_decode(Storage::disk('local')->get($fileName), true);
        } else {
            $data = ['major' => $year, 'minor' => $month, 'patch' => 0];
        }

        // Se l'anno o il mese sono cambiati, resetta il patch a 1
        // Altrimenti incrementa il patch esistente
        if ($data['major'] != $year || $data['minor'] != $month) {
            $data['major'] = (int)$year;
            $data['minor'] = (int)$month;
            $data['patch'] = 1;
        } else {
            $data['patch']++;
        }

        $data['full'] = "{$data['major']}.{$data['minor']}.{$data['patch']}";

        // Salva nel file storage/app/version.json
        Storage::disk('local')->put($fileName, json_encode($data, JSON_PRETTY_PRINT));
        $path = storage_path('app/' . $fileName);

        $this->info("🇮🇹 Versione aggiornata con successo: " . $data['full']);
    }
}
