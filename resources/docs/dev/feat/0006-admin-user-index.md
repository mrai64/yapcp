# Feature: Admin User index

> **Branch:** `feat/0006-admin-user-index`  
> **Stato:** In Corso  
> **priorità:** B  
> **id assegnato:** 2025-09-28.05  
> **Titolo e urgenza:** (B) Admin / User / Index Listed paginated  
> **Project/issue link:** [#6](https://github.com/mrai64/yapcp/issues/6)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

All'interno della Admin dashboard un link consente di visualizzare l'intero
indice degli utenti registrati, ordinato per nazione, cognome, nome e
data di registrazione (per omonimi).
In seguito per ogni user saranno disponibili link per passare alle pagine
di modifica e correzione User, e UserContact, e UserRole per sistemare
problemi uso terzi.

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
