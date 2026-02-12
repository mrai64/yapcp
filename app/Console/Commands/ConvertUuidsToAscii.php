<?php

/**
 * Command added to convert uuid w/character:utf8mb4 in character:ascii
 * one use only
 * - find fields char(36) (uuid are)
 * - generate sql alter
 * - execute alter after confirm
 * 
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertUuidsToAscii extends Command
{
    protected $signature = 'db:uuid-to-ascii {--execute : Esegue effettivamente le query}';
    protected $description = 'Genera SQL per convertire colonne UUID da utf8mb4 a ASCII';

    public function handle()
    {
        // Recupera tutte le tabelle del database (escluse quelle di sistema)
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $keyName = "Tables_in_{$dbName}";

        $queries = [];

        foreach ($tables as $table) {
            $tableName = $table->$keyName;

            // escludo le VIEW
            if (str_contains($tableName, '_view')) {
                continue;
            }

            // Cerca colonne char(36) o che contengono 'uuid' nel nome
            $columns = DB::select("SHOW FULL COLUMNS FROM `{$tableName}` WHERE Type = 'char(36)'");

            foreach ($columns as $column) {
                // Se è già ASCII, saltiamo
                if ($column->Collation === 'ascii_general_ci') {
                    continue;
                }

                $queries[] = "ALTER TABLE `{$tableName}` MODIFY `{$column->Field}` CHAR(36) CHARACTER SET ascii COLLATE ascii_general_ci " . ($column->Null === 'YES' ? 'NULL' : 'NOT NULL') . ";";
            }
        }

        if (empty($queries)) {
            $this->info("Tutte le colonne UUID sono già in ASCII o non ne sono state trovate.");
            return;
        }

        $this->warn("Query generate:");
        foreach ($queries as $query) {
            $this->line($query);
        }

        if ($this->option('execute')) {
            if ($this->confirm('Vuoi eseguire queste modifiche? Assicurati di avere un backup!')) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                foreach ($queries as $query) {
                    DB::statement($query);
                }
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                $this->info("Conversione completata con successo.");
            }
        } else {
            $this->info("\nUsa il flag --execute per applicare le modifiche.");
        }
    }
}
