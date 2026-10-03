# Feature: Aggiungere elenco concorsi nel cruscotto utente

> **Branch:** `feat/0363-user-dashboard`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-10-03.01  
> **Titolo e urgenza:** (A) User / User dashboard w/ contest applied  
> **Project/issue link:** [#363](https://github.com/mrai64/yapcp/issues/363)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Inserita nella dashboard cruscotto dell'utente
una tabella paginata con le indicazioni dei concrsi a cui risulta iscritto
quale ContestParticipant, e che sono ancora aperti

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
