---
title: 'Feature: Pannello Partecipanti fine concorso'
---

# Feature: Pannello Partecipanti fine concorso

> **Branch:** `feat/0419-participants-result-board`  
> **Stato:** Revisione  
> **priorità:** A  
> **id assegnato:** 2026-11-04.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Manage / After Jury / Participation Board  
> **Project/issue link:** [#419](https://github.com/mrai64/yapcp/issues/419)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Al termine delle votazioni della giuria e dopo la data di proclamazione dei risultati (`day_5_revelations`), il concorso chiude la fase valutativa. In questo momento diventa fondamentale rendere disponibile un resoconto completo e trasparente di tutti i concorrenti che hanno partecipato al concorso fotografico ("Tabellone Partecipanti" o "Participation Result Board"), riportando per ciascun autore il dettaglio dei lavori presentati e di quelli ammessi per ogni sezione del concorso.

---

### 1. Motivazione ed Evoluzione Architetturale (Confronto con `refactor/0140-big-rebuild`)

Nel branch `refactor/0140-big-rebuild`:

- **Sola vista dinamica paginata a runtime:** L'unico componente deputato a mostrare i partecipanti era `user.contest.who-participated` (`who-participated.blade.php`), collegato nella tabella dei concorsi chiusi (`listed-closed.blade.php`) tramite il link "Result Board".
- **Query complessa e pesante a ogni richiesta:** Il componente esegue una query dinamica su `ContestParticipant` con join a `user_contacts` e due subquery `withCount` per ogni sezione del concorso (conteggio opere presentate e conteggio opere ammesse), paginando i risultati a 10 record per pagina.
- **Assenza di una vista d'insieme globale e stampabile:** Con centinaia o migliaia di concorrenti e molte sezioni, consultare l'esito generale attraverso un paginatore a 10 elementi per pagina risulta frammentato, disagevole e inadatto a produrre un prospetto unitario ufficiale (da stampare, esportare o consultare rapidamente).
- **Inutile consumo di risorse su dati congelati (immutabili):** A concorso concluso e giuria terminata, le opere e le ammissioni non cambiano più. Continuare a interrogare il database ed eseguire decine di subquery aggregate a ogni singola richiesta HTTP o interazione Livewire costituisce un overhead computazionale non necessario.
- **Rischio di saturazione della memoria (Memory Leak):** Rimuovere la paginazione in un componente Livewire a runtime su dataset consistenti (centinaia di record con idratazione di componenti e relazioni) espone al rischio concreto di memory exhaustion o timeout PHP.
- **Nessun meccanismo di congelamento statico:** Non esisteva alcun processo asincrono per archiviare e servire i risultati come file HTML statico.

Nel branch `feat/0419-participants-result-board`:

- **Strategia a doppio canale (Dinamico Paginato + Statico Completo):**
  - Viene mantenuta la pagina dinamica paginata (`user.contest.who-participated`) per una navigazione interattiva leggera.
  - Viene introdotta la **generazione asincrona di una pagina HTML statica standalone** (`participants_board.html`), posizionata direttamente nella cartella pubblica `public/contests/{contest_id}/`.
- **Prestazioni estreme via Web Server:** Essendo memorizzata direttamente sotto la document root pubblica (`public/`), la pagina generata può essere servita istantaneamente dal web server (Nginx/Apache/Herd) senza attivare il runtime PHP né il bootstrap di Laravel (zero query al database, tempo di risposta nell'ordine dei millisecondi).
- **Elaborazione asincrona in background con chunking:** La creazione del file statico è demandata al Job accodato `App\Jobs\WriteParticipantBoardResultJob`, orchestrato con il bus di Laravel (`Bus::batch`), che sfrutta il metodo `lazy(200)` di Eloquent per processare i partecipanti a blocchi di memoria costanti senza rischio di superare i limiti di memoria PHP.
- **Template Blade isolato per l'export:** Viene predisposta la vista `resources/views/exports/contest-participants-static.blade.php`, completamente autonoma (HTML5 nativo, Tailwind CSS da CDN, asset Vite preloadati) e priva di overhead Livewire.
- **Pannello di controllo e rigenerazione:** È stato creato il componente Volt `user.contest.participant-board` (`participant-board.blade.php`), protetto da policy di autorizzazione per gli organizzatori del concorso, che consente di avviare o rigenerare la pagina statica e verificarne immediatamente l'URL pubblico.
- **Rilevamento intelligente dello stato del file:** È stato implementato il metodo computato `existsStaticParticipationResults()` nel modello `App\Models\Contest`, che permette alla dashboard dei concorsi chiusi (`listed-closed.blade.php`) di mostrare dinamicamente un link diretto al file statico (`📋 Result Board / Full`) se già generato, oppure un link alla schermata di generazione (`✍️ Result Board / Full`) se non ancora creato.

---

### 2. Dettaglio dei Componenti e Scelte Implementative

#### 2.1. Il Job Asincrono: `App\Jobs\WriteParticipantBoardResultJob`

La classe `App\Jobs\WriteParticipantBoardResultJob` si occupa del caricamento controllato dei dati, della compilazione del template Blade e del salvataggio del file statico su disco:

- **Interfacce e Trait:** implementa `ShouldQueue` ed estende le proprie funzionalità con `Batchable`, `Dispatchable`, `InteractsWithQueue`, `Queueable` e `SerializesModels`.
- **Timeout esteso:** `public int $timeout = 300;`, per garantire un margine operativo sicuro anche su concorsi di portata internazionale con centinaia di autori e migliaia di opere.
- **Costruzione della query analitica:**
  - Recupera le sezioni ordinate per codice: `$this->contest->contestSections()->orderBy('code')->get()`.
  - Inizia la query su `ContestParticipant`, filtrando per `contest_id`.
  - Esegue l'eager loading delle informazioni anagrafiche e della nazione con `with(['userContact.country'])`.
  - Esegue un `join` con la tabella `user_contacts` per ordinare i risultati per codice nazione (`country_id`), cognome (`last_name`) e nome (`first_name`).
  - Utilizza `select('contest_participants.*')` per scongiurare collisioni sui campi omonimi (in particolare l'attributo `id`).
  - Itera dinamicamente su ogni sezione del concorso associando due aggregazioni `withCount`:
    - `section_{code}_works_count`: totale opere inviate dal partecipante per quella sezione.
    - `section_{code}_admit_count`: totale opere ammesse (`is_admit = 1`), vincolato alla condizione temporale: se la data corrente non supera `day_5_revelations`, la condizione viene forzata a `whereRaw('0 = 1')` per proteggere l'anonimato delle ammissioni fino alla data stabilita.
- **Gestione sicura della memoria con `lazy(200)`:**
  Per evitare il caricamento simultaneo di migliaia di modelli Eloquent idratati con relazioni e contatori:

  ```php
  $participantsCollection = collect();
  foreach ($baseQuery->lazy(200) as $participant) {
      $participantsCollection->push($participant);
  }
  ```

  L'uso di `lazy()` mantiene una finestra temporale costante sull'impronta di memoria durante lo scorrimento del cursore.
- **Compilazione del template Blade:**
  Invoca `view('exports.contest-participants-static', [...])->render()` passando contest, organizzazione, sezioni, partecipanti, flag di rivelazione e timestamp UTC di generazione.
- **Salvataggio nella cartella `public/`:**
  - Individua il percorso: `public_path("contests/{$this->contest->id}")`.
  - Crea ricorsivamente la cartella con permessi `0755` se non presente (`File::makeDirectory`).
  - Scrive il file HTML: `File::put($directory . '/participants_board.html', $html)`.
- **Tracciamento ed Error Handling:**
  Traccia con `Log::info()` i passaggi chiave di avanzamento e intercetta eventuali eccezioni con `Log::error()`, rilanciando l'eccezione per consentire il retry del worker.

---

#### 2.2. Vista di Export Dedicata: `resources/views/exports/contest-participants-static.blade.php`

Il template Blade dedicato all'output statico è collocato in `resources/views/exports/`, secondo le raccomandazioni architetturali per i documenti di reportistica:

- **Autonomia completa (Standalone):** Non estende layout applicativi complessi (come `layouts.app` o `components.app-layout`) per evitare dipendenze da sessioni utente, menu di navigazione o componenti JavaScript reattivi.
- **Stile e Risorse:** Include Tailwind CSS via CDN e i file CSS/JS compilati tramite `<link rel="stylesheet">` per garantire la corretta resa visiva tipografica e tabellare indipendentemente dall'ambiente di visualizzazione.
- **Struttura della Tabella:**
  - Intestazione con bandiera del concorso, nome ufficiale, organizzazione promotrice e data/ora UTC di aggiornamento.
  - Tabella responsive a colonne doppie per ciascuna sezione (`Works` con sfondo azzurro tenue, `Admitted` con sfondo verde tenue).
  - Anagrafica autore con cognome, nome, bandiera, sigla nazione, città e regione.
  - Avviso a piè di pagina sullo stato dei conteggi delle ammissioni (se aggiornati alle scelte definitive della giuria oppure azzerati in attesa del giorno di rivelazione).

---

#### 2.3. Componente di Controllo e Rigenerazione: `resources/views/livewire/user/contest/participant-board.blade.php`

Componente Livewire Volt single-file registrato sulla rotta protetta `/user/contest/participant-board/{contest}`:

- **Autorizzazione d'accesso:** Nel metodo `mount()` viene eseguito il controllo di policy:

  ```php
  $this->authorize('update', [Contest::class, $contest]);
  ```

  Garantendo che soltanto gli organizzatori responsabili del concorso possano accedere al pannello e ordinare la compilazione del tabellone.
- **Dispatch asincrono tramite Batch:**
  Il metodo `generateStaticParticipantsBoards()` lancia il job all'interno di un batch Laravel:

  ```php
  Bus::batch([
      new WriteParticipantBoardResultJob($this->contest),
  ])->dispatch();

  session()->flash('success', __("Started Job for Participation Board static page generation"));
  ```

- **Interfaccia Utente:**
  - Header con link di navigazione rapida verso la dashboard utente, la dashboard organizzazione, la bozza del verbale di giuria (`Final Minute Draft`) e la cartella documenti del concorso.
  - Notifica visiva del flash message (`session('success')`) e rendering di eventuali errori di validazione.
  - Tabella operativa con due righe:
    1. **Verifica:** visualizzazione dell'URL del file statico (`/contests/{contest_id}/participants_board.html`) con link "Check" per testare l'apertura immediata del file statico nel browser.
    2. **Azione:** pulsante interattivo "Generate / regenerate" collegato all'azione `generateStaticParticipantsBoards` via Livewire.

---

#### 2.4. Estensione del Modello `App\Models\Contest`

Nel modello `App\Models\Contest` è stato aggiunto il metodo:

```php
#[Computed]
public function existsStaticParticipationResults(): bool
{
    return File::exists(public_path('contests/' . ($this->id) . '/participants_board.html'));
}
```

Questo metodo fornisce un controllo rapido e non intrusivo sul filesystem locale per verificare l'effettiva presenza del file statico, consentendo di condizionare i link nell'interfaccia utente senza query aggiuntive al database.

---

#### 2.5. Integrazione nelle Viste e Navigazione

Le viste del frontend sono state armonizzate per offrire una transizione fluida tra consultazione paginata e prospetto completo:

1. **Dashboard Concorsi Chiusi (`resources/views/livewire/user/contest/listed-closed.blade.php`):**
   - Il link alla consultazione paginata è stato chiarito: `Result Board / Paged` (`route('user.contest.who-participated', ...)`).
   - È stato introdotto il link condizionale al tabellone completo:
     - Se il file statico esiste (`$contest->existsStaticParticipationResults()`): visualizza `📋 Result Board / Full` con link diretto all'URL statico `https://yapcp.test/contests/{id}/participants_board.html`.
     - Se il file non è ancora stato generato: visualizza `✍️ Result Board / Full` che indirizza l'organizzatore alla schermata di generazione `route('user.contest.participant-board', ...)`.
2. **Dashboard Organizzazione (`resources/views/livewire/organization/dashboard.blade.php`):**
   - Aggiunta dell'azione `revelationResults(string $contestId)` che avvia un batch con i job `SendJuryResultJob` per ogni partecipante.
   - Aggiornamento dei link dell'area After Jury con iconografia coerente (`📥 Results NOTIFY`).
3. **Pannello Giuria (`juror-board.blade.php`) e Partecipanti (`listed.blade.php`):**
   - Pulizia dei commenti e armonizzazione dei collegamenti operativi post-giuria.
4. **Rotte Applicative (`routes/web.php`):**
   - Registrazione della nuova rotta Volt:

     ```php
     Volt::route('/user/contest/participant-board/{contest}', 'user.contest.participant-board')
         ->middleware(['auth', 'verified'])
         ->name('user.contest.participant-board');
     ```

---

### 3. Matrice Comparativa: `refactor/0140-big-rebuild` vs `feat/0419-participants-result-board`

| Aspetto | `refactor/0140-big-rebuild` | `feat/0419-participants-result-board` |
| :--- | :--- | :--- |
| **Modalità di fruizione** | Esclusivamente dinamica con paginazione a 10 elementi (`who-participated.blade.php`). | Ibrida: consultazione paginata interattiva + documento statico HTML completo (`participants_board.html`). |
| **Carico sul Database** | Query complessa con doppi `withCount` per ogni sezione rieseguita a ogni cambio pagina. | Query eseguita una tantum dal Job; le consultazioni successive accedono direttamente al file statico senza toccare il DB. |
| **Prestazioni di risposta** | Latenza variabile dipendente dal carico DB, memoria PHP e numero di sezioni. | Risposta istantanea a livello di web server (file statico in `public/`), tempo di caricamento nell'ordine dei millisecondi. |
| **Gestione della Memoria** | Rischio di Memory Limit o timeout in caso di esportazione completa on-the-fly. | Elaborazione sicura in background tramite chunking a blocchi con `lazy(200)` e timeout esteso a 300 secondi. |
| **Archiviazione e Condivisione** | Nessun file archiviabile o condivisibile come documento unico. | File HTML autonomo e congelato, salvato nella cartella del concorso (`public/contests/{id}/`). |
| **Controllo Operativo** | Nessuna interfaccia per generare o rigenerare il tabellone statico. | Componente Livewire Volt dedicato (`participant-board.blade.php`) con autorizzazione di policy e dispatch in batch. |
| **Integrazione UI** | Singolo pulsante "Result Board" verso la pagina paginata. | Rilevamento automatico con helper `existsStaticParticipationResults()` e doppio link (Paged / Full). |

---

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

> <!-- to avoid index in Larecipe -->
- I dati vengono estratti direttamente dalle tabelle esistenti `contests`, `contest_sections`, `contest_participants`, `user_contacts` e `contest_works`.
- L'orchestrazione asincrona sfrutta la tabella preesistente `job_batches`.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.

> <!-- to avoid index in Larecipe -->
- **Permessi Filesystem:** Assicurarsi che il processo del web server e del queue worker abbiano i permessi di scrittura sulla directory `public/contests/` per consentire la creazione delle sottocartelle e del file `participants_board.html`.
- **Queue Workers:** Verificare che i worker delle code (`php artisan queue:work`) siano attivi e configurati per processare i batch jobs.
