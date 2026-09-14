# Feature: Nome Funzione

> **Branch:** `feat/0318-user-backup`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-13.01  
> **Titolo e urgenza:** (A) feat: Admin DashBoard / Backup modelli User, UserContact, UserContactMore  
> **Project/issue link:** [#318](https://github.com/mrai64/yapcp/issues/318)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'utente admin attraverso il suo pannello cruscotto o admin dashboard, può selezionare ed avviare una attività di esportazione dati sui modelli User, userContact e UserContactMore. Il file creato, in formato YAML, contenente tutti i campi dei modelli, può essere riutilizzato per il ripristino dei dati e non viene inviato o condiviso con terzi ma resta all'interno della piattaforma nella sezione private dello storage. Chi ha effettuato la richiesta viene registrato nei log di sistema e anche all'interno del file esportato.

## 🗄️ Modifiche al Database

Nessuna.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare.
