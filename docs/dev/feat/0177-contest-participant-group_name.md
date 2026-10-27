---
title: 'Feature: Nome Funzione'
---

# Feature: Nome Funzione

> **Branch:** `feat/0177-contest-participant-group_name`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** id:2026-08-10.05  
> **Titolo e urgenza:** (A) feat: User / ContestParticipant / add campo gruppo  
> **Project/issue link:** [#177](https://github.com/mrai64/yapcp/issues/177)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Al fine di permettere l'assegnazione del premio al "gruppo più numeroso" (es. Fotoclub, associazioni), è stato integrato il nuovo campo stringa nullable `group_name` sul model `ContestParticipant`.

### 1. Modellazione Dati (`ContestParticipant`)

- Il model `ContestParticipant` include `group_name` nei propri `$fillable` e ne esegue il cast a `string`.
- Il campo memorizza il gruppo o club fotografico a cui l'utente dichiara di appartenere per l'iscrizione allo specifico concorso.

### 2. Componente Volt / Livewire (`group-member.blade.php`)

Il componente consente all'utente di selezionare un gruppo già registrato oppure di inserirne uno nuovo:

- **Popolamento tendina `$groupNames` (Merge & Deduplicazione):**
  Per evitare disomogeneità e duplicati, la lista dei gruppi disponibili per la selezione viene generata fondendo due sorgenti tramite le Collection di Laravel nel metodo `mount()`:
  1. I `group_name` distinti e già registrati nella tabella `contest_participants` per il concorso corrente.
  2. I nomi (`name`) presenti nella tabella `organizations` (escluse l'organizzazione organizzatrice del concorso e quelle con sintassi reserved).
  
  *Flusso di fusione:*

  ```php
  $groupNames = ContestParticipant::whereContestId($this->contest->id)
      ->whereNotNull('group_name')
      ->where('group_name', '!=', '')
      ->distinct()
      ->pluck('group_name');

  $organizations = Organization::whereNot('organization_id', $this->contest->organization_id)
      ->where('name', '>', '.z')
      ->pluck('name');

  $this->groupNames = $groupNames->merge($organizations)
      ->unique()
      ->sort()
      ->values()
      ->toArray();
  ```

- **Validazione e Salvataggio (`addContestParticipantGroup`):**
  - Viene verificato che almeno uno tra il campo di selezione (`groupAlreadyPresent`) e il campo di testo libero (`memberOfGroup`) sia popolato.
  - Viene eseguito un `updateOrCreate` sul record di `ContestParticipant` legato a `contest_id` e `user_contact_id`, salvando il valore scelto o digitato nel campo `group_name`.

---

## 🗄️ Modifiche al Database

- [x] Creata migration `2026_10_26_220156_add_col_to_contest_participants_table`
- [x] Eseguita migration (aggiunta colonna `group_name` nullable alla tabella `contest_participants`)

## 👮‍♂️ Pre Merge check

- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

- Eseguire `php artisan migrate`
- Verificare la presenza della colonna `group_name` nella tabella `contest_participants`
