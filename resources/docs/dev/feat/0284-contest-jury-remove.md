# Feature: Cancellazione record ContestJury

> **Branch:** `feat/0284-contest-jury-remove`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-07.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestJury - remove  
> **Project/issue link:** [#284](https://github.com/mrai64/yapcp/issues/284)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Gestione della rimozione/cancellazione di un giurato (`ContestJury`) appartenente ad una sezione del concorso via componente Livewire Volt (`organization.design.contest-jury.remove`). 

All'invocazione del metodo `removeContestJury()`, la procedura esegue una transazione database (`DB::transaction`) che:
1. Recupera il ruolo dell'utente (`UserRole`) associato come giurato (`role => 'juror'`) per il concorso specifico (`contest_id`).
2. Aggiorna la data di chiusura del ruolo (`role_closing`) impostandola ad un secondo fa per terminare la validità del ruolo giurato.
3. Applica la **SoftDelete** sul record `ContestJury` (`$this->contestJury->delete()`).
4. Reindirizza alla rotta `organization.design.contest-jury.listed` notificando l'avvenuta rimozione.

Nel test Pest, l'azione di rimozione viene testata invocando esplicitamente `.call('removeContestJury')` per simulare l'azione utente e verificare che l'utente rimosso non sia più visibile nell'elenco della giuria.

## 🗄️ Modifiche al Database

Nessuna modifica di schema DB o migrazione richiesta (vengono utilizzate le tabelle e strutture `contest_juries` e `user_roles` già esistenti).

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`vendor/bin/pest tests/Feature/m004/i0284/ContestJuryRemoveTest.php`).
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte per la gestione giuria.
- [x] **Cleanup:** Rimosse tutte le istruzioni di debug (`dd()`, `dump()`, `ray()`).
- [x] **Commit:** I messaggi dei commit sono chiari e conformi.

## 🚀 Note per il Deploy

Nessuna operazione speciale richiesta in fase di deploy (nessuna migrazione DB da eseguire).
