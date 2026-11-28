---
title: 'Feature: Section n themes in Circuit'
---

> **Branch:** `feat/0448-contest-section`  
> **Project/issue link:** [#448](https://github.com/mrai64/yapcp/issues/448)  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-11-27.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / Contest - Circuit Add / 5 ContestSection CRUD  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)  
> **Autori:** mrai64, Antigravity

- [📝 Logica Tecnica](#-logica-tecnica)
  - [Contesto e Scelta Architetturale](#contesto-e-scelta-architetturale)
  - [1. Componenti Livewire Volt CRUD Circuit Section (`circuit-section/*`)](#1-componenti-livewire-volt-crud-circuit-section-circuit-section)
  - [2. Allineamento Tipizzazione su Concorso Singolo (`contest-section/add.blade.php`)](#2-allineamento-tipizzazione-su-concorso-singolo-contest-sectionaddbladephp)
  - [3. Rotte Web (`routes/web.php`)](#3-rotte-web-routeswebphp)
  - [4. Internazionalizzazione (`resources/lang/en.json`, `resources/lang/it.json`)](#4-internazionalizzazione-resourceslangenjson-resourceslangitjson)
  - [5. Documentazione Utente e Versionamento](#5-documentazione-utente-e-versionamento)
  - [6. Dipendenze (`composer.lock`)](#6-dipendenze-composerlock)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Contesto e Scelta Architetturale

Il circuito concorsi è per definizione un gruppo di concorsi che condivide una sola organizzazione, un solo calendario e gli stessi temi e sezioni di concorso (`ContestSection`).

In coerenza con la separazione già adottata per le altre funzionalità di configurazione del circuito (`circuit/*` e `circuit-patronage/*`), il CRUD delle sezioni di circuito è stato realizzato con componenti Livewire Volt dedicati in `resources/views/livewire/organization/design/circuit-section/`, completando lo stub `listed.blade.php` già presente su `main-2026` e aggiungendo `add.blade.php`, `modify.blade.php`, `remove.blade.php` e `section-nav.blade.php`.

---

### 1. Componenti Livewire Volt CRUD Circuit Section (`circuit-section/*`)

- **`resources/views/livewire/organization/design/circuit-section/listed.blade.php`**
  - Rotta: `organization.design.circuit-section.listed` (`/organization/design/circuit-section/listed/{contest}`).
  - Sostituito lo stub precedente (`//`) con l'elenco completo delle sezioni del circuito (`$contest->sections`).
  - Header con `<x-yapcp.organization.design.circuit-nav :circuit="$circuit" active="sections" />`, `<livewire:organization.design.circuit-section.section-nav :contest="$circuit" />` e collegamenti alle dashboard e all'aggiunta sezione.
  - Per ogni sezione visualizza in tabella i parametri principali (patrocinio, formati ammessi, min/max opere, dimensioni massime lato corto/lungo, dimensione massima file, monocromatico, RAW richiesto, premio unico) e i link inline `Modify` (`organization.design.circuit-section.modify`) e `Remove` (`organization.design.circuit-section.remove`).
  - *Note sullo stato del codice:* il link `"Add Section"` nell'header punta attualmente a `organization.design.contest-section.add` anziché `organization.design.circuit-section.add` (usato invece nei link del corpo pagina); inoltre, dopo il ciclo `@foreach`, è presente un tag di chiusura `</dl>` privo di `<dl>` di apertura.

- **`resources/views/livewire/organization/design/circuit-section/add.blade.php`**
  - Rotta: `organization.design.circuit-section.add` (`/organization/design/circuit-section/add/{contest}`).
  - In `mount(Contest $contest)` verifica l'autorizzazione con `$this->authorize('create', [ContestSection::class, $contest])`, determina `$hasContestPatronages = $this->circuit->contestPatronage()->exists()` e inizializza i valori di default (`file_formats = 'jpg'`, `min_works = 0`, `max_works = 0`, `short_size_max = 1000`, `long_size_max = 1000`, `file_size_max = 100000`, flag booleani `false`).
  - Gestisce sia sezioni libere sia sezioni sotto patrocinio (`$contestSectionUnderPatronage`), con selezione a cascata di federazione (`selectedFederationId` → `#[Computed] getFederationsSet()`) e sezione federale (`selectedSectionCode` → `#[Computed] getFederationSectionSet()`). Gli hook `updatedSelectedFederationId()`, `updatedSelectedSectionCode()` e `updatedContestSectionUnderPatronage()` precompilano o resettano i campi dai valori di `FederationSection`.
  - Validazione con regole condizionali in base a `contestSectionUnderPatronage`, regola custom `ValidFileFormats`, limiti opere `0..12` (`max >= min`), dimensioni `short/long` fino a `4000` (`long >= short`) e peso file `100000..6000000`.
  - `addContestSection()` persiste tramite `ContestSection::updateOrCreate(['contest_id' => $this->circuit->id, 'code' => $validated['contestSectionCode']], ...)` e reindirizza a `organization.design.circuit-section.listed` con messaggio `__('New Section added to contest, enjoy!')`.
  - *Nota sullo stato del codice:* nel ramo non patrocinato la regola su `contestSectionCode` usa `'nullable|string|uppercase:max:10'` (due punti prima di `max` anziché pipe).

- **`resources/views/livewire/organization/design/circuit-section/modify.blade.php`**
  - Rotta: `organization.design.circuit-section.modify` (`/organization/design/circuit-section/modify/{contest_section}`).
  - In `mount(ContestSection $contest_section)` verifica `$this->authorize('update', [ContestSection::class, $contest_section])` e popola lo stato iniziale del form (inclusi `selectedFederationId` e `selectedSectionCode` quando `under_patronage` è `true`).
  - Replica la selezione reattiva `Federation` / `FederationSection` e le regole di validazione di `add.blade.php`.
  - `modifyContestSection()` normalizza `0`/vuoto a `null` per `federation_section_id`, aggiorna `$this->contestSection` e reindirizza a `organization.design.circuit-section.listed` con `__('Section modified, enjoy!')`.

- **`resources/views/livewire/organization/design/circuit-section/remove.blade.php`**
  - Rotta: `organization.design.circuit-section.remove` (`/organization/design/circuit-section/remove/{contest_section}`).
  - In `mount(ContestSection $contest_section)` carica `contestSection`, `circuit` e `organization` (senza chiamata `$this->authorize(...)`).
  - Mostra in riepilogo (`<dl>`) tutti i dati della sezione prima della conferma; `removeContestSection()` esegue `$this->contestSection->delete()` e reindirizza a `organization.design.circuit-section.listed` con `__('Section removed, as confirmed.')`.

- **`resources/views/livewire/organization/design/circuit-section/section-nav.blade.php`**
  - Nuovo sotto-componente di navigazione con il collegamento `Listed` verso `organization.design.circuit-section.listed`.

---

### 2. Allineamento Tipizzazione su Concorso Singolo (`contest-section/add.blade.php`)

In `resources/views/livewire/organization/design/contest-section/add.blade.php` è stata corretta la dichiarazione delle proprietà booleane da `string` a `bool`:
- `$contestSectionMonochromaticRequired`
- `$contestSectionRawRequired`
- `$contestSectionUniquePrize`

---

### 3. Rotte Web (`routes/web.php`)

In `routes/web.php`, accanto alla rotta già esistente `organization.design.circuit-section.listed`, sono state aggiunte le 3 rotte Volt protette da middleware `['auth', 'verified']`:
- `organization.design.circuit-section.add` (`/organization/design/circuit-section/add/{contest}`)
- `organization.design.circuit-section.modify` (`/organization/design/circuit-section/modify/{contest_section}`)
- `organization.design.circuit-section.remove` (`/organization/design/circuit-section/remove/{contest_section}`)

---

### 4. Internazionalizzazione (`resources/lang/en.json`, `resources/lang/it.json`)

Aggiunte in entrambi i file le 11 nuove chiavi di traduzione per le viste `circuit-section`:
- `"Add Circuit Section n Theme"`
- `"Add first Section n theme to your Circuit"`
- `"Circuit Section n theme"`
- `"Circuit Section n Themes List"`
- `"Federation Id 🔓"`
- `"Federation Section Code 🔓"`
- `"Modify Circuit Section info"`
- `"REMOVE a Circuit Section n Theme"`
- `"This section is"`
- `"Under patronage, choose it from FederationSections"`
- `"When a circuit is also under federation patronage, some theme n section are already defined by federation and should follow federation section parms."`

---

### 5. Documentazione Utente e Versionamento

- **`docs/1.0/circuit_design/section/`:** aggiunte 4 pagine del manuale utente (`add1.md`, `add2.md`, `modify.md`, `remove.md`) e 15 immagini (`add1_img01.png`–`add1_img04.png`, `add2_img01.png`–`add2_img04.png`, `modify_img01.png`–`modify_img04.png`, `remove_img01.png`–`remove_img03.png`). *(Nota: le pagine del manuale referenziano anche `./listed.md`, non ancora presente su questo branch.)*
- **`docs/1.0/contest_design/section/add2.md`:** rifiniti alcuni testi esplicativi e sostituito il link relativo a `../patronages/add.md` con una nota testuale.
- **`storage/app/private/version.json`:** incrementata la versione da `2026.11.39` a `2026.11.41`.

---

### 6. Dipendenze (`composer.lock`)

Aggiornato `composer.lock` nel commit `fix: composer update` con l'avanzamento dei pacchetti Symfony da `v8.1.12` a `v8.1.13` (`symfony/finder`, `symfony/html-sanitizer`, `symfony/http-foundation`, `symfony/http-kernel`, `symfony/property-access`, `symfony/serializer`, `symfony/string`, `symfony/yaml`).

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database: la tabella `contest_sections` gestisce già le sezioni dei circuiti tramite la colonna `contest_id`.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
