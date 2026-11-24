---
title: 'Feature: Contest Design: Circuit Calendar Add'
---

> **Branch:** `feat/0437-contest-circuit-calendar`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-11-23.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / Circuit Calendar Add  
> **Project/issue link:** [#437](https://github.com/mrai64/yapcp/issues/437)  
> **Milestone link:** [M7](https://github.com/mrai64/yapcp/milestones/7)  
> **autori:** Antigravity, mrai64

- [📝 Logica Tecnica](#-logica-tecnica)
  - [Contesto e Obiettivi](#contesto-e-obiettivi)
  - [1. Componente Livewire Volt Gestione Calendario Circuito (`circuit/modify-calendar.blade.php`)](#1-componente-livewire-volt-gestione-calendario-circuito-circuitmodify-calendarbladephp)
  - [2. Componente Livewire Volt Gestione Link Web Circuito (`circuit/modify-url.blade.php`)](#2-componente-livewire-volt-gestione-link-web-circuito-circuitmodify-urlbladephp)
  - [3. Barra di Navigazione del Circuito (`circuit-nav.blade.php`)](#3-barra-di-navigazione-del-circuito-circuit-navbladephp)
  - [4. Dashboard Organizzazione: Gestione Differenziata Concorsi e Circuiti (`dashboard.blade.php`)](#4-dashboard-organizzazione-gestione-differenziata-concorsi-e-circuiti-dashboardbladephp)
  - [5. Correzioni e Refactoring su Concorso Singolo (`contest/modify-calendar.blade.php`)](#5-correzioni-e-refactoring-su-concorso-singolo-contestmodify-calendarbladephp)
  - [6. Manutenzione Modello `Contest` (`app/Models/Contest.php`)](#6-manutenzione-modello-contest-appmodelscontestphp)
  - [7. Rotte Web (`routes/web.php`)](#7-rotte-web-routeswebphp)
  - [8. Internazionalizzazione e Traduzioni (`lang/en.json`, `lang/it.json`)](#8-internazionalizzazione-e-traduzioni-langenjson-langitjson)
  - [9. Strumenti di Analisi Statica e Dipendenze (`composer.json`, `composer.lock`)](#9-strumenti-di-analisi-statica-e-dipendenze-composerjson-composerlock)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [📖 Documentazione Utente e Versioning](#-documentazione-utente-e-versioning)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Contesto e Obiettivi

I concorsi afferenti a uno stesso **Circuito** condividono le scadenze temporali fondamentali e il regolamento generale. La definizione del calendario a livello di circuito centralizza le 8 scadenze chiave dell'intero ciclo di vita dell'evento (dall'apertura delle iscrizioni alla chiusura definitiva dei lavori), nonché la modalità di voto adottata dalle giurie (`vote_rule`).

**Scelta architetturale (Separazione di Dominio vs Regola DRY / ReReRe):**  
Sebbene la maschera di configurazione del calendario ricalchi quella del singolo concorso (`contest/modify-calendar.blade.php`), è stata adottata la scelta consapevole di clonare e specializzare il componente Livewire Volt (`circuit/modify-calendar.blade.php`). Questa separazione, pur contravvenendo alla rigorosa regola di non-ripetizione (*ReReRe*), mantiene il software pulito, disaccoppiando l'evoluzione dei circuiti (con testi dedicati, logica di navigazione specifica, fusi orari aggregati ed eventuali future regole esclusive di circuito) da quella dei singoli concorsi senza appesantire il codice con complessi rami condizionali in un unico componente monolitico.

---

### 1. Componente Livewire Volt Gestione Calendario Circuito (`circuit/modify-calendar.blade.php`)

File: `resources/views/livewire/organization/design/circuit/modify-calendar.blade.php`  
Rotta: `organization.design.circuit.modify-calendar` (`/organization/design/circuit/modify-calendar/{contest}`)

Componente Volt single-file basato su classe anonima (`new class () extends Component`) dedicato alla configurazione del calendario di circuito:

- **Campi gestiti (8 tappe temporali + Regola di Voto):**
  - `day1Opening`: Apertura iscrizioni al circuito (ore 00:00 del fuso orario del circuito).
  - `day2Closing`: Termine ultimo per l'invio delle opere da parte dei partecipanti (ore 23:59).
  - `day3JuryOpening`: Avvio dei lavori di giuria (ore 00:00).
  - `day4JuryClosing`: Termine lavori e ultima riunione di giuria (ore 23:59).
  - `circuitVoteRule`: Sistema di votazione della giuria, selezionabile tra le regole attive da tabella di lookup `contests_vote_rule_sets` (`ContestsVoteRuleSet`).
  - `day5Revelations`: Divulgazione e notifica dei risultati a partecipanti e pubblico (ore 23:59).
  - `day6Awards`: Cerimonia ufficiale di premiazione (online o in presenza) (ore 23:59).
  - `day7Catalogues`: Pubblicazione dei cataloghi (online o cartacei) (ore 23:59).
  - `day8Closing`: Chiusura definitiva di tutte le attività del circuito (ore 23:59).

- **Proprietà Calcolate Reattive (Livewire `#[Computed]`):**
  - `daysFromToday`: Calcola i giorni mancanti da oggi all'apertura delle iscrizioni (`day1Opening`).
  - `daysBetween($start, $end)`: Calcola dinamicamente la differenza in giorni tra due date arbitrarie, fornendo all'organizzatore feedback contestuale immediato (es. durata delle iscrizioni, intervallo prima della giuria, distanza cumulativa dall'inizio).

- **Validazione Cronologica a Cascata:**
  Le date devono rispettare un ordine cronologico rigoroso:
  ```php
  'day1Opening'     => 'required|date',
  'day2Closing'     => 'required|date|after:day1Opening|before:day3JuryOpening',
  'day3JuryOpening' => 'required|date|after:day2Closing|beforeOrEqual:day4JuryClosing',
  'day4JuryClosing' => 'required|date|after:day3JuryOpening|before:day5Revelations',
  'day5Revelations' => 'required|date|after:day4JuryClosing|before:day6Awards',
  'day6Awards'      => 'required|date|after:day5Revelations|before:day8Closing',
  'day7Catalogues'  => 'required|date|after:day5Revelations|before:day8Closing',
  'day8Closing'     => 'required|date|after:day6Awards|after:day7Catalogues',
  'circuitVoteRule' => 'required|exists:contests_vote_rule_sets,vote_rule',
  ```

- **Persistenza e Fusi Orari:**
  Nel metodo `modifyCircuit()`, ciascuna data viene convertita in `CarbonImmutable` formattata con il fuso orario del circuito (`$this->circuit->timezone_id`), impostando `.startOfDay()` per le aperture (giorni 1 e 3) e `.endOfDay()` per le chiusure (giorni 2, 4, 5, 6, 7 e 8). Al salvataggio segue il redirect sulla pagina stessa con messaggio di successo `session('success')`.

- **Interfaccia Utente:**
  - Header con navigazione circuito (`<x-yapcp.organization.design.circuit-nav>` e `<livewire:organization.design.circuit.circuit-nav>`).
  - Riquadro informativo con indicazione comparata del fuso orario del circuito (`$circuit->timezone_id`) e di quello dell'utente creatore (`$creator->timezone_id`).
  - Input standard HTML5 di tipo `date` con conteggio giorni relativo mostrato sotto ciascun campo.

---

### 2. Componente Livewire Volt Gestione Link Web Circuito (`circuit/modify-url.blade.php`)

File: `resources/views/livewire/organization/design/circuit/modify-url.blade.php`  
Rotta: `organization.design.circuit.modify-url` (`/organization/design/circuit/modify-url/{contest}`)

Nuovo componente Volt predisposto per la gestione dei 4 collegamenti ipertestuali pubblici del circuito:

- **Campi gestiti:**
  - `url1Rule` (`url_1_rule`): URL del bando o regolamento ufficiale del circuito.
  - `url2ConcurrentList` (`url_2_concurrent_list`): URL della bacheca partecipanti / iscritti.
  - `url3AdmitNAwardList` (`url_3_admit_n_award_list`): URL della bacheca risultati e ammessi/premiati.
  - `url4Catalogue` (`url_4_catalogue`): URL del catalogo ufficiale quando pubblicato.
- **Validazione:** Ciascun campo è validato con `'required|active_url|string|max:255'`.

---

### 3. Barra di Navigazione del Circuito (`circuit-nav.blade.php`)

File: `resources/views/livewire/organization/design/circuit/circuit-nav.blade.php`

Risolto il refuso nel nome del file (precedentemente denominato con estensione non valida `circuit-nav.blade-php`). Il componente espone ora la sequenza completa delle schede di configurazione circuito:

1. **Name n Infos:** rimanda a `organization.design.circuit.modify-name`
2. **Calendar:** rimanda a `organization.design.circuit.modify-calendar`
3. **Web links:** rimanda a `organization.design.circuit.modify-url`
4. **LAST: Contest details:** rimanda a `organization.design.contest.detail`
5. **Contest Docs Folder:** rimanda a `organization.docs.listed`

Inoltre, in `circuit/modify-name.blade.php`, il titolo dell'header è stato affinato da `{{ __('Modify Circuit infos') }}` a `{{ __('Modify Circuit main infos') }}`.

---

### 4. Dashboard Organizzazione: Gestione Differenziata Concorsi e Circuiti (`dashboard.blade.php`)

File: `resources/views/livewire/organization/dashboard.blade.php`

Nella sezione dei concorsi futuri in fase di design:

- Titolo della sezione aggiornato da `"Future Contests"` a `"Future Contests | Circuits"`.
- Introdotta la discriminazione in base al flag booleano `$contest->is_circuit`:
  - Se il record è un circuito (`is_circuit == true`), il link rimanda alla configurazione circuito: `route('organization.design.circuit.modify-name', ['contest' => $contest])`.
  - Se il record è un concorso singolo (`is_circuit == false`), il link rimanda alla configurazione concorso: `route('organization.design.contest.modify-name', ['contest' => $contest])`.

---

### 5. Correzioni e Refactoring su Concorso Singolo (`contest/modify-calendar.blade.php`)

File: `resources/views/livewire/organization/design/contest/modify-calendar.blade.php`

- **Fix sintassi regole di validazione:** Corretto un doppio pipe accidentale (`||`) nella regola di `voteRule`:
  ```php
  // Prima:
  'voteRule' => 'required|string||exists:contests_vote_rule_sets,vote_rule'
  // Dopo:
  'voteRule' => 'required|string|exists:contests_vote_rule_sets,vote_rule'
  ```
- **Localizzazione del messaggio di errore:** Sostituita la stringa fissa in italiano con la chiave di traduzione:
  ```php
  'day1Opening.after' => __("Opening participation day must be later than (yyyy-mm-dd): ") 
      . CarbonImmutable::now()->addMonths(2)->format('Y-m-d'),
  ```
- **Cleanup del codice:** Rimossa una riga vuota non necessaria all'interno del metodo `modifyContest()`.

---

### 6. Manutenzione Modello `Contest` (`app/Models/Contest.php`)

File: `app/Models/Contest.php`

- Rimosso il commento obsoleto `// unused - remove` sopra il getter statico `public static function getNameEn(string $contestId): string`, confermando che il metodo è regolarmente utilizzato nelle viste e nei componenti dell'applicazione.

---

### 7. Rotte Web (`routes/web.php`)

File: `routes/web.php`

Aggiunte due nuove rotte Volt dedicate alla progettazione del circuito, protette dai middleware `['auth', 'verified']`:

```php
Volt::route('/organization/design/circuit/modify-calendar/{contest}', 'organization.design.circuit.modify-calendar')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.circuit.modify-calendar');

Volt::route('/organization/design/circuit/modify-url/{contest}', 'organization.design.circuit.modify-url')
    ->middleware(['auth', 'verified'])
    ->name('organization.design.circuit.modify-url');
```

---

### 8. Internazionalizzazione e Traduzioni (`lang/en.json`, `lang/it.json`)

File: `resources/lang/en.json` e `resources/lang/it.json`

Inserite le nuove voci di traduzione per l'interfaccia in lingua inglese e italiana:
- `"1 Participants Circuit Opening"`
- `"2 Participants Circuit Deadline"`
- `"Circuit Contact info, HQ postal address, english"`
- `"Circuit denomination, english"`
- `"Circuit denomination, for local language"`
- `"Circuit infos updated."`
- `"Circuit is already created and this is the modify page"`
- `"Future Contests | Circuits"`
- `"Modify Circuit Calendar"`
- `"Modify Circuit main infos"`
- `"Opening data must be after (yyyy-mm-dd): "`
- `"Opening days have fixed time 00:00 on contest local timezone. Others 23:59 "`
- `"Opening participation day must be later than (yyyy-mm-dd): "`
- `"Start Modify your Circuit"`
- `"Vote Modal"`

---

### 9. Strumenti di Analisi Statica e Dipendenze (`composer.json`, `composer.lock`)

File: `composer.json` e `composer.lock`

- Aggiunti tra i pacchetti `require-dev`:
  - `"phpstan/phpstan": "^2.3"`
  - `"phpstan/phpstan-strict-rules": "^2.1"`
- Aggiornato il lockfile tramite `composer update` per integrare PHPStan e allineare le dipendenze minori (es. `egulias/email-validator`, `libphonenumber-for-php-lite`).

---

## 🗄️ Modifiche al Database

Nessuna nuova migrazione al database:

- La tabella `contests` gestisce già i circuiti tramite la colonna booleana `is_circuit`.
- I campi data (`day_1_opening` fino a `day_8_closing`), la regola di voto (`vote_rule`) e i link web (`url_1_rule` fino a `url_4_catalogue`) sono già nativamente presenti nella tabella.

---

## 📖 Documentazione Utente e Versioning

- **Manuale Utente:** Creata la guida tecnica/utente in `docs/1.0/contest_design/circuit/calendar.md` con la descrizione della logica delle 8 date fisse di circuito, dei contatori temporali e delle modalità di voto, supportata da 8 immagini esplicative (`calendar_img01.png` - `calendar_img08.png`).
- **Versione Applicativa:** Incrementata la patch di versione in `storage/app/private/version.json` da `2026.11.28` a `2026.11.29`.
- **Allineamento Documentale:** Chiusura dello stato in `docs/dev/feat/0435-contest-review.md`.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** La scheda tecnica in `docs/dev/feat/0437-contest-circuit-calendar.md` riflette esattamente le differenze con `main-2026`.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte (`docs/1.0/contest_design/circuit/calendar.md`).
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit seguono la convenzione standard del repository?

---

## 🚀 Note per il Deploy

Nessuna migrazione o azione speciale richiesta al deploy.
