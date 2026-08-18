# Feature: Federation Delete Policy

> **Branch:** `feat/0114-federation-delete-policy`  
> **Stato:** Revisione
> **priorità:** A  
> **id assegnato:** 2026-03-23.01  
> **Titolo e urgenza:** (A) feat: Federation CRUD / delete, remove only under certain conditions  
> **Project/issue link:** [#114](https://github.com/mrai64/yapcp/issues/114)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Sistemata la questione di contare quanti concorsi attivi sono presenti per una federazione, si agevola la decisione di
consentire la cancellazione in via preventiva esponendo il link per la pagina di cancellazione solo quando i concorsi attivi sono zero. E se l'utente che visiona la lista delle federazioni è admin.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
Nessuna

## 👮‍♂️ Pre Merge check

- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [X] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [X] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
Niente da segnalare
