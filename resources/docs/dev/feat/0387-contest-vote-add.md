# Feature: Votazione del giurato

> **Branch:** `feat/0387-contest-vote-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-14.02  
> **Titolo e urgenza:** (A) feat: Jurors / Contest / Section ContestVote add  
> **Project/issue link:** [#387](https://github.com/mrai64/yapcp/issues/387)  
> **Milestone link:** [M6](https://github.com/mrai64/yapcp/milestones/6)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La modalità di voto da remoto per i giurati prevede l'assegnazione di una
votazione online su base numerica, o altra base purché sia un valore
scalabile ovvero ci sia un "minimo" e un "massimo". Il giurato 
visiona l'immagine singola e cliccando su un pulsante assegna il voto
passando immediatamente alla immagine successiva.
Non sono previsti pulsanti di alert perché il giurato possa segnalare
anomalie all'organizzazione.


## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
