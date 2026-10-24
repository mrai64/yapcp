---
title: 'Feature: Votazione del giurato'
---

# Feature: Votazione del giurato

> **Branch:** `feat/0387-contest-vote-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-14.02  
> **Titolo e urgenza:** (A) feat: Jurors / Contest / Section ContestVote add  
> **Project/issue link:** [#387](https://github.com/mrai64/yapcp/issues/387)  
> **Milestone link:** [M6](https://github.com/mrai64/yapcp/milestones/6)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La modalità di voto da remoto per i giurati prevede l'assegnazione a ciascun lavoro di una votazione online su base numerica, o altra base purché sia un valore scalabile ovvero ci sia un "minimo" e un "massimo". Il giurato visiona l'immagine singola e cliccando su un pulsante assegna il voto passando immediatamente alla immagine successiva. Non sono previsti pulsanti di alert perché il giurato possa segnalare eventuali anomalie all'organizzazione.

Di seguito i dettagli tecnici e le scelte di implementazione:

- **Rotte, Route Model Binding e Gate di Autorizzazione**
  - **Aggiornamento Rotta Volt (`routes/web.php`):**
    - La rotta di voto per sezione è passata dal parametro numerico scalare `{sectionId}` al Route Model Binding esplicito `{contestSection}`:
      `Volt::route('/juror/contest/section-vote/{contestSection}', 'juror.contest.section')->middleware(['auth', 'verified'])->name('juror.contest.section');`
  - **Configurazione Service Provider (`app/Providers/AppServiceProvider.php`):**
    - Registrato il model binding per `contest-section`: `Route::model('contest-section', ContestSection::class);`.
    - Registrata la policy esplicita: `Gate::policy(ContestJury::class, \App\Policies\ContestJuryPolicy::class);`.
    - Definito il Gate dedicato `vote-in-section`:

      ```php
      Gate::define('vote-in-section', function (User $user, ContestSection $contestSection) {
          $res = ContestJury::where('section_id', $contestSection->id)
              ->where('user_id', $user->id)
              ->exists();
          return $res;
      });
      ```

      Questo Gate garantisce che solo gli utenti effettivamente iscritti come giurati per quella specifica sezione (`ContestJury`) possano accedere alla schermata di votazione.

- **Componente Livewire / Volt (`resources/views/livewire/juror/contest/section.blade.php`)**
  - Lo stub segnaposto vuoto presente in `refactor/0140-big-rebuild` è stato sostituito dall'implementazione completa come componente Volt (formato class-based: `new class extends Component`).
  - **Proprietà del componente:**
    - `public ContestSection $contestSection`: istanza della sezione del concorso in fase di voto.
    - `public $contestWork`: opera corrente (`ContestWork`) presentata per la votazione.
    - `public $voteMethod`: regola di valutazione del concorso (`vote_rule`), ereditata da `$contestSection->contest->vote_rule`.
    - `public $vote`: valore del voto selezionato.
  - **Ciclo di vita `mount(ContestSection $contestSection)`:**
    - Autorizzazione preventiva: invoca `$this->authorize('vote-in-section', $contestSection);`.
    - Selezione progressiva dell'opera: individua la prima opera (`ContestWork`) della sezione non ancora presente tra i voti espressi:

      ```php
      $contestWork = ContestWork::where('section_id', $this->contestSection->id)
          ->whereNotIn('id', function($query){
              $query->select('contest_work_id')
                  ->from(ContestVote::TABLENAME)
                  ->where('section_id', $this->contestSection->id);
          })
          ->first();
      ```

    - Gestione fine lavori: se non sono presenti ulteriori opere da votare (`!$contestWork`), esegue il reindirizzamento alla dashboard del giurato con messaggio di completamento (`Hurrah! Completed. Next?`).
    - Configurazione del metodo di voto: recupera la stringa `vote_rule` dal concorso collegato.
  - **Regole di validazione dinamiche (`rules()`):**
    - Configura l'insieme dei voti ammessi in base al valore di `voteMethod`:
      - `'num:1..10'`: array di stringhe da `'1'` a `'10'`.
      - `'num:1..30'`: array di stringhe da `'1'` a `'30'`.
      - `'star:1..5'`: array di emoji `'⭐️'` da 1 a 5 stelline (`['⭐️', '⭐️⭐️', '⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️', '⭐️⭐️⭐️⭐️⭐️']`).
    - Regola applicata: `'vote' => ['required', Rule::in($validVotes)]`.
  - **Azione di voto (`addContestVote(string $vote)`):**
    - Gestione uscita volontaria: se `$vote == 'exit'`, reindirizza alla dashboard del concorso con flash message `'Stopped. Next?'`.
    - Validazione dell'input con `$this->validate()`.
    - Persistenza del voto in `ContestVote::create`: registra `contest_id`, `section_id`, `contest_work_id`, `juror_user_id` (`Auth::id()`) e `vote`.
    - Avanzamento immediato: ricarica la rotta della sezione (`redirect()->route('juror.contest.section', ['contestSection' => $this->contestSection])`) per presentare istantaneamente l'opera successiva senza passaggi o conferme intermedie.

- **Interfaccia Utente e Presentazione Blade / Alpine**
  - **Visualizzazione dell'immagine:**
    - Box centrale a sviluppo verticale vincolato a `75vh` (`height: 75vh !important;`).
    - Adattamento in base all'orientamento (`$contestWork->userWork->is_landscape`):
      - Orizzontale: `max-w-full object-contain rounded-lg shadow-md`.
      - Verticale: `max-h-full object-contain rounded-lg shadow-md`.
    - Protezione dei contenuti contro il download non autorizzato tramite direttiva Alpine `@contextmenu.prevent` e attributo `alt="All rights reserved"`.
    - Risoluzione dell'asset multimediale: `asset('storage/contests/' . $contestWork->contest_id . '/' . $contestWork->section_id . '/' . $contestWork->id . '.' . $contestWork->userWork->file_format)`.
  - **Pulsantiera di voto rapido:**
    - Pulsante "exit" sempre accessibile per interrompere la sessione.
    - Render condizionale della bottoniera corrispondente alla modalità di voto (`num:1..10`, `num:1..30`, `star:1..5`).
    - Assegnazione diretta al click tramite `wire:click="addContestVote('...')"` per massimizzare la fluidità del lavoro della giuria.

- **Integrazione con la Dashboard Giurato (`resources/views/livewire/juror/contest/dashboard.blade.php`)**
  - Allineata la generazione del link "Vote Section" nella tabella delle sezioni, passando il parametro `['contestSection' => $contestSection]` in accordo con il nuovo binding di rotta.

- **Internazionalizzazione (i18n)**
  - Aggiornati i dizionari `resources/lang/en.json` e `resources/lang/it.json` con le stringhe per i messaggi di stato e le intestazioni di voto (`"Stopped. Next?"`, `"Hurrah! Completed. Next?"`, `"Voted"`, `"per Total Works"`, `"Section scoreboards"`, ecc.).

- **Note tecniche e punti aperti rilevati**
  - Nella query di selezione in `mount()` di `section.blade.php`, il controllo `whereNotIn` su `contest_votes` filtra attualmente per sola `section_id`: in scenari di giuria con più giurati concorrenti sulla stessa sezione, la subquery deve includere il filtro per giurato (`where('juror_user_id', Auth::id())`) per evitare che il voto di un giurato escluda l'opera anche agli altri.
  - Nel ramo di uscita di `mount()` (`if (!$contestWork)`), l'istruzione fa riferimento a `$this->contestWork->contest` prima che `$this->contestWork` sia assegnato; è preferibile referenziare `$this->contestSection->contest`.

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
