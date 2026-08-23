# Docs: FederationSection Delete (eliminazione di un record)

> **Branch:** `docs/0193-federation-section-delete`  
> **Stato:** In Corso
> **priorità:** A  
> **id assegnato:** 2026-08-16.04  
> **Titolo e urgenza:** (A) docs: FederationSection / documentazione procedura di eliminazione (admin group)  
> **Project/issue link:** [#193](https://github.com/mrai64/yapcp/issues/193)
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

---

## 📝 Logica Tecnica

La procedura gestisce la rimozione in sicurezza di una sezione federativa (`FederationSection`) con richiesta di conferma finale ("LAST CALL"), implementata con architettura **Volt / Livewire 4** e cancellazione logica **Eloquent SoftDeletes**.

### 1. Architettura e Flusso Volt / Livewire 4

- **Inizializzazione Stato (`mount` / `state`):**
  - Riceve l'istanza `FederationSection` tramite *route model binding*.
  - Inizializza e mappa le proprietà del modello (`code`, `name_en`, `synopsis`, `min_works`, `max_works`, `short_size_max`, `long_size_max`, `file_size_max`, `monochromatic_required`, `raw_required`, `unique_prize`) assieme alla relazione `Federation`.
- **Interfaccia Read-Only di Verifica:**
  - Presenta in consultazione i dati identificativi, la sinossi, i limiti operativi di invio opere e i requisiti tecnici (file monocromatico, RAW obbligatorio, non cumulabilità dei premi).
- **Azione di Eliminazione (`removeFederationSection`):**
  - Scatenata al submit del form con l'azione Livewire `wire:submit="removeFederationSection"`.
  - Esegue la cancellazione invocando `$this->federationSection->delete()`.
  - Traccia l'operazione nei log di sistema via `Log::info()` e `Log::debug()` registrando lo stato dell'oggetto eliminato.
  - Esegue un redirect con session flash message (`with('success', ...)`) verso la rotta `federation-section.listed` legata alla federazione genitore.

### 2. Modello Eloquent (`FederationSection.php`) e Database

- **Soft Deletes:** Il modello utilizza il trait `Illuminate\Database\Eloquent\SoftDeletes`, garantendo che la chiamata a `delete()` imposti la colonna `deleted_at` senza rimuovere fisicamente il record dal database.
- **Relazioni:** Definisce la relazione `belongsTo` con il modello `Federation` tramite la chiave esterna `federation_id`.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- Nessuna nuova migrazione richiesta: le colonne utilizzate sono già definite e gestite nella tabella `federation_sections`.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Nessuna migrazione da eseguire.
- Nessun parametro `.env` aggiuntivo richiesto.
