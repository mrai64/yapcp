---
title: 'Feature: Organization Contest Design / Circuit - Contest PatronageS add'
---

> **Branch:** `feat/0444-contest-patronage-circuit`  
> **Project/issue link:** [#444](https://github.com/mrai64/yapcp/issues/444)  
> **Stato:** In Corso / Revisione  
> **priorità:** A  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, senza id  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)  
> **Autori:** mrai64, Antigravity

- [📝 Logica Tecnica](#-logica-tecnica)
  - [Contesto e Scelta Architetturale](#contesto-e-scelta-architetturale)
  - [1. Componenti Livewire Volt CRUD Circuit Patronage (`circuit-patronage/*`)](#1-componenti-livewire-volt-crud-circuit-patronage-circuit-patronage)
  - [2. Componenti di Navigazione Circuito (`circuit-nav.blade.php`)](#2-componenti-di-navigazione-circuito-circuit-navbladephp)
  - [3. Rotte Web e Route Model Binding (`routes/web.php`, `AppServiceProvider.php`)](#3-rotte-web-e-route-model-binding-routeswebphp-appserviceproviderphp)
  - [4. Internazionalizzazione (`resources/lang/en.json`, `resources/lang/it.json`)](#4-internazionalizzazione-resourceslangenjson-resourceslangitjson)
  - [5. Documentazione Utente e Template Dev](#5-documentazione-utente-e-template-dev)
  - [6. Dipendenze (`composer.lock`)](#6-dipendenze-composerlock)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Contesto e Scelta Architetturale

Come i concorsi singoli, anche i circuiti possono essere soggetti a patrocinio da parte di federazioni; nel caso dei circuiti vengono però utilizzati più codici di patrocinio per la stessa federazione (ad esempio 3 o 5), quindi il campo `patronage_code` (portato a 72 caratteri su `main-2026`) ospita tutti i codici della medesima federazione separati da uno spazio. Trattandosi di un dato informativo che altrimenti richiederebbe la lettura e la concatenazione dei patrocini di tutti i concorsi inclusi nel circuito, i codici vengono inseriti manualmente dall'organizzazione a livello di circuito.

In coerenza con la separazione già adottata per le altre schermate di configurazione circuito (`circuit/*`), il CRUD dei patrocini di circuito è implementato con quattro componenti Livewire Volt dedicati in `resources/views/livewire/organization/design/circuit-patronage/` invece di estendere con logica condizionale i componenti `contest-patronage/`.

---

### 1. Componenti Livewire Volt CRUD Circuit Patronage (`circuit-patronage/*`)

Tutti i componenti operano sul modello `ContestPatronage` associato al `Contest` (circuito) e usano il layout di navigazione `<x-yapcp.organization.design.circuit-nav :circuit="$..." active="patronages" />`:

- **`resources/views/livewire/organization/design/circuit-patronage/listed.blade.php`**
  - Rotta: `organization.design.circuit-patronage.listed` (`/organization/design/circuit-patronage/listed/{contest}`).
  - Carica `Contest $contest`, `Organization $organization` e l'elenco `ContestPatronage` filtrato per `contest_id`, ordinato per `federation_id` e `patronage_code`.
  - Mostra i patrocini assegnati al circuito con i link alle azioni `Modify` e `Remove` e il link nell'header per `Add Federation Patronage`.

- **`resources/views/livewire/organization/design/circuit-patronage/add.blade.php`**
  - Rotta: `organization.design.circuit-patronage.add` (`/organization/design/circuit-patronage/add/{contest}`).
  - In `mount(Contest $contest)` verifica l'autorizzazione tramite `$this->authorize('create', [ContestPatronage::class, $contest])` e carica tutte le federazioni (`Federation::query()->with(['country'])->orderBy('country_id', 'asc')->orderBy('name_en', 'asc')->get()`).
  - Regole di validazione:
    - `contPatrFederationId`: `required|string|exists:federations,id`
    - `contPatrPatronageCode`: `required|string|uppercase|max:72`
  - Il metodo `addCircuitPatronage()` cerca un record esistente (anche eliminato via soft-delete) con `ContestPatronage::withTrashed()->where('contest_id', $contestId)->where('federation_id', $federationId)->first()`:
    - se trovato ed eliminato (`trashed()`), lo ripristina con `restore()` e aggiorna `patronage_code`;
    - se trovato attivo, aggiorna `patronage_code`;
    - altrimenti crea un nuovo `ContestPatronage`.
  - Al termine reindirizza a `organization.design.circuit-patronage.listed` con messaggio `__('New Federation Patronage added, enjoy!')`.

- **`resources/views/livewire/organization/design/circuit-patronage/modify.blade.php`**
  - Rotta: `organization.design.circuit-patronage.modify` (`/organization/design/circuit-patronage/modify/{contest_patronage}`).
  - In `mount(ContestPatronage $contest_patronage)` verifica l'autorizzazione tramite `$this->authorize('update', [ContestPatronage::class, $contest_patronage])` e inizializza `contPatrFederationId` e `contPatrPatronageCode`.
  - Regole di validazione identiche a `add.blade.php` (`max:72`, `uppercase`).
  - Il metodo `modifyContestPatronage()` aggiorna `patronage_code` se la federazione resta invariata; se `federation_id` cambia, elimina il record precedente (`delete()`) e ne crea uno nuovo.
  - *Nota:* il redirect finale punta attualmente alla rotta `organization.design.contest-patronage.listed` anziché `organization.design.circuit-patronage.listed`.

- **`resources/views/livewire/organization/design/circuit-patronage/remove.blade.php`**
  - Rotta: `organization.design.circuit-patronage.remove` (`/organization/design/circuit-patronage/remove/{contest_patronage}`).
  - In `mount(ContestPatronage $contest_patronage)` verifica l'autorizzazione tramite `$this->authorize('delete', [ContestPatronage::class, $contest_patronage])`.
  - Il metodo `removeContestPatronage()` esegue `$this->contestPatronage->delete()`.
  - *Nota:* il redirect finale punta attualmente alla rotta `organization.design.contest-patronage.listed` con messaggio `__('Federation Patronage modified, enjoy!')`.

---

### 2. Componenti di Navigazione Circuito (`circuit-nav.blade.php`)

- **`resources/views/components/yapcp/organization/design/circuit-nav.blade.php`:**
  - Aggiunto il tab `Patronages` verso `route('organization.design.circuit-patronage.listed', ['contest' => $circuit])` con `:active="$active == 'patronages'"`.
  - Uniformati i parametri delle rotte per `Sections`, `Juries` e `Awards` passando esplicitamente `['contest' => $circuit]`.
- **`resources/views/livewire/organization/design/circuit/circuit-nav.blade.php`:**
  - Modificato l'attributo `url` dei cinque `<x-yapcp.header-link>` rimuovendo le parentesi graffe Blade (`url="route(...)"` al posto di `url="{{ route(...) }}"`).

---

### 3. Rotte Web e Route Model Binding (`routes/web.php`, `AppServiceProvider.php`)

- **`routes/web.php`:** aggiunte le 4 rotte Volt sotto middleware `['auth', 'verified']`:
  - `organization.design.circuit-patronage.listed` (`/organization/design/circuit-patronage/listed/{contest}`)
  - `organization.design.circuit-patronage.add` (`/organization/design/circuit-patronage/add/{contest}`)
  - `organization.design.circuit-patronage.modify` (`/organization/design/circuit-patronage/modify/{contest_patronage}`)
  - `organization.design.circuit-patronage.remove` (`/organization/design/circuit-patronage/remove/{contest_patronage}`)
- **`app/Providers/AppServiceProvider.php`:** aggiunta la registrazione `Route::model('circuit-patronage', ContestPatronage::class);` (mentre le rotte definite in `routes/web.php` utilizzano il parametro `{contest_patronage}`, già associato a `ContestPatronage::class`).

---

### 4. Internazionalizzazione (`resources/lang/en.json`, `resources/lang/it.json`)

Aggiunte in entrambi i file le 6 nuove chiavi di traduzione per le viste `circuit-patronage`:
- `"Add Federation Patronages Codes for Circuit"`
- `"Federation Patronage Code Remove for Circuit"`
- `"Insert all patronage codes from the same federation, using space as separator."`
- `"Modify Federation Patronages Codes for Circuit "`
- `"Next, for every contest insert single contest federation patronage code."`
- `"Patronage codes"`

---

### 5. Documentazione Utente e Template Dev

- **`docs/1.0/circuit_design/patronage/`:** aggiunte le 4 pagine del manuale utente (`listed.md`, `add.md`, `modify.md`, `remove.md`) e i relativi screenshot (`add_img01.png`–`add_img06.png`, `listed_im01.png`, `modify_img01.png`–`modify_img04.png`, `remove_img01.png`–`remove_img03.png`). *(Nota: `listed.md` referenzia `./listed_img01.png` mentre il file immagine salvato si chiama `listed_im01.png`.)*
- **`docs/1.0/navigation.json`:** rimossa la voce `contest_design/circuit/add` e aggiunte nella sezione dedicata le voci `circuit_design/circuit/add`, `circuit_design/patronage/listed`, `circuit_design/jury/listed`, `circuit_design/award/listed`.
- **`docs/dev/template.md`:** aggiunta la riga `> **Autori:** mrai64, antigravity / copilot / gemini / claude`.

---

### 6. Dipendenze (`composer.lock`)

Aggiornato `composer.lock` nel commit `fix: composer update` (`league/commonmark` da `2.10.8` a `2.10.10` e `composer/xdebug-handler` da `3.0.5` a `3.1.0`).

## 🗄️ Modifiche al Database

Nessuna nuova migrazione introdotta in questo branch: la modifica alla lunghezza della colonna `contest_patronages.patronage_code` (da `20` a `72` caratteri, charset `ascii`, collation `ascii_general_ci`) è già presente su `main-2026` tramite `database/migrations/2026_11_25_195803_mod_col_in_contest_patronages_table.php`.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione aggiuntiva rispetto a `main-2026` o azione speciale richiesta al deploy.
