# Feature: Contest Design / Modifica dei dati di un giurato o sua Rinuncia

> **Branch:** `feat/0086-contest-jury-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2025-09-25.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestJury - modify  
> **Project/issue link:** [#86](https://github.com/mrai64/yapcp/issues/86)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Se per un qualsiasi motivo un giurato rinuncia, o è stato inserito un dato sbagliato serve la funzione
di modifica del record. La rinuncia, assimilabile alla cancellazione, esclude
ma mantiene attiva nella userRole la relazione spostando le date inizio e fine
al momento della rinuncia. Mentre il record di ContestJury viene cancellato,
ma con softdelete.
Alternativa, la modifica dei dati viene normalmente registrata, la qualifica e la presidenza di giuria.

## 🗄️ Modifiche al Database

Nessuna

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
Niente di particolare.
