---
title: 'Feature: Modello ContestCatalogPage e Layout Set'
---

# Feature: Modello ContestCatalogPage e Layout Set

> **Branch:** `feat/0422-contest-catalog-page`  
> **Stato:** Revisione  
> **priorità:** B  
> **id assegnato:** 2026-11-06.02  
> **Titolo e urgenza:** (B) feat: Nuovo modello ContestCatalogPage oppure ContestSlide  
> **Project/issue link:** [#422](https://github.com/mrai64/yapcp/issues/422)  
> **Milestone link:** [M7](https://github.com/mrai64/yapcp/milestones/7)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La piattaforma yaPCP gestisce nativamente l'intero ciclo di vita di un concorso fotografico: ricezione delle opere, verifiche dimensionali, sessioni di voto della giuria, attribuzione delle ammissioni, verbali e assegnazione dei premi. Tutte queste informazioni costituiscono la base per la pubblicazione del **Catalogo Ufficiale del Concorso**.

Un catalogo fotografico non è assimilabile a una semplice query a schermo: si tratta di una sequenza editoriale di pagine/slide (copertina, composizione della giuria, pagine introduttive delle sezioni tematiche, opere ammesse, premiati, citazioni e verbali) che richiede:

1. Un ordinamento progressivo rigoroso (`page`).
2. Una tipologia di layout formale e standardizzata per ciascuna slide (`layout_type`).
3. La possibilità di gestire elementi grafici e testuali opzionali o dedicati (foto di giuria, loghi federali, badge sponsor, discorsi dei giurati).
4. La conservazione dei **dati congelati (*snapshot pattern*)** per assicurare che il catalogo rimanga immutabile nel tempo anche qualora un concorrente modifichi il proprio profilo anagrafico o cancelli il proprio account.

A questo scopo il branch introduce due nuovi modelli Eloquent (`ContestCatalogPagesLayoutSet` e `ContestCatalogPage`), completi di migrazioni, factory, seeder, policy e della normalizzazione dell'intera rete di relazioni tra i modelli del concorso.

---

### 1. Motivazione ed Evoluzione Architetturale (Confronto con `refactor/0140-big-rebuild`)

Nel branch `refactor/0140-big-rebuild`:

- **Assenza di persistenza editoriale del catalogo:** Non esisteva alcuna struttura dati per memorizzare, personalizzare, sequenziare o archiviare le pagine/slide che compongono un catalogo di concorso.
- **Mancanza di standardizzazione dei layout:** Non vi era alcuna tabella di lookup per catalogare le tipologie di pagina supportate e i relativi percorsi dei template Blade.
- **Nessuna protezione da cancellazioni o modifiche (*snapshot* assente):** Qualsiasi ipotetica composizione on-the-fly dipendeva interamente dai record dinamici delle opere (`user_works`) e dei profili (`user_contacts`). In caso di soft delete, cancellazione o modifica del titolo dell'opera o dell'anagrafica da parte dell'autore, il catalogo storico sarebbe risultato corrotto o incoerente.
- **Relazioni inter-modello incomplete o affette da anomalie:**
  - `ContestAward::contestSection()`: falliva sistematicamente restituendo `null` poiché cercava per convenzione di default la foreign key inesistente `contest_section_id`, mentre a database la colonna è denominata `section_id`.
  - `ContestWork::contestAwards()`: mappava la relazione con local key errata su `user_work_id` (anziché `id`) ed era vincolata da un filtro `->where('section_id', $this->section_id)` che escludeva i premi di concorso/circuito (aventi `section_id = null`) e rompeva l'eager loading (`with('contestAwards')`).
  - `ContestAward::userWork()`: tentava una join diretta incompatibile (`winner_user_id` su `user_works.user_id`), mentre l'opera premiata è referenziata tramite `winner_work_id` $\rightarrow$ `contest_works.id`.
  - Mancavano i collegamenti dichiarativi tra il concorso (`Contest`), le sezioni (`ContestSection`), le opere (`ContestWork`), i premi (`ContestAward`) e le pagine del catalogo.

Nel branch `feat/0422-contest-catalog-page`:

- **Introduzione del Modello Lookup `ContestCatalogPagesLayoutSet`:** Normalizza a database l'elenco dei tipi di layout disponibili (`cover`, `empty_page`, `admit_work`, `winner_work`, `winner_name`, `book_page`), ciascuno vincolato al proprio percorso template Blade (`template_file_path`) e al titolo descrittivo.
- **Introduzione del Modello Sequenziale e Snapshot `ContestCatalogPage`:** Gestisce ogni singola pagina/slide del catalogo con chiave primaria ordinaria `id` (bigint), contatore progressivo `page` con indice univoco di sequenza (`['contest_id', 'page', 'id']`), chiavi esterne per la tracciabilità delle entità del concorso e campi snapshot immutabili (`author_name`, `title`, `subtitle`, `image_path`, `description`, `country_id`).
- **Integrazione bidirezionale completa tra i modelli del concorso:**
  - `Contest` $\rightarrow$ `hasMany(ContestCatalogPage::class)`
  - `ContestSection` $\rightarrow$ `hasMany(ContestCatalogPage::class)`
  - `ContestWork` $\rightarrow$ `hasMany(ContestCatalogPage::class)`
  - `ContestAward` $\rightarrow$ `hasOne(ContestCatalogPage::class)`
- **Risoluzione integrale dei bug relazionali preesistenti:**
  - Corretta la foreign key in `ContestAward::contestSection()` con `'section_id', 'id'`.
  - Implementata la relazione `ContestAward::userWork()` tramite `HasOneThrough` attraverso `ContestWork`.
  - Pulita e resa pienamente compatibile con l'eager loading la relazione `ContestWork::contestAwards()`, rimuovendo il filtro `where('section_id', ...)`.

---

### 2. Dettaglio dei Componenti e Scelte Implementative

#### 2.1. Il Modello di Lookup: `App\Models\ContestCatalogPagesLayoutSet`

La classe `App\Models\ContestCatalogPagesLayoutSet` rappresenta il catalogo dei layout disponibili per la composizione delle pagine:

- **Tabella:** `contest_catalog_pages_layout_sets`
- **Chiave Primaria Naturale:** `$primaryKey = 'layout_type'` (`char(16)`), stringa non autoincrementale (`$incrementing = false`).
- **Attributi gestiti:**
  - `layout_type`: identificativo mnemonico del layout (es. `cover`, `winner_work`, `admit_work`).
  - `template_file_path`: percorso relativo del template Blade associato per il rendering della slide.
  - `title_en`: definizione sintetica in lingua inglese del tipo di pagina.
  - Timestamps standard e trait `SoftDeletes`.
- **Seeder predefinito (`ContestCatalogPagesLayoutSetSeeder`):**
  Registra i tipi di layout canonici per la pubblicazione di un catalogo:
  - `empty_page` $\rightarrow$ `contests/_templates/empty_page.blade.php` ("Empty Page")
  - `cover` $\rightarrow$ `contests/_templates/cover.blade.php` ("Cover Page")
  - `admit_work` $\rightarrow$ `contests/_templates/admit_work.blade.php` ("Image Admit Page")
  - `winner_work` $\rightarrow$ `contests/_templates/winner_work.blade.php` ("Winner Image Page")
  - `winner_name` $\rightarrow$ `contests/_templates/winner_name.blade.php` ("Winner Name Page")
  - `book_page` $\rightarrow$ `contests/_templates/book_page.blade.php` ("Book Text Page")
- **Relazione inversa:**

  ```php
  public function contestCatalogPages(): HasMany
  {
      return $this->hasMany(ContestCatalogPage::class, 'layout_type', 'layout_type');
  }
  ```

---

#### 2.2. Il Modello Editoriale: `App\Models\ContestCatalogPage`

La classe `App\Models\ContestCatalogPage` incapsula la singola pagina/slide del catalogo di un concorso:

- **Tabella:** `contest_catalog_pages`
- **Chiave Primaria Ordinaria:** `$table->id()` (`bigint` unsigned autoincrement), scelta per facilitare la riordinazione sequenziale e il riposizionamento delle slide.
- **Campi di Contesto e Tracciabilità (Foreign Keys opzionali e indicizzate):**
  - `contest_id` (`char(36)`, non null): concorso proprietario del catalogo.
  - `contest_section_id` (`char(36)`, nullable): riferimento alla sezione tematica (opere di sezione, copertina sezione, statistiche di sezione).
  - `contest_work_id` (`char(36)`, nullable): riferimento all'opera presentata nel concorso (`contest_works.id`).
  - `contest_award_id` (`char(36)`, nullable): riferimento all'eventuale premio assegnato (`contest_awards.id`).
  - `layout_type` (`char(16)`): tipologia di layout con vincolo di foreign key su `contest_catalog_pages_layout_sets.layout_type` (`ON UPDATE RESTRICT ON DELETE RESTRICT`).
- **Controllo Sequenza:**
  - `page` (`unsignedInteger`, default 0): numero di pagina/slide all'interno del catalogo.
  - Indice univoco composite `sequence_idx`: `['contest_id', 'page', 'id']`, che garantisce l'univocità della numerazione all'interno del medesimo concorso.
- **Snapshot Pattern (Dati Congelati):**
  Per evitare rotture storiche o disallineamenti qualora un autore modifichi o elimini i propri dati a concorso concluso, la pagina memorizza direttamente uno snapshot:
  - `country_id` (`char(3)`, nullable): codice nazione dell'autore al momento dell'impaginazione (con FK su `countries.id`).
  - `author_name` (`string`, nullable): nome e cognome dell'autore pre-renderizzati.
  - `title` (`string`, nullable): titolo dell'opera o titolo speciale della pagina editoriale.
  - `subtitle` (`string`, nullable): sottotitolo o categoria premio.
  - `image_path` (`string`, nullable): percorso di immagini non legate direttamente a `contest_works` (es. ritratti dei giurati, loghi di federazioni, sponsor).
  - `description` (`text`, nullable): motivazione della giuria (*citation*) o testo descrittivo libero.
- **Indice di Ricerca e Generazione (`generate_idx`):**
  Indice composito su `['contest_id', 'contest_section_id', 'country_id', 'author_name', 'title']`, ottimizzato per ordinamenti alfabetici, raggruppamenti per nazione o sezione e operazioni batch di generazione.
- **Relazioni Eloquent definite:**

  ```php
  public function contest(): BelongsTo
  public function contestSection(): BelongsTo
  public function contestWork(): BelongsTo
  public function contestAward(): BelongsTo
  public function country(): BelongsTo
  public function layoutType(): BelongsTo
  ```

---

#### 2.3. Politiche di Sicurezza, Factory e Seeder

- **`App\Policies\ContestCatalogPagePolicy`:**
  Creata per gestire in modo granulare i permessi di visualizzazione, creazione, modifica, riordino ed eliminazione delle pagine di catalogo da parte degli organizzatori.
- **`Database\Factories\ContestCatalogPageFactory`:**
  Predisposta per la generazione di record di test con associazione casuale a concorso, sezione e premi esistenti.
- **`Database\Factories\ContestCatalogPagesLayoutSetFactory`** e relative migrazioni conformi allo standard PSR-12 e formattate con Laravel Pint.

---

#### 2.4. Matrice Completa delle Relazioni Verificate

Tutte le relazioni tra i 5 modelli chiave del dominio concorso sono state verificate e collaudate tramite Tinker:

| Modello | Metodo | Tipo Relazione | Modello Destinazione | Chiavi Esterna / Primaria | Stato |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **`Contest`** | `contestCatalogPages()` | `HasMany` | `ContestCatalogPage` | `contest_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestSection`** | `contestCatalogPages()` | `HasMany` | `ContestCatalogPage` | `contest_section_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestWork`** | `contestCatalogPages()` | `HasMany` | `ContestCatalogPage` | `contest_work_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestAward`** | `contestCatalogPage()` | `HasOne` | `ContestCatalogPage` | `contest_award_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestAward`** | `contestWork()` | `BelongsTo` | `ContestWork` | `winner_work_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestAward`** | `userWork()` | `HasOneThrough` | `UserWork` | via `ContestWork` | ✅ Collaudata |
| **`ContestAward`** | `contestSection()` | `BelongsTo` | `ContestSection` | `section_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestWork`** | `contestAwards()` | `HasMany` | `ContestAward` | `winner_work_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestCatalogPage`** | `contest()` | `BelongsTo` | `Contest` | `contest_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestCatalogPage`** | `contestSection()` | `BelongsTo` | `ContestSection` | `contest_section_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestCatalogPage`** | `contestWork()` | `BelongsTo` | `ContestWork` | `contest_work_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestCatalogPage`** | `contestAward()` | `BelongsTo` | `ContestAward` | `contest_award_id` $\rightarrow$ `id` | ✅ Collaudata |
| **`ContestCatalogPage`** | `layoutType()` | `BelongsTo` | `ContestCatalogPagesLayoutSet` | `layout_type` $\rightarrow$ `layout_type` | ✅ Collaudata |

---

### 3. Matrice Comparativa: `refactor/0140-big-rebuild` vs `feat/0422-contest-catalog-page`

| Aspetto | `refactor/0140-big-rebuild` | `feat/0422-contest-catalog-page` |
| :--- | :--- | :--- |
| **Persistenza Catalogo** | Nessuna. Nessun modello per pagine o slide. | Due modelli dedicati: `ContestCatalogPagesLayoutSet` e `ContestCatalogPage`. |
| **Sequenza Pagine** | Non prevista a livello di database. | Ordinamento progressivo su colonna `page` con indice univoco composite `sequence_idx`. |
| **Tipologie Layout** | Nessun catalogo tipologico standardizzato. | Tabella lookup `contest_catalog_pages_layout_sets` con 6 layout predefiniti e template path. |
| **Snapshot Pattern** | Assente. Rischio di rottura storica del catalogo in caso di cancellazione utenti/opere. | Presente: dati autore, nazione, titoli, citazioni e percorsi grafici congelati nel record pagina. |
| **Integrazione Dominio** | Modelli isolati rispetto all'impaginazione. | Relazioni `HasMany` / `HasOne` dirette su `Contest`, `ContestSection`, `ContestWork` e `ContestAward`. |
| **Integrità Relazionale** | `ContestAward::contestSection` e `userWork` errate; `ContestWork::award` con localKey errata e filtro restrittivo. | Tutte le relazioni corrette, testate in Tinker, allineate a PSR-12 e pronte all'eager loading. |

---

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `2026_11_06_163909_create_contest_catalog_pages_layout_sets_table.php`
  - Tabella `contest_catalog_pages_layout_sets` con PK `layout_type` (char 16), colonna `template_file_path`, colonna `title_en` e timestamps.
- [x] Creata migration `2026_11_07_162910_create_contest_catalog_pages_table.php`
  - Tabella `contest_catalog_pages` con PK autoincrementale `id`, FK `contest_id`, FK nullable `contest_section_id`, `contest_work_id`, `contest_award_id`, FK `layout_type` con vincolo restrict, FK `country_id`, colonna `page`, campi snapshot (`author_name`, `title`, `subtitle`, `image_path`, `description`), indici `generate_idx` e `sequence_idx`.
- [x] Creato seeder `ContestCatalogPagesLayoutSetSeeder` per popolare i 6 layout standard.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/docs/dev/feat/0422-contest-catalog-page.md` è aggiornato e allineato.
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte? *(Non ancora necessario: backend foundation)*
- [x] **Cleanup:** Ho rimosso eventuali `dd()`, `dump()` o metodi duplicati (`section()` su `ContestWork`).
- [x] **Code Style:** Formattazione con Laravel Pint superata con successo (`vendor/bin/pint --dirty --format agent`).
- [x] **Commit:** I messaggi dei commit sono chiari e conformi alle convenzioni di progetto.

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
1. Eseguire le migrazioni del database:

   ```bash
   php artisan migrate
   ```

2. Eseguire il seeder per popolare la tabella dei layout di catalogo:

   ```bash
   php artisan db:seed --class=ContestCatalogPagesLayoutSetSeeder
   ```
