# Feature: Revisione lista opere sospese

> **Branch:** `feat/0375-contest-waiting-remove`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-10.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Manage Before Jury / ContestWaiting - remove   
> **Project/issue link:** [#375](https://github.com/mrai64/yapcp/issues/375)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La funzione implementa un sistema di gestione della lista delle opere in attesa di chiarimenti (ContestWaiting) e la loro rimozione una volta risolti i problemi.

### Obiettivo

Consentire agli esaminatori di organizzazione di:
1. **Visualizzare la lista** delle opere parcheggiate in `ContestWaiting` per un determinato concorso
2. **Identificare i problemi** segnalati nel campo `because`
3. **Rimuovere il record** dalla lista una volta che l'opera è stata chiarita e risolta

### Flusso Operativo

#### 1. Recupero della Lista ContestWaiting

**Endpoint/Controller:** `ContestManageController::showWaitingList(contestId)`

- Filtrare i record di `ContestWaiting` per `contest_id`
- Eseguire un left join con:
  - `Contest` (via `contest_id`) per informazioni del concorso
  - `ContestSection` (via `section_id`) per la sezione di appartenenza
  - `UserWork` (via `user_work_id`) per i dati dell'opera
  - `UserContact` (via `participant_user_id`) per dati del partecipante
  - `UserContact` (via `organization_user_id`) per l'esaminatore che ha segnalato
- **Ordinamento:** per `created_at` (descending) o per `portfolio_sequence`
- **Select campi:** 
  - `id`, `contest_id`, `section_id`, `user_work_id`
  - `participant_user_id`, `organization_user_id`
  - `portfolio_sequence`, `email`
  - `because` (motivo della sospensione)
  - `created_at`, `updated_at`
  - Dati relazionati: nome opera, nome sezione, nome partecipante, nome esaminatore

#### 2. Visualizzazione Dettagli Opera

Per ogni record in lista, mostrare:
- **Opera:** titolo (`UserWork::title_en`), miniatura (300px_)
- **Sezione:** nome sezione (`ContestSection::name_en`)
- **Partecipante:** email, nome (`UserContact`)
- **Problema:** testo completo in `ContestWaiting::because`
- **Esaminatore:** chi ha segnalato il problema (`organization_user_id`)
- **Data segnalazione:** `created_at`

#### 3. Rimozione del Record (Soft Delete)

**Endpoint/Controller:** `ContestManageController::removeFromWaiting(id)`

- Validare che l'utente autenticato sia un `organization_examiner`
- Validare che il record `ContestWaiting::id` esista
- **Soft Delete:** utilizzare il metodo `delete()` del modello (usa `SoftDeletes`)
  ```php
  $contestWaiting = ContestWaiting::findOrFail($id);
  $contestWaiting->delete(); // imposta deleted_at
  ```
- La query di lista esclude automaticamente i soft-deleted record tramite `withoutTrashed()`
- **Notifica:** opzionalmente inviare una notifica al partecipante che il problema è stato risolto

#### 4. Recovery e Visualizzazione di Record Eliminati (Opzionale)

- Implementare una vista separata `showDeletedWaiting()` se necessario per audit
- Usare `withTrashed()` o `onlyTrashed()` per visualizzare i record eliminati

### Relazioni Utilizzate

```php
// ContestWaiting -> Contest
$contestWaiting->contest() // HasOne

// ContestWaiting -> ContestSection
$contestWaiting->contestSection() // HasOne

// ContestWaiting -> UserWork
$contestWaiting->userWork() // HasOne

// ContestWaiting -> UserContact (Participant)
$contestWaiting->participantUser() // HasOne

// ContestWaiting -> UserContact (Organization Examiner)
$contestWaiting->organizationExaminer() // BelongsTo
```

### Caricamento Eager (Optimization)

```php
$waitingList = ContestWaiting::where('contest_id', $contestId)
    ->with([
        'contest',
        'contestSection',
        'userWork',
        'participantUser',
        'organizationExaminer'
    ])
    ->orderBy('created_at', 'desc')
    ->get();
```

### Permessi e Autorizzazione

- Solo utenti con ruolo `organization_examiner` per il contest possono accedere
- Solo utenti con ruolo `organization_manager` per il contest possono rimuovere record
- Validare via `UserRole` table

### Gestione della Parcheggio Immagini

- Una volta rimosso il record da `ContestWaiting`, l'opera **non** viene eliminata da `UserWork`
- L'opera rimane disponibile per il partecipante per nuovi tentativi di partecipazione
- Il file immagine rimane nel filesystem (non viene rimosso automaticamente)

---

## 🗄️ Modifiche al Database

**Nessuna modifica necessaria al database.**

Il modello `ContestWaiting` dispone già di:
- Soft delete tramite `deleted_at` (colonna timestamp nullable)
- Tutti i campi relazionali necessari
- Indici su `contest_id`, `section_id`, `user_work_id`, `participant_user_id`

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
  - [ ] Test: lista ContestWaiting filtrata per contest
  - [ ] Test: rimozione (soft delete) di un record
  - [ ] Test: verifica che deleted record non appaia in lista
  - [ ] Test: autorizzazione esaminatore
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

---

## 🚀 Note per il Deploy

**Niente di particolare.**

- Nessuna migrazione di database richiesta
- Nessuna azione speciale al deploy
- La funzionalità utilizza la soft delete già configurata nel modello
- Il soft delete si attiva automaticamente grazie al trait `SoftDeletes` di Eloquent
