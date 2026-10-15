# Feature: Nome Funzione

> **Branch:** `feat/0386-organization-dashboard`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-10-14.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Manage w/Jury / dashboard  
> **Project/issue link:** [#386](https://github.com/mrai64/yapcp/issues/386)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

per il concorso, durante la finestra di attività delle giurie, l'organizzazione visiona 
i contatori opere votate / opere totali di ogni sezione e ogni giurato.
Sono presenti anche link per la valutazione in ogni sezione del concorso
della % di voti.

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
