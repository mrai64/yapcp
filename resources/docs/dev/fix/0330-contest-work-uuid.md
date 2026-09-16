# Fix - Generate uuid only when uuid is missing

> **Branch:** `fix/0330-contest-work-uuid`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-16.07  
> **Titolo e urgenza:** (A) fix: ContestWork / uuid booted  
> **Project/issue link:** [#330](https://github.com/mrai64/yapcp/issues/330)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Corretto l'evento creating all'interno del metodo statico `booted()` del model UserWork.

In precedenza, l'UUID veniva generato incondizionatamente a ogni creazione `($model->id = Str::uuid7();)`, sovrascrivendo un eventuale UUID già esplicitamente assegnato in fase di istanziazione (es. durante importazioni, operazioni di backup/ripristino o flussi di upload che generano l'UUID prima della persistenza).

È stato sostituito con la funzione standard newUniqueId(), che viene richiamata solo quando l'id è mancante `if (empty($model->id))` per garantire che un nuovo UUID v7 venga generato e assegnato, allineando il comportamento del model ContestWork a quello già presente in User.

## 🗄️ Modifiche al Database

Nessuna.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [X] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** N/A (Modifica interna/tecnica, nessuna variazione sull'interfaccia o sulle funzionalità utente)
- [X] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [X] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare.
