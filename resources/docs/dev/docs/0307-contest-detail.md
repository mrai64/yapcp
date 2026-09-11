# Scheda Tecnica: Dettaglio Concorso

> **Branch:** `docs/0307-contest-detail`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-11.01  
> **Titolo e urgenza:** Visione dettagli del concorso  
> **Project/issue link:** [#307](https://github.com/mrai64/yapcp/issues/307)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

## 1. Panoramica del Flusso di Lavoro (Workflow)

Un utente associato a un'**Organization** gestisce l'intero ciclo di vita del concorso fotografico attraverso le seguenti fasi sequenziali:

1. **Creazione Contest (`Contest`):** Definizione delle informazioni generali, delle date di calendario (apertura, chiusura, giuria, premiazione, ecc.), dell'organizzazione referente, del fuso orario e dei dettagli di contatto/regolamento.
2. **Assegnazione Patrocini (`ContestPatronage`):** Associazione delle federazioni patrocinanti con i relativi codici di patrocinio/riconoscimento.
3. **Definizione Temi e Sezioni (`ContestSection`):** Configurazione delle sezioni del concorso con requisiti tecnici specifici (formati, dimensioni max/min in pixel e peso file, tema libero/obbligatorio, monocromatico, richiesta file RAW, ecc.).
4. **Composizione delle Giurie (`ContestJury`):** Assegnazione dei giurati (utenti registrati) a ciascuna sezione specifica, definendo l'eventuale ruolo di Presidente di Giuria e la qualifica.
5. **Definizione dei Premi (`ContestAward`):** Assegnazione dei premi sia a livello globale di concorso (es. Gran Premio / Miglior Autore) sia a livello di singola sezione (es. 1°, 2°, 3° premio, Menzioni d'Onore).
6. **Visualizzazione Dettagli (Blade Detail View):** Renderizzazione completa dei dati aggregati tramite componenti Volt/Livewire e Blade.

---

## 2. Modelli Eloquent e Relazioni Coinvolte

### 2.1 `App\Models\Contest`

- **Ruolo:** Entità principale contenente la testata del concorso o del circuito.
- **Relazioni chiave:**
  - `organization()`: `BelongsTo` -> `Organization`
  - `contestPatronage()`: `HasMany` -> `ContestPatronage`
  - `sections()` / `contestSections()`: `HasMany` -> `ContestSection`
  - `awards()` / `globalAwards()`: `HasMany` -> `ContestAward`
  - `userRoles()`: `HasMany` -> `UserRole`

### 2.2 `App\Models\ContestPatronage`

- **Ruolo:** Tabella pivot/estesa per le federazioni che concedono il patrocinio.
- **Relazioni chiave:**
  - `contest()`: `BelongsTo` -> `Contest`
  - `federation()`: `BelongsTo` -> `Federation`

### 2.3 `App\Models\ContestSection`

- **Ruolo:** Rappresenta i temi/sezioni di concorso.
- **Relazioni chiave:**
  - `contest()`: `BelongsTo` -> `Contest`
  - `contestJuries()`: `HasMany` -> `ContestJury`
  - `awards()`: `HasMany` -> `ContestAward`

### 2.4 `App\Models\ContestJury`

- **Ruolo:** Definisce la giuria associata ad ogni singola sezione.
- **Relazioni chiave:**
  - `contest()`: `BelongsTo` -> `Contest`
  - `contestSection()`: `BelongsTo` -> `ContestSection`
  - `userContact()`: `BelongsTo` -> `UserContact` (Giurato)

### 2.5 `App\Models\ContestAward`

- **Ruolo:** Lista dei premi assegnabili (se `section_id` è `null` riguarda l'intero concorso, altrimenti la specifica sezione).
- **Relazioni chiave:**
  - `contest()`: `BelongsTo` -> `Contest`
  - `contestSection()`: `BelongsTo` -> `ContestSection`

---

## 3. Struttura del Componente Blade / Volt per la Vista Dettaglio (`detail.blade.php`)

La vista dettagli raccoglie tutte le informazioni strutturate del concorso e le suddivide in macro-sezioni visive:

- informazioni generali
- eventuale elenco patrocini delle federazioni
- calendario fasi concorso
- elenco temi e sezioni
  - con relativa giuria
- elenco dei Premi
- informazioni per la partecipazione (quanto costa ecc)

---

## 🗄️ Modifiche al Database

Nessuna modifica

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

---

## 🚀 Note per il Deploy

Niente di particolare
