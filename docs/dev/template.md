---
title: 'Feature: Nome Funzione'
---

# Feature: Nome Funzione

> **Branch:** `feat/0089-nome-funzione`  
> **Stato:** In Corso / Revisione / Chiuso  
> **priorità:** A B C D E  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, senza id  
> **Project/issue link:** [#89](https://github.com/mrai64/yapcp/issues/89)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Spiega qui il "perché" hai scelto una certa soluzione (es. "Uso un Job invece di un listener sincrono perché l'API esterna è lenta").

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

oppure

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `create_xxx_table`
- [ ] Lorem ipsum

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.

oppure

> <!-- to avoid index in Larecipe -->
- Eseguire `php artisan migrate`
- Lorem ipsum
