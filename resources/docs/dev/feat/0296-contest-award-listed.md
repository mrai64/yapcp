# Feature: Elenco dei premi da assegnare a concorso

> **Branch:** `feat/0296-contest-award-listed`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-09-09.02  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestAward - listed  
> **Project/issue link:** [#296](https://github.com/mrai64/yapcp/issues/296)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Nel complesso delle operazioni per la progettazione del concorso,
definite le sezioni-temi si può passare alla definizione dei premi
di concorso e di sezione, questa pagina li elenca in ordine alfabetico
di codice premio, consentendo una presentazione ordinata per
priorità di premio. Come codici premio si possono usare lettere maiuscole,
per evitare che un premio debba essere "rinumerato" con l'inserimento
di un premio intermedio. Sono distinti i premi ufficiali dai premi secondari
quali per esempio: menzioni della giuria, e premio del giurato.

## 🗄️ Modifiche al Database

Nessuna, viene usato il modello ContestAward legato al model Contest.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare.
