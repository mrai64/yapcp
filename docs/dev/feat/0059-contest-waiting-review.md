---
title: 'Feature: ContestWaiting Review (Resolve & Lock Audit)'
---

# Feature: ContestWaiting Review (Resolve & Lock Audit)

> **Branch:** `feat/0059-contest-waiting-review` *(riferito anche come `feat/0059-contest-waiting-resolve`)*  
> **Stato:** Revisione  
> **priorità:** B  
> **id assegnato:** 2026-11-14.01  
> **Titolo e urgenza:** (B) feat: Organization / Contest Manage Before Jury / ContestWaiting - review  
> **Project/issue link:** [#59](https://github.com/mrai64/yapcp/issues/59)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
  - [Obiettivo e Motivazione](#obiettivo-e-motivazione)
  - [1. Modellazione Dati (`ContestWaiting`)](#1-modellazione-dati-contestwaiting)
  - [2. Rotte e Navigazione (`routes/web.php`)](#2-rotte-e-navigazione-routeswebphp)
  - [3. Componenti Livewire Volt](#3-componenti-livewire-volt)
    - [3.1 Blocco e Notifica (`notify.blade.php`)](#31-blocco-e-notifica-notifybladephp)
    - [3.2 Elenco Opere Sospese (`resolve.blade.php`)](#32-elenco-opere-sospese-resolvebladephp)
    - [3.3 Risoluzione con Motivazione (`resolved-because.blade.php`)](#33-risoluzione-con-motivazione-resolved-becausebladephp)
    - [3.4 Dashboard Organizzazione (`dashboard.blade.php`)](#34-dashboard-organizzazione-dashboardbladephp)
  - [4. Localizzazione e Traduzioni](#4-localizzazione-e-traduzioni)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
  - [Dettaglio Migration: `2026_11_14_183226_add_cols_to_contest_waitings_table.php`](#dettaglio-migration-2026_11_14_183226_add_cols_to_contest_waitings_tablephp)
  - [Rollback / Metodo `down()`](#rollback--metodo-down)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Obiettivo e Motivazione

Nella versione iniziale della funzionalità (issue [#375](https://github.com/mrai64/yapcp/issues/375) / `0375-contest-waiting-remove`), la tabella `ContestWaiting` gestiva le opere escluse temporaneamente dal concorso con un motivo (`because`) e l'esaminatore che aveva fatto la segnalazione (`organization_user_id`). La risoluzione avveniva mediante eliminazione diretta (`revokeContestWaiting`) con un pulsante rapido ("SOLVED"), senza memorizzare l'utente che verificava lo sblocco né le motivazioni della riammissione.

Con la presente feature ([#59](https://github.com/mrai64/yapcp/issues/59)), il processo viene evoluto da **semplice rimozione ("remove")** a **risoluzione verificata ("resolve")** con tracciamento di audit a doppio fattore (Lock & Resolve):

1. **Fase di Lock (Sospensione/Parcheggio):** quando un'opera viene sospesa, vengono registrati `locked_by_user_id` e la spiegazione `locked_because`.
2. **Fase di Resolve (Sblocco/Risoluzione):** prima di riammettere l'opera in gara cancellando il record in soft delete (`delete()`), l'esaminatore compila un form di spiegazione (`resolved_because`), registrando contestualmente `resolved_by_user_id`. In questo modo i record soft-deleted mantengono nel tempo l'audit completo sia dell'anomalia sia della soluzione.

---

### 1. Modellazione Dati (`ContestWaiting`)

Nel modello `App\Models\ContestWaiting` (`app/Models/ContestWaiting.php`):

- **Proprietà e Casts:**
  - I campi `organization_user_id` e `because` sono stati rinominati rispettivamente in `locked_by_user_id` e `locked_because`.
  - Sono stati introdotti i campi `resolved_by_user_id` (nullable) e `resolved_because` (nullable).
  - Aggiornato `$fillable` con i nuovi attributi.
  - Aggiornato il metodo `casts()` con `'locked_by_user_id' => 'string'`, `'locked_because' => 'string'`, `'resolved_by_user_id' => 'string'`, `'resolved_because' => 'string'`.
- **Relazioni Eloquent con `UserContact`:**
  - `organizationLocker()`: ridenominata da `organizationExaminer()`, relaziona `ContestWaiting.locked_by_user_id` con `UserContact.id`.
  - `organizationResolver()`: nuova relazione `belongsTo` verso `UserContact` per accedere all'utente che ha sbloccato l'opera.
- **PHPDoc:**
  - Aggiornate le annotazioni `@property` e `@method where...` per tutti i nuovi campi e relazioni.

---

### 2. Rotte e Navigazione (`routes/web.php`)

Nel file delle rotte web sono state applicate le seguenti modifiche:

- **Ridenominazione rotta di elenco per risoluzione:**
  - Vecchia: `Volt::route('/organization/contest-waiting/remove/{contest}', 'organization.contest-waiting.remove')->name('organization.contest-waiting.remove');`
  - Nuova:

    ```php
    Volt::route('/organization/contest-waiting/resolve/{contest}', 'organization.contest-waiting.resolve')
        ->middleware(['auth', 'verified'])
        ->name('organization.contest-waiting.resolve');
    ```

- **Nuova rotta per motivazione di risoluzione:**
  - Registrata la rotta Volt per inserire la motivazione di sblocco:

    ```php
    Volt::route('/organization/contest-waiting/solved-because/{contestWaiting}', 'organization.contest-waiting.resolved-because')
        ->middleware(['auth', 'verified'])
        ->name('organization.contest-waiting.resolved-because');
    ```

- **Rotta di notifica e blocco:**
  - Rimane attiva `/organization/contest-waiting/notify/{contestWork}` (`organization.contest-waiting.notify`), aggiornata nei commenti per chiarire l'esclusione dell'opera dalla gara.

---

### 3. Componenti Livewire Volt

#### 3.1 Blocco e Notifica (`notify.blade.php`)

File: `resources/views/livewire/organization/contest-waiting/notify.blade.php`

- Proprietà `$because` rinominata in `$lockedBecause`.
- Metodo `registerAndNotify()` rinominato in `lockAndNotify()`.
- Validazione estesa: `'lockedBecause' => 'required|string|max:2000'`.
- Salvataggio esplicito di `locked_by_user_id = Auth::id()` e `locked_because = $validated['lockedBecause']`.
- Interfaccia aggiornata con messaggi più chiari ed empatici (comunicazione che il lavoro "IS LOCKED" e raccomandazione di rileggere prima di inviare).

#### 3.2 Elenco Opere Sospese (`resolve.blade.php`)

File: `resources/views/livewire/organization/contest-waiting/resolve.blade.php` *(rinominato da `remove.blade.php`)*

- Rimosso il metodo inline `revokeContestWaiting()` e il pulsante immediato di cancellazione.
- Inserito il link navigabile verso la schermata di motivazione:

  ```blade
  <x-yapcp.inline-link
      txt="Resolved because..."
      url="{{ route('organization.contest-waiting.resolved-because', ['contestWaiting' => $contestWaiting]) }}" />
  ```

#### 3.3 Risoluzione con Motivazione (`resolved-because.blade.php`)

Nuovo componente Volt: `resources/views/livewire/organization/contest-waiting/resolved-because.blade.php`

- **Inizializzazione (`mount`):**
  - Riceve il model `ContestWaiting` via Route Model Binding.
  - Carica i contesti di `Contest` e `Organization`.
- **Validazione (`rules`):**
  - Regola `'resolvedBecause' => 'required|string|max:2000'`.
- **Azione (`solvedContestWaiting`):**
  1. Valida l'input inviato.
  2. Aggiorna il record con l'esaminatore corrente (`resolved_by_user_id = Auth::id()`) e la motivazione (`resolved_because`).
  3. Esegue la soft-delete del record: `$this->contestWaiting->delete()`.
  4. Effettua redirect verso `organization.contest-waiting.resolve` con flash message di successo `"Solved and Updated"`.

#### 3.4 Dashboard Organizzazione (`dashboard.blade.php`)

File: `resources/views/livewire/organization/dashboard.blade.php`

- Il link rapido "No more waiting Works" punta ora a `organization.contest-waiting.resolve` invece che a `organization.contest-waiting.remove`.

---

### 4. Localizzazione e Traduzioni

Aggiornati i file dizionario `resources/lang/en.json` e `resources/lang/it.json`:

- Aggiunte stringhe relative al nuovo flusso: `"Resolve Issue question over Contest Work"`, `"Resolution reasoning, english"`, `"Confirm Solution"`, `"Before re-insert that Work into the contest, write a Because text."`, `"Solved and Updated"`, `"Then, SEND."`.
- Aggiornate stringhe di avviso: `"Be patient an kind. You are informing an AUTHOR that him/her work IS LOCKED."`, `"Check three times. Every Single Word. All the Words. AND count to TEN."`.
- Rimossa la stringa obsoleta `"✅ SOLVED ✅"`.

---

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `database/migrations/2026_11_14_183226_add_cols_to_contest_waitings_table.php`

### Dettaglio Migration: `2026_11_14_183226_add_cols_to_contest_waitings_table.php`

Modifiche applicate alla tabella `contest_waitings`:

1. **Ridenominazione Colonne e Indici:**
   - Colonna `organization_user_id` rinominata in `locked_by_user_id`.
   - Indice `organization_idx` rinominato in `locker_user_idx`.
   - Colonna `because` rinominata in `locked_because`.
2. **Aggiunta Nuove Colonne:**
   - `resolved_by_user_id`: `char(36)`, nullable, charset `ascii`, collation `ascii_general_ci`, indice `resolver_user__idx`, commento `'fk: user_works.id organization member'` *(posizionata dopo `locked_because`)*.
   - `resolved_because`: `text`, nullable, commento `'why that work is in'` *(posizionata dopo `resolved_by_user_id`)*.

### Rollback / Metodo `down()`

La migration implementa completamente la procedura di rollback inverso:

- Eliminazione dell'indice `resolver_user__idx` e delle colonne `resolved_by_user_id`, `resolved_because`.
- Ripristino dei nomi originali delle colonne `locked_by_user_id` -> `organization_user_id` e `locked_because` -> `because`.
- Ripristino del nome dell'indice `locker_user_idx` -> `organization_idx`.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** La suite di test dell'applicazione passa regolarmente (`php artisan test`).
- [x] **Docs:** La scheda tecnica `docs/dev/feat/0059-contest-waiting-review.md` riflette fedelmente tutte le modifiche introdotte rispetto a `main-2026`.
- [ ] **Manual:** Verificato manualmente il flusso completo:
  - Parcheggio opera via `organization.contest-waiting.notify` (popolamento `locked_by_user_id` e `locked_because`).
  - Accesso alla lista `organization.contest-waiting.resolve`.
  - Passaggio al form di sblocco `organization.contest-waiting.resolved-because`.
  - Salvataggio di `resolved_by_user_id`, `resolved_because` e verifica del soft-delete su database.
- [x] **Cleanup:** Rimossi `dd()`, `dump()`, console log non necessari; mantenuti i log strutturati `Log::info()` e `Log::debug()`.
- [x] **Commit:** Messaggi di commit chiari e conformi alle convenzioni di progetto.

---

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Eseguire la migration di database:

  ```bash
  php artisan migrate
  ```

- Nessuna ulteriore azione manuale richiesta (le modifiche alle rotte e ai componenti Livewire sono retrocompatibili con la struttura esistente delle tabelle dopo la migrazione).
