---
title: 'Feature: ContestWaiting Verifica pre-risoluzione (Section is Full Check)'
---

# Feature: ContestWaiting Verifica pre-risoluzione (Section is Full Check)

> **Branch:** `feat/0433-contest-waiting-review`  
> **Stato:** In Corso / Revisione  
> **priorità:** A  
> **id assegnato:** 2026-11-15.01  
> **Titolo e urgenza:** (A) feat: Organization / contest Manage / ContestWaiting - check pre-resolve  
> **Project/issue link:** [#433](https://github.com/mrai64/yapcp/issues/433)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
  - [Contesto e Problematiche Risolte](#contesto-e-problematiche-risolte)
  - [1. Metodo Checker nel Modello `ContestWork` (`sectionIsFull`)](#1-metodo-checker-nel-modello-contestwork-sectionisfull)
  - [2. Filtro Elenco Opere Sospese (`resolve.blade.php`)](#2-filtro-elenco-opere-sospese-resolvebladephp)
  - [3. Risoluzione Condizionale (`resolved-because.blade.php`)](#3-risoluzione-condizionale-resolved-becausebladephp)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Contesto e Problematiche Risolte

A seguito dell'introduzione della gestione di audit su `ContestWaiting` (issue [#59](https://github.com/mrai64/yapcp/issues/59) / PR #432), è emerso un caso limite fondamentale:

- Quando un'opera viene sospesa/parcheggiata in `ContestWaiting`, l'autore potrebbe caricare un'opera sostitutiva per completare la sua partecipazione.
- Se l'autore ha già raggiunto il numero massimo di opere ammesse per la sezione (`contest_sections.max_works`), la risoluzione e successiva cancellazione (soft-delete) del record in `ContestWaiting` riammetterebbe l'opera originaria in concorso, provocando uno **sforamento non consentito del tetto massimo di opere**.

Per gestire questa casistica senza perdere la tracciabilità e senza superare i limiti di regolamento:

1. Viene effettuato un controllo preventivo della capienza della sezione per l'autore.
2. Se la sezione dell'autore è già piena (`sectionIsFull == true`), l'opera **non viene cancellata da `ContestWaiting`**, rimanendo congelata/esclusa dal concorso con una motivazione automatica e tracciando l'organizzatore che ha chiuso la verifica.
3. Se la sezione non è satura (`sectionIsFull == false`), si procede con il flusso standard di risoluzione e soft-delete.
4. L'elenco delle opere in attesa esclude automaticamente i record già verificati (`whereNull('resolved_by_user_id')`).

---

### 1. Metodo Checker nel Modello `ContestWork` (`sectionIsFull`)

File: `app/Models/ContestWork.php`

È stato implementato il metodo statico di verifica della saturazione opere per sezione e utente:

```php
/**
 * The user has reached contest_sections.max_works?
 */
public static function sectionIsFull(string $sectionId, string $userId): bool
{
    Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

    $section = ContestSection::find($sectionId);

    if (!$section) {
        return false;
    }

    $currentCount = self::sectionWorksCounter($sectionId, $userId);
    Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' current: ' . $currentCount . ' vs. max: ' . $section->max_works);
    
    return $currentCount >= $section->max_works;
}
```

- Recupera i parametri della sezione (`ContestSection::find($sectionId)`), in particolare il limite `max_works`.
- Calcola le opere attualmente a concorso tramite `sectionWorksCounter($sectionId, $userId)`.
- Ritorna `true` se il concorrente ha già raggiunto o superato il limite massimo di opere consentite per quella sezione.

---

### 2. Filtro Elenco Opere Sospese (`resolve.blade.php`)

File: `resources/views/livewire/organization/contest-waiting/resolve.blade.php`

- **Filtro Query:** aggiunta la condizione `whereNull('resolved_by_user_id')`:

  ```php
  'contestWaitingSet' => ContestWaiting::query()
      ->with(['userWork'])
      ->where('contest_id', $this->contest->id)
      ->whereNull('resolved_by_user_id')
      ->orderBy('section_id')
      ->paginate(6),
  ```

  In questo modo, sia le opere riammesse (soft-deleted) sia quelle congelate (rimaste in tabella ma con `resolved_by_user_id` popolato) vengono escluse dall'elenco delle opere ancora da gestire.
- **Visualizzazione Tabella:** predisposto il blocco `@forelse` con riga di fallback in caso di elenco vuoto:

  ```blade
  @empty
      <tr class="border my-2">
          <td valign="top" class="pe-4">0.</td>
          <td valign="top" colspan="2">
              {{ __("No one, Not more") }}
          </td>
      </tr>
  @endforelse
  ```

---

### 3. Risoluzione Condizionale (`resolved-because.blade.php`)

File: `resources/views/livewire/organization/contest-waiting/resolved-because.blade.php`

- **Inizializzazione dello Stato (`mount`):**
  - Viene calcolata la proprietà booleana `$sectionIsFull`:

    ```php
    $this->sectionIsFull = ContestWork::sectionIsFull(
        $this->contestWaiting->section_id,
        $this->contestWaiting->participant_user_id
    );
    ```

- **Interfaccia Utente Reattiva:**
  - **Se `$sectionIsFull === true`:**
    Viene mostrata un'etichetta `Remain locked` e una textarea in sola lettura (`readonly`) contenente il testo esplicativo predefinito:
    `"This image remains frozen, because the contestant has already used up all the available slots to take part."`
  - **Se `$sectionIsFull === false`:**
    Viene visualizzata la consueta textarea modificabile per inserire le motivazioni dello sblocco in concorso.
- **Logica di Chiusura (`solvedContestWaiting`):**
  - Viene sempre aggiornato il record con l'audit di risoluzione:

    ```php
    $this->contestWaiting->update([
        'resolved_by_user_id' => Auth::id(),
        'resolved_because'    => $validated['resolvedBecause'],
    ]);
    ```

  - **Eliminazione condizionale:** la cancellazione soft-delete `$this->contestWaiting->delete()` viene eseguita **solo se `! $this->sectionIsFull`**. Se la sezione è piena, il record rimane non eliminato, impedendo all'opera di tornare in gara.
  - Redirect con notifica generica di aggiornamento: `session()->flash('success', __("Updated"))`.

---

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database.  
La struttura esistente della tabella `contest_waitings` (aggiornata con la migration della issue #59) contiene già tutte le colonne necessarie (`resolved_by_user_id`, `resolved_because`, `deleted_at`).

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Verificare che tutti i test passino regolarmente (`php artisan test`).
- [x] **Docs:** Scheda tecnica `docs/dev/feat/0433-contest-waiting-review.md` creata e aggiornata con il flusso completo.
- [ ] **Blade Syntax Fix:** Verificare la sintassi del ciclo `@forelse` in `resources/views/livewire/organization/contest-waiting/resolve.blade.php` per assicurarsi che non rimangano costrutti `@foreach` orfani.
- [ ] **Manual:** Verificare manualmente i due scenari:
  1. Concorrente con slot disponibili: l'opera viene sbloccata, annotata, cancellata (soft-delete) e riammessa in concorso.
  2. Concorrente con slot esauriti (`sectionIsFull == true`): l'opera mostra l'avviso di blocco permanente, salva chi ha processato la scheda ma non cancella il record in `ContestWaiting`, evitando il rientro in concorso.
- [x] **Cleanup:** Assenza di `dd()` o `dump()` nel codice.

---

## 🚀 Note per il Deploy

Nessuna migrazione o azione speciale richiesta al deploy.
