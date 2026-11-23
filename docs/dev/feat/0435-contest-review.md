---
title: 'Feature: Contest Design: Circuit Add'
---

# Feature: Contest Design: Circuit Add

> **Branch:** `feat/0435-contest-review`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-11-16.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / Contest - Circuit Add  
> **Project/issue link:** [#435](https://github.com/mrai64/yapcp/issues/435)  
> **Milestone link:** [M7](https://github.com/mrai64/yapcp/milestones/7)
> **autori:** Antigravity, mrai64

- [📝 Logica Tecnica](#-logica-tecnica)
  - [Contesto e Obiettivi](#contesto-e-obiettivi)
  - [1. Creazione Iniziale del Circuito (`circuit/make.blade.php`)](#1-creazione-iniziale-del-circuito-circuitmakebladephp)
  - [2. Modifica Dati Principali del Circuito (`circuit/modify-name.blade.php`)](#2-modifica-dati-principali-del-circuito-circuitmodify-namebladephp)
  - [3. Barra di Navigazione del Circuito (`circuit-nav.blade.php`)](#3-barra-di-navigazione-del-circuito-circuit-navbladephp)
  - [4. Predisposizione Viste Correlate di Circuito (Placeholder Volt)](#4-predisposizione-viste-correlate-di-circuito-placeholder-volt)
  - [5. Integrazione nella Dashboard Organizzazione (`dashboard.blade.php`)](#5-integrazione-nella-dashboard-organizzazione-dashboardbladephp)
  - [6. Configurazione Rotte Web (`routes/web.php`)](#6-configurazione-rotte-web-routeswebphp)
  - [7. Correzione Bug Parametro Timezone (`<x-select-timezone-app>`)](#7-correzione-bug-parametro-timezone-x-select-timezone-app)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [📖 Documentazione Utente e Versioning](#-documentazione-utente-e-versioning)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Contesto e Obiettivi

L'organizzazione che gestisce i concorsi deve poter configurare con semplicità anche la struttura dei **circuiti**: raggruppamenti di concorsi che condividono lo stesso regolamento, gli stessi temi e sezioni e una segreteria unica di gestione delle iscrizioni, mantenendo tuttavia giurie distinte e premi specifici indipendenti.

Il sistema consente piena flessibilità nel flusso organizzativo:

- **Circuito prima dei concorsi:** definendo per primo il circuito, i successivi concorsi associati possono ereditare temi, sezioni e impostazioni comuni.
- **Concorsi prima del circuito:** è possibile creare liberamente i singoli concorsi e successivamente istituire il circuito, collegandoli mediante `circuit_id`.
- **Partecipazione unificata:** l'iscrizione a livello di circuito genera N record contestuali (uno per ciascun concorso/giuria).
- **Verbali indipendenti:** la gestione dei premi di circuito e la redazione del verbale restano indipendenti tra i singoli concorsi.

Rispetto al branch base `main-2026`, questo branch implementa il flusso iniziale di creazione e configurazione dei dati generali di un circuito e predispone i componenti di navigazione e le rotte collegate.

---

### 1. Creazione Iniziale del Circuito (`circuit/make.blade.php`)

File: `resources/views/livewire/organization/design/circuit/make.blade.php`  
Rotta: `organization.design.circuit.make` (`/organization/design/circuit/make/{organization}`)

Componente Volt (Step 0) che istanzia un nuovo record `Contest` dedicato al circuito:

- Imposta il flag `is_circuit = true`.
- Associa `organization_id` e preimposta `country_id` (ereditato dall'organizzazione) e `timezone_id` (ereditato dai contatti dell'utente creatore).
- Inizializza date scaglionate predefinite a partire da un anno nel futuro (`now()->addYear()`).
- Esegue subito il redirect alla maschera di modifica dati generali (`organization.design.circuit.modify-name`) con messaggio flash informativo.

```php
$circuit = Contest::create([
    'country_id'           => $organization->country_id,
    'name_en'              => '',
    'name_local'           => '',
    'organization_id'      => $organization->id,
    'is_circuit'           => true,
    'contest_mark'         => '',
    'contact_info'         => '',
    'award_ceremony_info'  => '',
    'fee_info'             => '',
    'timezone_id'          => $userContact->timezone_id,
    'day_1_opening'        => CarbonImmutable::now()->addYear()->startOfDay(),
    'day_2_closing'        => CarbonImmutable::now()->addYear()->addMonths(3)->endOfDay(),
    // ...
]);
```

---

### 2. Modifica Dati Principali del Circuito (`circuit/modify-name.blade.php`)

File: `resources/views/livewire/organization/design/circuit/modify-name.blade.php`  
Rotta: `organization.design.circuit.modify-name` (`/organization/design/circuit/modify-name/{contest}`)

Componente Volt single-file dedicato all'editing dei dati identificativi e informativi del circuito:

- **Dati gestiti:**
  - `circuitNameEn` (titolo in inglese, obbligatorio, max 250)
  - `circuitCountryId` (paese di riferimento con componente `<x-select-country-app>`)
  - `circuitTimezoneId` (fuso orario con componente `<x-select-timezone-app>`)
  - `circuitLangLocal` e `circuitNameLocal` (lingua e nome locali)
  - `circuitContactInfo` (recapiti della segreteria del circuito)
  - `circuitAwardCeremonyInfo` (informazioni sulla cerimonia di premiazione del circuito)
  - `circuitFeeInfo` (dettagli di pagamento quote per la partecipazione al circuito)
- **Validazione:** regole stringenti con verifica di esistenza nelle tabelle `countries` e `timezones` e limiti di 2000 caratteri sui campi descrittivi.
- **Salvataggio:** aggiornamento atomico del modello `Contest` e feedback all'utente tramite alert di successo.

---

### 3. Barra di Navigazione del Circuito (`circuit-nav.blade.php`)

File: `resources/views/components/yapcp/organization/design/circuit-nav.blade.php`

Nuovo componente Blade `<x-yapcp.organization.design.circuit-nav>` che uniforma la barra di navigazione nel contesto di design del circuito. Presenta 4 voci principali:

1. **Main data:** rimanda a `organization.design.circuit.modify-name`
2. **Sections:** rimanda a `organization.design.circuit-section.listed`
3. **Juries:** rimanda a `organization.design.circuit-jury.listed`
4. **Awards:** rimanda a `organization.design.circuit-award.listed`

> *Nota di design:* la voce Patronages presente nei singoli concorsi è stata esclusa da questa barra poiché i patronati sono associati specificamente ai singoli concorsi costituenti e non al circuito.

---

### 4. Predisposizione Viste Correlate di Circuito (Placeholder Volt)

Per garantire la coerenza della barra di navigazione e preparare le successive implementazioni, sono stati creati i componenti Volt di partenza:

- `resources/views/livewire/organization/design/circuit-section/listed.blade.php` (elenco sezioni circuito)
- `resources/views/livewire/organization/design/circuit-jury/listed.blade.php` (elenco giurie circuito)
- `resources/views/livewire/organization/design/circuit-award/listed.blade.php` (elenco premi circuito)

---

### 5. Integrazione nella Dashboard Organizzazione (`dashboard.blade.php`)

File: `resources/views/livewire/organization/dashboard.blade.php`

Nel pannello di gestione dell'organizzazione è stato aggiunto il link d'azione rapida:

```blade
<x-yapcp.inline-link 
    txt="Design new Circuit" 
    url="{{ route('organization.design.circuit.make', ['organization' => $organization]) }}" />
```

affiancato al preesistente `Design new Contest`.

---

### 6. Configurazione Rotte Web (`routes/web.php`)

Aggiunte in `routes/web.php` 5 nuove rotte protette dai middleware `['auth', 'verified']`:

- `organization.design.circuit.make` (`/organization/design/circuit/make/{organization}`)
- `organization.design.circuit.modify-name` (`/organization/design/circuit/modify-name/{contest}`)
- `organization.design.circuit-section.listed` (`/organization/design/circuit-section/listed/{contest}`)
- `organization.design.circuit-jury.listed` (`/organization/design/circuit-jury/listed/{contest}`)
- `organization.design.circuit-award.listed` (`/organization/design/circuit-award/listed/{contest}`)

---

### 7. Correzione Bug Parametro Timezone (`<x-select-timezone-app>`)

Durante l'implementazione delle maschere di inserimento, è stata rilevata e corretta una discrepanza nella chiamata al componente blade `<x-select-timezone-app>`, dove veniva erroneamente passato `:country_id` anziché `:timezone_id`:

- `resources/views/livewire/organization/design/contest/modify-name.blade.php`
- `resources/views/livewire/federation/add.blade.php`
- `resources/views/livewire/federation/modify.blade.php`

---

## 🗄️ Modifiche al Database

Nessuna nuova migrazione necessaria:

- Il modello `Contest` supporta nativamente la natura di circuito tramite la colonna `is_circuit` (boolean) e contiene già tutti i campi impiegati (`contact_info`, `award_ceremony_info`, `fee_info`, `timezone_id`, `day_1_opening`, ecc.).

---

## 📖 Documentazione Utente e Versioning

- **Manuale Utente:** creata la guida per la creazione dei circuiti in `docs/1.0/contest_design/circuit/add.md` corredata da 4 schermate illustrative (`add_img01.png` - `add_img04.png`).
- **Versione Applicativa:** aggiornato `storage/app/private/version.json` alla versione `2026.11.24`.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Verificare che l'intera suite di test passi (`php artisan test`).
- [x] **Docs:** Scheda tecnica in `docs/dev/feat/0435-contest-review.md` aggiornata con tutti i componenti, rotte e bugfix del branch.
- [x] **Manual:** Manuale utente redatto in `docs/1.0/contest_design/circuit/add.md`.
- [x] **Cleanup:** Nessun `dd()` o `dump()` dimenticato nel codice.
- [x] **Commit:** Cronologia commit lineare e parlante con convenzione Conventional Commits.

---

## 🚀 Note per il Deploy

Nessuna migrazione o azione speciale richiesta al deploy.
