---
title: 'Feature: Add column Citation to ContestAward model'
---

# Feature: Add column Citation to ContestAward model

> **Branch:** `feat/0402-contest-award-citation`  
> **Stato:** In Corso  
> **priorità:** B  
> **id assegnato:** 2026-10-23.02  
> **Titolo e urgenza:** (B) ContestAward : aggiungere colonna Citation  
> **Project/issue link:** [#402](https://github.com/mrai64/yapcp/issues/402)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Nella stesura del verbale di giuria o durante la cerimonia di premiazione può rendersi necessario esprimere una "motivazione" (*citation*) per il premio assegnato dalla giuria a una specifica opera o partecipante. Questa informazione è stata integrata a livello di modello, interfaccia di gestione e navigazione.

### 1. Modellazione Dati (`ContestAward`)

- **Colonna Database:** È stato introdotto il campo `citation` come colonna `text` nullable sulla tabella `contest_awards` (posizionato dopo `winner_name`), corredato dal commento esplicativo `'jury speech for minute or award show'`.
- **Aggiornamento del Model (`app/Models/ContestAward.php`):**
  - Aggiunta della proprietà `@property string|null $citation` e del metodo builder `@method static ... whereCitation($value)` nei PHPDoc.
  - Inserimento di `citation` tra gli attributi mass-assignable (`$fillable`).
  - Definizione del cast esplicito `'citation' => 'string'` all'interno del metodo `casts()`.

### 2. Rotte e Navigazione

- **Definizione Route (`routes/web.php`):**
  - Registrata la route Volt protetta dai middleware `['auth', 'verified']`:

    ```php
    Volt::route('/organization/contest-award/citation/{contestAward}', 'organization.contest-award.citation')
        ->middleware(['auth', 'verified'])
        ->name('organization.contest-award.citation');
    ```

- **Punto di Accesso UI (`listed.blade.php`):**
  - Nella vista di riepilogo dei premi del concorso (`resources/views/livewire/organization/contest-award/listed.blade.php`), è stata aggiunta una colonna nella tabella con il link di navigazione dedicato:

    ```blade
    <x-yapcp.header-link
        txt="Citation"
        url="{{ route('organization.contest-award.citation', ['contestAward' => $contestAward]) }}" />
    ```

### 3. Componente Livewire Volt (`citation.blade.php`)

La gestione, visualizzazione e modifica della motivazione avviene tramite il componente Livewire Volt single-file (`resources/views/livewire/organization/contest-award/citation.blade.php`):

- **Stato e Inizializzazione (`mount`):**
  - Il componente riceve l'istanza `ContestAward` tramite Route Model Binding.
  - Nel metodo `mount()`, vengono inizializzati il riferimento al concorso (`$this->contest = $this->contestAward->contest`) e la proprietà associata al campo di testo `$this->contestAwardCitation = $this->contestAward->citation ?? ''`.
- **Regole di Validazione (`rules`):**
  - La proprietà `contestAwardCitation` è validata con le regole `'nullable|string|max:2000'`, consentendo testi descrittivi fino a 2000 caratteri.
- **Logica di Salvataggio e Normalizzazione (`modifyContestAwardCitation`):**
  - Esegue la validazione dei dati con `$this->validate()`.
  - Normalizza le stringhe vuote impostandole a `null` (`empty($citation) || $citation == ''`), permettendo all'utente di azzerare/eliminare la motivazione semplicemente svuotando la textarea.
  - Aggiorna il record persistendo il valore: `$this->contestAward->update(['citation' => $citation])`.
  - Invia un messaggio di feedback all'utente tramite flash session: `session()->flash('success', __("Citation updated"))`.
- **Interfaccia Utente (Blade View):**
  - **Header:** Mostra il titolo del concorso (`$contest->name_en`), il codice e il nome del premio (`Jury Citation for award: :code | :name`), e un link per tornare all'elenco dei premi (`organization.contest-award.listed`).
  - **Feedback & Errori:** Mostra il banner di successo per le operazioni andate a buon fine e un blocco di riepilogo per gli eventuali errori (`$errors->any()`).
  - **Form:**
    - Textarea ridimensionabile verticalmente (`textarea {resize:vertical;}`) collegata in two-way binding con `wire:model="contestAwardCitation"`.
    - Etichetta `Jury reasoning, english` e testo informativo che segnala la facoltatività del campo e la possibilità di svuotarlo per rimuovere il valore ("Input area can be resized. Facultative. Empty for delete.").
    - Componente `<x-input-error for="contestAwardCitation" />` per evidenziare errori di validazione specifici sul campo.
    - Pulsante di submit `<x-button>` per confermare il salvataggio ("Confirm Citation").

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `2026_10_28_175354_add_col_to_contest_awards_table`
- [x] Eseguita migration (aggiunta colonna `citation` nullable alla tabella `contest_awards`)

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Eseguire `php artisan migrate`
- Verificare la presenza della colonna `citation` nella tabella `contest_awards`
