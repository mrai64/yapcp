# Feature: Elenco dei Giurati

> **Branch:** `feat/0286-contest-jury-listed`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-07.03  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestJury - listed  
> **Project/issue link:** [#286](https://github.com/mrai64/yapcp/issues/286)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'elenco dei giurati viene esposto nell'interfaccia di configurazione del concorso da parte dell'organizzazione (`organization.design.contest-jury.listed`).

Per caricare in modo efficiente le relazioni annidate ed evitare il problema delle query N+1, il componente Livewire Volt utilizza l'Eager Loading di Eloquent sui livelli correlati:
`Contest::with(['contestSections.contestJuries.userContact'])`

In questa fase, ogni sezione/tema gestisce la propria lista separata di giurati (`ContestJury`). Nei concorsi più piccoli, i medesimi giurati vengono associati manualmente a tutte le sezioni. Viene rinviata a uno sviluppo successivo la logica per ereditare o nascondere la giuria se identica tra sezioni consecutive.

Inoltre, la vista espone per ciascun giurato lo stato (`is_president`), il paese di provenienza con bandiera (`userContact->country`), il nominativo, l'eventuale qualifica associata (`qualify`) e le opzioni di modifica/rimozione.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- Nessuna modifica diretta al database in questa issue (la struttura delle giurie è definita nella tabella `contest_juries`).

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
Nessuna operazione di migrazione o configurazione speciale richiesta per questo deploy.
