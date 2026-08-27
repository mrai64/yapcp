# Feature: Federation More modify

> **Branch:** `feat/0233-federation-more-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-23.03  
> **Titolo e urgenza:** (A) feat: FederationMore / Modify blade  
> **Project/issue link:** [#233](https://github.com/mrai64/yapcp/issues/233)  
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 📝 Logica Tecnica

Realizzare concorsi fotografici sponsorizzati da diverse federazioni richiede
in alcuni punti la richiesta di informazioni "in più" rispetto al minimo
comune richiesto da tutti i concorsi, anche non patrocinati.  
Si è scelto di creare un archivio dei campi in più richiesti dalla Federazione e questo modulo si occupa di questi dati di definizione di moduli. Chiave univoca è
il field_name che non può essere variato.

...

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
Non sono state eseguite modifiche al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna migrazione da eseguire.
- Nessun parametro `.env` aggiuntivo richiesto.
