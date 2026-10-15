# Feature: Nome Funzione

> **Branch:** `feat/0385-juror-dashboard`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-13.02  
> **Titolo e urgenza:** (A) feat: Jurors / Contest / Dashboard  
> **Project/issue link:** [#385](https://github.com/mrai64/yapcp/issues/385)  
> **Milestone link:** [M6](https://github.com/mrai64/yapcp/milestones/6)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La Juror dashboard è un pannello raggiungibile dalla personal dashboard per i giurati di un concorso, in cui sono riportati i conteggi delle opere ancora da votare e quelli iscritti a concorso. Nel pannello i link portano alle votazioni per le singole opere ancora non votate.

Di seguito i dettagli tecnici emersi dal confronto tra le branch `feat/0385-juror-dashboard` e `refactor/0140-big-rebuild` e le scelte di implementazione da documentare:

- Percorso e view
  - Sono state aggiunte le route Volt:
    - `/juror/contest/dashboard/{contest}` -> nome route `juror.contest.dashboard`
    - `/juror/contest/section-vote/{sectionId}` -> nome route `juror.contest.section`
  - La view principale è `resources/views/livewire/juror/contest/dashboard.blade.php`.
  - Sono presenti anche stub/views per `section` e `single` in `resources/views/livewire/juror/contest/`.

- Componente Livewire / Volt
  - La pagina dashboard è implementata come componente Livewire/Volt (classe inline nel blade) e mette a disposizione, al mount:
    - `contest` (oggetto Contest) e `organization` collegata.
    - Variabili di conteggio:
      - `contestWorkAll`: numero totale di opere iscritte al contest (ContestWork::where contest_id -> count)
      - `contestVoted`: numero di voti espressi da questo giurato per il contest (ContestVote::where contest_id + where juror_user_id -> count)
      - `reviewRequired`: conteggio (bool/intero) dei voti che richiedono revisione (ContestVote con review_required true per il giurato)
    - `contestSections`: raccolta di ContestSection per il contest con due withCount:
      - `participantWorksCount` (conteggio opere in sezione)
      - `votedWorksCount` (conteggio di opere votate dal giurato) — ottenuto con una closure che filtra `contest_votes` per `juror_user_id`.
    - L'ordinamento delle sezioni è per `code`.

- Modifiche ai Model
  - In `app/Models/ContestSection.php` sono state aggiunte/ridefinite relazioni helper:
    - `contestWorks()` -> hasMany ContestWork
    - `contestAwards()` -> hasMany ContestAward ordinato per `award_code`
    - `contestVotes()` -> hasMany ContestVote (foreignKey `section_id`, localKey `id`)
  - Queste relazioni sono utilizzate per i `withCount` e per i conteggi delle opere e dei voti.

- Logica UI
  - Nella dashboard il comportamento è:
    - Se `contestWorkAll > contestVoted` viene mostrata una tabella con le sezioni e per ciascuna:
      - il rapporto `votedWorksCount / participantWorksCount`
      - il codice e il nome della sezione
      - un link `Vote Section` che punta a `route('juror.contest.section', ['sectionId' => $contestSection->id])`
    - Se per una sezione `votedWorksCount >= participantWorksCount` viene mostrato `All X voted ✅` al posto del link.
    - Se `reviewRequired` è true viene riservato uno spazio per la gestione del revote/review (placeholder Livewire).
    - Quando tutte le opere sono state votate viene mostrato il messaggio `All voted now`.

- Flusso di votazione (comportamento previsto)
  - Dalla dashboard il giurato clicca su "Vote Section" e raggiunge la pagina di sezione che dovrebbe caricare le miniature delle opere non ancora votate (paginazione e caricamento lazy).
  - Cliccando su una miniatura si arriva alla pagina di voto singolo basata su `vote_rule`; dopo il voto la pagina cerca il successivo non votato e, se non ce ne sono più, ritorna alla dashboard del giurato per il contest.
  - La page `juror.contest.single` (stub) è prevista per la votazione singola.

- Test e documentazione
  - Nessuna migration è stata aggiunta (nessuna modifica al DB richiesta).
  - Documentazione aggiuntiva: `resources/docs/1.0/jurors/general.md` e aggiornamento dell'indice docs.
  - Immagini di supporto aggiunte in `storage/app/public/docs/jurors/`.

- Note tecniche e punti aperti
  - Vecchie view/componenti per il voto sono state rinominate/spostate come backup (`*.bak`) nella branch.
  - In `resources/views/livewire/user/contest/juror.blade.php` è stato aggiornato il link per puntare alla nuova route `juror.contest.dashboard`.
  - Verificare i permessi e il middleware (`auth`, `verified`) già applicati alle rotte Volt.
  - Raccomandato: aggiungere test automatizzati per i conteggi `withCount` e per il flusso end-to-end (sezione -> voto singolo -> ritorno dashboard).

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.

author: copilot
author: mrai64