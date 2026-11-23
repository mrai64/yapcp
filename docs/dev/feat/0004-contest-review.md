---
title: 'Feature: Modifica inserimento Circuit Id'
---

> **Branch:** `feat/0004-contest-review`  
> **Stato:** In Corso  
> **priorità:** B  
> **id assegnato:** 2025-09-28.03  
> **Titolo e urgenza:** (B) feat: Organization / Contest Design / Contest - Change circuit_id input  
> **Project/issue link:** [#4](https://github.com/mrai64/yapcp/issues/4)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)
> **autori:** mrai64 e Antigravity

- [📝 Logica Tecnica](#-logica-tecnica)
  - [Contesto e Problematiche Risolte](#contesto-e-problematiche-risolte)
  - [1. Modifiche al Modello `Contest` (`app/Models/Contest.php`)](#1-modifiche-al-modello-contest-appmodelscontestphp)
  - [2. Componente Livewire / Volt (`modify-name.blade.php`)](#2-componente-livewire--volt-modify-namebladephp)
  - [3. Localizzazione e Migration](#3-localizzazione-e-migration)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Contesto e Problematiche Risolte

L'assegnazione di un concorso a un circuito (`circuit_id`) avveniva precedentemente tramite un input testuale libero in cui l'utente doveva inserire manualmente un UUID. Tale procedura esponeva l'applicazione a errori di digitazione, riferimenti non validi e inserimenti arbitrari.

Inoltre, persisteva un'ambiguità concettuale e di validazione tra i campi `is_circuit` e `circuit_id`:

- Un record marcato come **Circuito** (`is_circuit = true`) è il concorso aggregatore/radice: non appartiene a un altro circuito e pertanto deve sempre avere `circuit_id = null`.
- Un record marcato come **Concorso ordinario** (`is_circuit = false`) può invece essere collegato a un circuito esistente valorizzando opzionalmente `circuit_id`.
- La precedente regola di validazione `'required_if:contestIsCircuit,true'` imponeva erroneamente l'inserimento di un `circuit_id` quando il concorso era un circuito.

La soluzione implementata risolve queste problematiche sostituendo il campo di testo libero con un menu a discesa (`<select>`) popolato unicamente dai concorsi registrati come circuito, riallineando la logica del Model e garantendo la consistenza dei dati in fase di salvataggio.

---

### 1. Modifiche al Modello `Contest` (`app/Models/Contest.php`)

Nel model `App\Models\Contest` sono stati applicati i seguenti interventi:

1. **Rinominato metodo statico `getCircuits()` e ordinamento:**
   - Il metodo statico `getCircuitSet()` è stato rinominato in `getCircuits()`.
   - L'ordinamento dei record è passato da alfabetico su `name_en` (`orderBy('name_en')`) a cronologico decrescente di modifica (`orderByDesc('updated_at')`), così da mostrare per primi i circuiti creati o modificati più di recente:

   ```php
   public static function getCircuits()
   {
       $circuitSet = self::select('id', 'name_en')
           ->where('is_circuit', true)
           ->orderByDesc('updated_at')
           ->get();

       return $circuitSet;
   }
   ```

2. **Correzione semantica di `contestIsInCircuit()`:**
   - Il metodo controllava erroneamente `$this->is_circuit`.
   - È stato corretto verificando l'effettiva valorizzazione della foreign key `circuit_id`:

   ```php
   public function contestIsInCircuit(): bool
   {
       return ($this->circuit_id !== null);
   }
   ```

3. **Pulizia e consolidamento relazioni Eloquent:**
   - Rimossi i metodi ridondanti o duplicati `getContests(): HasMany` e `contestInCircuit(): HasMany`.
   - Consolidata e documentata la relazione ufficiale `contestsInCircuit(): HasMany` per recuperare i concorsi associati a un circuito, mantenendo `circuit(): BelongsTo` per la risalita dal singolo concorso al circuito genitore.

4. **Rimozione residui `federation_list`:**
   - Rimosso il campo `federation_list` dalla proprietà `$fillable` e dal metodo `casts()` (gestione legacy superata dall'entità dedicata `ContestPatronage`).

5. **PHPDoc:**
   - Aggiornata la documentazione della proprietà `@property bool $is_circuit` specificando `false: is contest`.

---

### 2. Componente Livewire / Volt (`modify-name.blade.php`)

File: `resources/views/livewire/organization/design/contest/modify-name.blade.php`

Nel componente single-file Volt dedicato alla modifica del concorso:

1. **Stato del Componente:**
   - Aggiunta la proprietà pubblica `$contestCircuitsSet`.
   - Nel metodo `mount(Contest $contest)`:
     - Cast booleano esplicito di `$contestIsCircuit` (`(bool) ($contest->is_circuit ?? false)`).
     - Gestione coerente di `$contestCircuitId`: se il concorso è un circuito, viene impostato a stringa vuota `''`, altrimenti riceve `$contest->circuit_id`.
     - Caricamento dell'elenco dei circuiti: `$this->contestCircuitsSet = Contest::getCircuits();`.

2. **Regole di Validazione (`rules()`):**
   - Rimossa la regola errata `required_if:contestIsCircuit,true`.
   - Il campo `contestCircuitId` è configurato come opzionale ma verificato:

   ```php
   'contestCircuitId' => [
       'nullable',
       'exists:contests,id',
   ],
   ```

3. **Logica di Salvataggio (`modifyContest()`):**
   - Garantita la coerenza dei dati: se il record è marcato come circuito (`contestIsCircuit == true`), `circuit_id` viene forzato a `null`:

   ```php
   $this->contest->circuit_id = $validated['contestIsCircuit'] ? null : ($validated['contestCircuitId'] ?: null);
   ```

4. **Template Blade e Reattività:**
   - Il checkbox di `contestIsCircuit` adotta `wire:model.live="contestIsCircuit"` per aggiornare in tempo reale la visibilità della selezione circuito.
   - Sostituito l'input `x-text-input` con un elemento `<select wire:model="contestCircuitId">` condizionato da `@if (! $contestIsCircuit ) && (! $contestCircuitsSet->isEmpty())`.
   - Aggiunta opzione vuota iniziale `...` e popolamento dinamico delle option con `$circuit->id` e `$circuit->name_en`.
   - Aggiornata l'etichetta del campo a `__('Circuit')` (precedentemente `__('Circuit ID')`) e rimossa la nota provvisoria `TODO: change in a select form field`.

---

### 3. Localizzazione e Migration

- **Traduzioni (`resources/lang/en.json`, `resources/lang/it.json`):**
  - Sostituita la voce `"Circuit ID"` con `"Circuit"`.
  - Rimossa la stringa deprecata `"TODO: change in a select form field"`.
- **Migration (`database/migrations/2026_02_03_000005_create_contests_table.php`):**
  - Aggiornati i commenti sulle colonne `is_circuit` (`false: is contest`) e `circuit_id` (`null, or self fk: contests.id`) per chiarire la semantica dello schema.

---

## 🗄️ Modifiche al Database

Nessuna nuova migrazione strutturale necessaria.

> <!-- to avoid index in Larecipe -->
- Aggiornati unicamente i commenti descrittivi per le colonne `is_circuit` e `circuit_id` nella migrazione base `2026_02_03_000005_create_contests_table.php`. Non si è ritenuta necessaria una migration dedicata alla modifica di commenti.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
