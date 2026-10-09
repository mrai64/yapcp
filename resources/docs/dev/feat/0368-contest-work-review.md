# Feature: Contest Work review before Jury start

> **Branch:** `feat/0368-contest-work-review`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-09.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Manage Before Jury / ContestWork - Revisione operA singola prima della giuria  
> **Project/issue link:** [#368](https://github.com/mrai64/yapcp/issues/368)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L’operazione introdotta da questa feature consente all’organizzazione di esaminare, prima dell’apertura della giuria, le opere presentate a un concorso per rilevare problemi che non possono essere validati automaticamente dal sistema. Selezionata l'opera dall'elenco dei sospesi, si procede alla revisione della singola opera.

---

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

---

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
