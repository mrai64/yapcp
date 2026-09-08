# Feature: Aggiunta di giurati al concorso

> **Branch:** `feat/0285-contest-jury-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-07.02  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestJury - add  
> **Project/issue link:** [#285](https://github.com/mrai64/yapcp/issues/285)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'inserimento dei giurati avviene per specifica sezione/tema del concorso tramite un flusso guidato in 3 step:

1. **Step 1 (`add1.blade.php`):** Verifica dell'email. L'indirizzo email viene usato come chiave per verificare la presenza dell'utente su `UserContact`.
   - Se l'utente esiste già, il suo identificatore viene memorizzato in sessione (`contest_juror_id`) e si reindirizza direttamente allo Step 3.
   - Se non esiste, si viene reindirizzati allo Step 2.
2. **Step 2 (`add2.blade.php`):** Registrazione nuovo giurato. Vengono richiesti nome, cognome e nazione per creare la scheda anagrafica e l'account tramite l'azione `RegisterContestJuror`.
3. **Step 3 (`add3.blade.php`):** Assegnazione ruolo e qualifica. Vengono definiti i campi specifici del giurato per la sezione:
   - `contestJurorQualify`: qualifica/titolo del giurato (stringa obbligatoria da 2 a 255 caratteri).
   - `contestJurorIsPresident`: flag booleano per indicare il Presidente di Giuria.

**Atomicità dell'operazione:**  
La creazione del record in `ContestJury` e la contestuale assegnazione del ruolo `juror` nella tabella `UserRole` (con date di validità legate alla finestra temporale delle valutazioni del concorso) sono eseguite all'interno di una transazione di database (`DB::transaction`) per garantire consistenza e assenza di dati parziali.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- Nessuna modifica diretta alle tabelle in questo step (utilizza la struttura e le tabelle esistenti `contest_juries` e `user_roles`).

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
Nessuna operazione straordinaria richiesta per il deploy.