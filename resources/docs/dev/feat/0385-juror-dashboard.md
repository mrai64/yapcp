# Feature: Nome Funzione

> **Branch:** `feat/0385-juror-dashboard`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-13.02  
> **Titolo e urgenza:** (A) feat: Jurors / Contest / Dashboard  
> **Project/issue link:** [#385](https://github.com/mrai64/yapcp/issues/385)  
> **Milestone link:** [M6](https://github.com/mrai64/yapcp/milestones/6)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La Juror dashboard è un pannello raggiungibile dalla parsonal dashboard
per i giurati di un concorso in cui sono riportati i conteggi delle opere
ancora da votare e quelli iscritti a concorso.

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
