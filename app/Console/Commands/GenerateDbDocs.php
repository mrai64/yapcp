<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GenerateDbDocs extends Command
{
    protected $signature = 'db:doc';
    protected $description = 'Genera una documentazione Markdown dello schema database';

    public function handle()
    {
        // Definizione del percorso e della cartella
        $path = resource_path('docs/dev/man');
        $fileName = 'dbdoc.md';
        $fullPath = $path . '/' . $fileName;

        // Assicurati che la directory esista, altrimenti creala
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $dbName = config('database.connections.mysql.database');
        $tables = DB::select('SHOW TABLES');
        $tableKey = "Tables_in_" . $dbName;

        // Intestazione del file
        $markdown = "# 🇮🇹 🗄️ Documentazione Schema Database\n\n";
        $markdown .= "> **Valido fino alla data del:** " . now()->format('d/m/Y - H:i:s') . "\n\n";
        $markdown .= "Questa cartella contiene la struttura tecnica del database per il supporto allo sviluppo.\n\n";
        $markdown .= "---\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            // Recuperiamo il commento della tabella
            $tableInfo = DB::select("SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?", [$dbName, $tableName]);
            $tableComment = $tableInfo[0]->TABLE_COMMENT ?? '';

            $markdown .= "## 📋 Tabella: `$tableName` \n";
            if ($tableComment) {
                $markdown .= "**Descrizione:** $tableComment\n\n";
            }

            $markdown .= "| Campo | Tipo | Descrizione | Null | Chiave | Default |\n";
            $markdown .= "| :--- | :--- | :--- | :--- | :--- | :--- |\n";

            // Usiamo SHOW FULL COLUMNS per ottenere i commenti
            $columns = DB::select("SHOW FULL COLUMNS FROM `$tableName`");
            foreach ($columns as $column) {
                // Puliamo il commento se è vuoto
                $comment = $column->Comment ?: '-';

                $markdown .= "| **{$column->Field}** | {$column->Type} | *{$comment}* | {$column->Null} | {$column->Key} | " . ($column->Default ?? '*NULL*') . " |\n";
            }

            // Recupero Relazioni
            $foreignKeys = DB::select("
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$dbName, $tableName]);

            if (count($foreignKeys) > 0) {
                $markdown .= "\n### **Relazioni (Foreign Keys):**\n";
                foreach ($foreignKeys as $fk) {
                    $markdown .= "- 🔗 `{$fk->COLUMN_NAME}` → `{$fk->REFERENCED_TABLE_NAME}({$fk->REFERENCED_COLUMN_NAME})` \n";
                }
            } else {
                $markdown .= "\n### **Relazioni (Foreign Keys):**\n";
                $markdown .= "- ❌ Nessuna relazione trovata.\n";
            }
            
            $markdown .= "\n---\n\n";
        }

        // Rimozione prefisso
        $markdown = str_replace('pcp_', '', $markdown);

        // Salvataggio finale
        File::put($fullPath, $markdown);

        $this->info("✅ Documentazione generata con successo!");
        $this->line("📍 Percorso: <info>$fullPath</info>");
    }
}
