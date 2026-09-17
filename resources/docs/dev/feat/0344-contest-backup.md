# Feature: Backup yaml di Cntest e correlati

> **Branch:** `feat/0344-contest-backup`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-17.01  
> **Titolo e urgenza:** (A) feat: Admin DashBoard / Backup modelli Contest, Contest*  
> **Project/issue link:** [#344](https://github.com/mrai64/yapcp/issues/344)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'utente admin attraverso il pannello di amministrazione (Admin Dashboard) può selezionare e avviare un processo di esportazione/backup dei dati relativi ai modelli:

- **Contest**
- **ContestPatronage**
- **ContestSection**
- **ContestJury**
- **ContestAward**

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
