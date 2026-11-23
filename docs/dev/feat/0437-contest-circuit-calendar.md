---
title: 'Feature: Caricamento calendario circuito'
---

> **Branch:** `feat/0437-contest-circuit-calendar`  
> **Project/issue link:** [#437](https://github.com/mrai64/yapcp/issues/437)  
> **Stato:** In Corso / Revisione / Chiuso  
> **priorità:** A B C D E  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, senza id  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La definizione dei dati principali del circuito riguardano anche il calendario
delle date, che sono condivise tra tutti i concorsi. Viene però clonata la
blade del concorso per mantenere un software pulito anche se viola la regola
detta ReReRe.

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
