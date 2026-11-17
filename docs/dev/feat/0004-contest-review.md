---
title: 'Feature: Modifica inserimento Circuit Id'
---

> **Branch:** `feat/0004-contest-review`  
> **Stato:** In Corso  
> **priorità:** B  
> **id assegnato:** 2025-09-28.03  
> **Titolo e urgenza:** (B) feat: Organization / Contest Design / Contest - Change circuit_id input  
> **Project/issue link:** [#4](https://github.com/mrai64/yapcp/issues/4)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Si tratta di sostituire un campo di testo in cui inserire un uuid, un gesto
che può portare a inserimenti arbitrari, con un campo a selezione di opzioni
basato sul set di record del model Contest in cui è impostato il valore is_circuit.

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
