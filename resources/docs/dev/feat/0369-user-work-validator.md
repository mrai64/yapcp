# Feature: Verifica immagine con scrittura d ContestWaiting O di UserWorkValidator

> **Branch:** `feat/0369-user-work-validator`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, senza id  
> **Project/issue link:** [#369](https://github.com/mrai64/yapcp/issues/369)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Il pannello consente la verifica di un'opera a ricerca di motivi non verificabili automaticamente
per confermare alla partecipazione oppure mettere da parte la stessa
con motivazione scritta da parte dell'organizzazione.
A scelta si torna all'elenco delle opere rimaste da verificare fino 
ad esaurimento. Si può operare in più persone, coordinandosi.
L'azione comporta la scrittura di un record nel model ContestWaiting
per le opere in sospeso, oppure nel model UserWorkValidation
per le opere confermate.

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
