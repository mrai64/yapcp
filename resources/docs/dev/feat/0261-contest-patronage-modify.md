# Feature: Modifica Patrocinio Federazione al Concorso (ContestPatronage)

> **Branch:** `feat/0261-contest-patronage-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-01.01  
> **Titolo e urgenza:** (A) feat: ContestPatronage / Modify - blade  
> **Project/issue link:** [#261](https://github.com/mrai64/yapcp/issues/261)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Questa funzionalità consente a un'organizzazione autorizzata di modificare un patrocinio di una federazione fotografica (`ContestPatronage`) precedentemente associato a uno specifico concorso (`Contest`).

### Scelte di Design e Architettura

1. **Componente Livewire Volt (Single File Component):**
   - Implementato nel file view `resources/views/livewire/organization/design/contest-patronage/modify.blade.php`.
   - **Autorizzazione (`mount`):** 
     All'inizializzazione del componente viene verificata la policy `$this->authorize('update', [ContestPatronage::class, $contest_patronage])`. 
     L'autorizzazione consente l'accesso agli utenti amministratori (`isAdmin()`) oppure ai membri effettivi dell'organizzazione proprietaria del concorso collegato.
   - **Caricamento e Pre-popolamento dati:** 
     Nel metodo `mount(ContestPatronage $contest_patronage)` vengono associati i modelli `contest` e `organization`. Viene inoltre caricato l'elenco delle federazioni (`Federation`) con eager loading della relazione paese (`with(['country'])`), ordinato per `country_id` e `name_en`. I campi del form `$contPatrFederationId` e `$contPatrPatronageCode` vengono pre-popolati con i valori attuali del record.

2. **Validazione e Regole di Business:**
   - Regole definite nel metodo `rules()`:
     - `contPatrFederationId`: obbligatorio (`required`), stringa, deve esistere nella tabella `federations` (colonna `id`).
     - `contPatrPatronageCode`: obbligatorio (`required`), stringa, forzato in maiuscolo (`uppercase`), lunghezza massima 20 caratteri (`max:20`).

3. **Strategia di Salvataggio e Modifica (`modifyContestPatronage`):**
   - Esecuzione della validazione tramite `$this->validate()`.
   - **Stessa Federazione:** Se la federazione selezionata coincide con quella originale (`$this->contestPatronage->federation_id == $validated['contPatrFederationId']`), viene eseguito un semplice `$this->contestPatronage->update(['patronage_code' => $validated['contPatrPatronageCode']])`.
   - **Cambio Federazione:** Se la federazione viene modificata, il record precedente viene archiviato/eliminato via Soft Delete (`$this->contestPatronage->delete()`) e viene creato un nuovo record `ContestPatronage` con la nuova associazione (`contest_id`, `federation_id`, `patronage_code`). Questo preserva la cronologia e garantisce la corretta tracciabilità.
   - **Reindirizzamento:** Al termine dell'operazione, l'utente viene reindirizzato all'elenco dei patrocini del concorso (`organization.design.contest-patronage.listed`) con messaggio flash di successo (`success`).

4. **Interfaccia Utente (Blade):**
   - Header integrato con barra di navigazione del concorso (`x-yapcp.organization.design.contest-nav` con tab attivo `patronages`) e breadcrumb verso User Dashboard, Organization Dashboard e Patronages List.
   - Visualizzazione dei messaggi di errore e di successo.
   - Form reattivo con menu a tendina delle federazioni (mostra codice bandiera paese, codice ID federazione e denominazione inglese) e campo input formattato per il codice di patrocinio.
   - Bottone di invio per la verifica e il salvataggio.

5. **Copertura Test (Pest):**
   - Test di feature completi posizionati in `tests/Feature/m004/i0261/ContestPatronageModifyTest.php`:
     - Protezione da accessi non autenticati (redirect al login per i guest).
     - Protezione da accessi non autorizzati (403 Forbidden per utenti non membri dell'organizzazione).
     - Accesso consentito via HTTP GET per membri dell'organizzazione e per amministratori.
     - Montaggio corretto del componente Volt con i dati preesistenti.
     - Happy path per modifica del codice a parità di federazione.
     - Happy path per modifica con cambio di federazione (verifica soft delete del vecchio record e creazione del nuovo).
     - Validazione dei campi obbligatori, esistenza della federazione a database, formato maiuscolo e limiti di lunghezza.

---

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Utilizzo della tabella esistente `contest_patronages` (modello `ContestPatronage`).
  - `id`: Chiave primaria (`integer`, auto-incrementing).
  - `contest_id`: FK verso `contests.id` (`string`).
  - `federation_id`: FK verso `federations.id` (`string`).
  - `patronage_code`: Codice identificativo del patrocinio (`string`, max 20).
  - Soft deletes gestito tramite colonna `deleted_at`.
- [x] Nessuna nuova migration richiesta per questa funzionalità di modifica.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)
- [x] **Docs:** Il file in `/resources/docs/dev/feat/0261-contest-patronage.modify.md` è aggiornato
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte per la modifica dei patrocini
- [x] **Cleanup:** Nessun `dd()`, `dump()` o log di debug non necessario nel componente
- [x] **Commit:** I messaggi dei commit sono chiari e seguono le convenzioni del repository

---

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Assicurarsi che le rotte per `organization.design.contest-patronage.modify` siano registrate e attive in `routes/web.php`.
- Verificare la corretta configurazione dei permessi e delle policy in `ContestPatronagePolicy`.
