# Feature: Lista Concorrenti Partecipanti per modifica status pagamento

> **Branch:** `feat/0376-contest-participant`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, senza id  
> **Project/issue link:** [#376](https://github.com/mrai64/yapcp/issues/376)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Viene esposto, paginato, l'elenco dei record del concorso dal model ContestPartcipant
il cui dato associato è `fee_payment_completed`, booleano. I concorrenti sono
elencati per nazione, cognome, nome, ed infine, in caso di omonimia, per data di aggiornamento.

A ogni partecipante è associato un pulsante che riporta lo stato iniziale:

- ✅ COMPLETED
- ⏲️ Waiting

Cliccando sul pulsate lo stato viene cambiato immediatamente ed aggiornata la vista.

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
