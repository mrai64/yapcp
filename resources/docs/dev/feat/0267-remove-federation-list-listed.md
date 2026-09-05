# Feature: Open Contest List - Rimuovere federation_list e aggiungere getContestPatronages

> **Branch:** `feat/0267-remove-federation-list-listed`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-08-02.03  
> **Titolo e urgenza:** Organization / Contest Design / Contest Listed - rimuovere campo federation_list  
> **Project/issue link:** [#267](https://github.com/mrai64/yapcp/issues/267)
> **Milestone link:** [M1](https://github.com/mrai64/yapcp/milestones/1)

---

## 📝 Logica Tecnica

Il model `ContestPatronages` sostituisce il precedente campo `federation_list` della tabella contests.
Anziché mantenere una stringa delimitata con i codici di patrocinio, abbiamo creato una tabella relazionale dedicata
che memorizza il legame contest → federation → patronage_code.

**Perché:** Una tabella relazionale garantisce:

> <!-- to avoid index in Larecipe -->
- Integrità referenziale (constraint su contest_id e federation_id)
- Query more efficient con eager loading (`.with('patronages')`)
- Facilità di modifica/eliminazione dei singoli patrocini
- Migliore separazione delle responsabilità

Nella blade di visualizzazione concorsi aperti, al posto del campo `federation_list`, aggiungiamo una lettura eager
della relazione `hasMany` verso `ContestPatronages` e iteriamo sui record per esporre i dati.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `2026_02_22_220039_create_contest_patronages_table`
- [x] Aggiunta relazione `hasMany` in Contest model verso ContestPatronages
- [ ] Rimuovere colonna `federation_list` da contests table (prossimo step)
- [ ] Aggiornare test per Pest

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Eseguire `php artisan migrate` per creare la tabella contest_patronages
- Aggiungere eager loading nella blade: `.with('contestPatronages')` sulla query contestuale, e non solo patronages
- Aggiornare il manuale utente per riflettere il nuovo flusso di selezione patrocini
- Verificare che i dati legacy di federation_list siano migrati alla nuova tabella (script di migrazione dati)

---

### 🔗 Branch correlati

> <!-- to avoid index in Larecipe -->
- **feat/0209-contest-remove-federation-list** (branch parallela per il refactor principale)

### 📚 Documentazione correlata

> <!-- to avoid index in Larecipe -->
- File: `app/Models/ContestPatronages.php`
- File: `app/Models/Contest.php`
- Migration: `database/migrations/2026_02_22_220039_create_contest_patronages_table.php`
