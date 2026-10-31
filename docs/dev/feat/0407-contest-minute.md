---
title: 'Feature: Bozza del Verbale di Giuria'
---

# Feature: Bozza del Verbale di Giuria

> **Branch:** `feat/0407-contest-minute`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-29.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Manage / Jury Minute review  
> **Project/issue link:** [#407](https://github.com/mrai64/yapcp/issues/407)  
> **Milestone link:** [M6](https://github.com/mrai64/yapcp/milestones/6)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Al termine dell'assegnazione dei premi di concorso, tutti i dati necessari alla redazione del verbale di Giuria sono disponibili sulla piattaforma. Rispetto all'approccio precedentemente presente nel branch `refactor/0140-big-rebuild`, l'intera gestione della bozza del verbale è stata riprogettata sia a livello architetturale che funzionale.

### 1. Motivazione del Refactoring ed Evoluzione Architetturale

Nel branch `refactor/0140-big-rebuild`:

- La bozza del verbale veniva generata tramite un controller tradizionale (`app/Http/Controllers/Contest/JuryMinuteDraft.php`) che si appoggiava a `Spatie/LaravelPdf` e `Browsershot` per produrre un file PDF A4 scaricabile.
- Tale approccio presentava forti limiti tecnici e operativi:
  - Dipendenza da un binario headless locale di Google Chrome (`$chromePath`), fragile da configurare e mantenere in ambienti di produzione o container.
  - La logica di estrazione dei dati era accorpata nel controller tramite query raw multiple (`DB::table(...)`), join manuali e complessi cicli PHP di rielaborazione.
  - L'output in PDF risultava poco flessibile: gli organizzatori dispongono spesso di propria carta intestata o devono compilare moduli vincolanti predisposti dalle federazioni patrocinanti (es. FIAF, FIAP), rendendo difficile il riutilizzo del documento pre-renderizzato.

Nel branch `feat/0407-contest-minute`:

- Abbandono della dipendenza dal rendering PDF headless e transizione completa a un componente single-file **Livewire Volt** (`resources/views/livewire/organization/contest-award/minute.blade.php`), allineato all'architettura standard dell'applicazione.
- Presentazione a video del verbale completo, formattato e pronto per il copia-incolla immediato verso editor di testo esterni o carta intestata.
- Introduzione dello scarico diretto nei formati **Testo Puro (.txt)** e **Markdown (.md)** tramite streaming HTTP, garantendo massima portabilità per redazioni successive e firme digitali remote.
- Incapsulamento delle query e delle metriche statistiche all'interno del model `Contest`, sfruttando le capacità native di Eloquent (`withCount`, eager loading `with`).
- Deprecazione e dismissione del vecchio controller `JuryMinuteDraft.php` e della vista `draft.blade.php` (archiviati con estensione `.bak`).

---

### 2. Metodi del Modello Dati (`app/Models/Contest.php`)

Per supportare la composizione del verbale in modo pulito ed efficiente, sono stati aggiunti quattro metodi dedicati sul model `Contest`:

1. **`getSectionWithSortedJuries()`**:
   - Recupera le sezioni del concorso (`sections()`) ordinate alfabeticamente per codice (`code`).
   - Carica in eager loading le giurie (`contestJuries`) ordinate prioritariamente per il Presidente (`orderBy('is_president', 'desc')`) e con la relazione `userContact` (comprensiva del paese associato).
2. **`getSectionsStats()`**:
   - Calcola in un'unica query aggregata le metriche per ciascuna sezione (`contestSections()`) tramite `withCount`:
     - Opere complessive (`total_works_count`) e opere ammesse (`admitted_works_count` con `is_admit = true`).
     - Autori totali distinti (`total_authors_count` tramite `count(distinct user_id)`).
     - Autori ammessi distinti (`admitted_authors_count` con filtro `is_admit = true`).
     - Nazioni totali distinte partecipanti (`total_countries_count` tramite `count(distinct country_id)`).
     - Nazioni distinte ammesse (`admitted_countries_count` con filtro `is_admit = true`).
3. **`getSectionAwards()`**:
   - Recupera le sezioni ordinate per codice con i premi assegnati (`awards`) ordinati per `award_code`, corredati dai dati sull'opera vincitrice (`contestWork.userWork`), sull'autore (`contestWork.author.country`), sull'utente vincitore e sull'eventuale motivazione (`citation`).
4. **`getSortedUniqueJuries()`**:
   - Estrae tutti i giurati del concorso (`contestJuries`), deduplica per `user_id` e li ordina alfabeticamente per cognome e nome del contatto (`last_name, first_name`), fondamentale per predisporre il blocco delle firme.

Inoltre, sono stati aggiornati i PHPDoc del model con le relazioni `@property-read Collection<int, ContestJury> $contestJuries` e `@property-read Collection<int, ContestParticipant> $contestParticipants`.

---

### 3. Rotte e Navigazione (`routes/web.php`)

- Registrata la nuova route Volt protetta dai middleware `['auth', 'verified']`:

  ```php
  Volt::route('/organization/contest-award/minute-draft/{contest}', 'organization.contest-award.minute')
      ->middleware(['auth', 'verified'])
      ->name('organization.contest-award.minute');
  ```

- Sostituita la precedente route controller `/organization/contest/jury-minute/{contest}`.
- Inserito il pulsante di navigazione `Final Minute Draft` nella dashboard di giuria (`resources/views/livewire/organization/contest-jury/juror-board.blade.php`), permettendo agli organizzatori di accedere alla bozza del verbale subito dopo la conclusione delle votazioni e l'assegnazione dei premi.

---

### 4. Componente Livewire Volt (`minute.blade.php`)

Il componente `resources/views/livewire/organization/contest-award/minute.blade.php` gestisce sia la visualizzazione interattiva del verbale che il download dei file esportati:

- **Proprietà Computate (`#[Computed]`):**
  - I dati per la vista sono incapsulati in metodi con attributo `#[Computed]` (`sectionJuries`, `sectionStats`, `sectionAwards`, `contestAwards`, `sortedJurors`).
  - Questo assicura il caching durante la richiesta e preserva la corretta reidratazione dello stato Livewire quando l'utente attiva le azioni di download senza dover ricaricare la pagina.
- **Azioni di Download tramite Stream (`streamDownload`):**
  - **`downloadTxt()`**: Esegue il rendering della vista dedicata `livewire.organization.contest-award.minute-txt` e restituisce lo stream con header `Content-Type: text/plain; charset=utf-8` e nome file `contest-minute-{slug}-{date}.txt`.
  - **`downloadMarkdown()`**: Esegue il rendering della vista dedicata `livewire.organization.contest-award.minute-md` e restituisce lo stream con header `Content-Type: text/markdown; charset=utf-8` e nome file `contest-minute-{slug}-{date}.md`.
- **Interfaccia Utente e Struttura del Verbale a Video:**
  - **Header:** Informazioni generali sul concorso, istruzioni operative per l'organizzazione e link di ritorno alle dashboard (`user.dashboard` e `organization.dashboard`).
  - **Barra Azioni:** Pulsanti per lo scarico immediato in TXT e Markdown con stato di disabilitazione durante il caricamento (`wire:loading.attr="disabled"`).
  - **Delimitatori di Copia/Incolla:** Marcatori visivi espliciti (`CUT -- Minute start here -- CUT` e `CUT -- Minute stop here -- CUT`).
  - **Sezioni del Verbale:**
    1. *Data e intestazione:* Concorso e organizzazione promotrice.
    2. *Composizione Giurie per Tema/Sezione:* Con distinzione tra Presidente (`P`) e Giurato (`J`), codice bandiera, codice ISO paese e nominativo.
    3. *Data di inizio lavori giuria:* (`day_3_jury_opening`) con sezione per la descrizione del modus operandi.
    4. *Statistiche Opere e Partecipanti:* Riepilogo delle opere pervenute, autori partecipanti e nazioni rappresentate per ciascuna sezione.
    5. *Statistiche Opere e Autori Ammessi:* Riepilogo delle ammissioni deliberate dalla giuria per ciascuna sezione.
    6. *Premi Assegnati per Sezione:* Elenco premi con codice premio, nome premio, opera premiata, autore con città e nazione, eventuale vincitore nominativo e motivazione della giuria (`citation`).
    7. *Premi Generali di Concorso:* Elenco dei premi complessivi di concorso con relative motivazioni.
    8. *Spazio Firme:* Sottoscrizioni per data e luogo, Presidente dell'organizzazione / Contest Manager, e linee di firma individuali per ciascun giurato unico ordinato per cognome.

---

### 5. Template di Esportazione Dedicati (`minute-txt.blade.php` e `minute-md.blade.php`)

Per evitare frammentazioni o imperfezioni nel copia-incolla manuale dall'interfaccia HTML, sono state create due Blade ausiliarie:

- **`minute-txt.blade.php`**: Versione in testo puro formattata con righe chiare e separatori visivi, ideale per l'inserimento in software di videoscrittura o modulistica tradizionale.
- **`minute-md.blade.php`**: Versione in formato Markdown arricchita con intestazioni strutturate (`#`, `##`, `###`), elenchi e testo in enfasi, pronta per l'archiviazione digitale o la condivisione per firma remota dei giurati.

---

### 6. Pulizia e Dismissione Componenti Legacy

- Il precedente controller `app/Http/Controllers/Contest/JuryMinuteDraft.php` è stato rimosso dal ciclo attivo e rinominato in `JuryMinuteDraft.bak`.
- La precedente vista `resources/views/livewire/organization/minute/draft.blade.php` è stata rinominata in `draft.blade.bak`.
- Sono state dismesse e archiviate con suffisso `.bak` le vecchie viste di ammissione e assegnazione premi non più conformi all'architettura Volt attuale.

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
