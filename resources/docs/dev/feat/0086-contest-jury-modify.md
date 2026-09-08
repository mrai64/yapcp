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

Gestione della modifica dei dati e della rinuncia di un giurato associato a una sezione di concorso (`ContestJury`).

### Operazioni Disponibili

1. **Modifica Giurato (`modifyContestJury`):**
   - Consente di aggiornare il titolo/qualifica (`qualify`) e lo stato di Presidente di Giuria (`is_president`).
   - Applica la validazione sui dati inseriti (`qualify` obbligatorio tra 2 e 255 caratteri, `is_president` booleano).

2. **Rinuncia Giurato (`resignContestJury`):**
   - Esegue la rimozione del giurato garantendo consistenza del database tramite transazione (`DB::transaction`).
   - Rimuove l'assegnazione attiva chiudendo la finestra di validità del ruolo in `UserRole` (impostando `role_opening` e `role_closing` all'orario attuale `now()`).
   - Applica la cancellazione logica (`softDelete`) sul record corrispondente in `ContestJury`.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- Nessuna modifica alle tabelle esistenti (sfrutta i campi e la cancellazione soft già presenti su `contest_juries` e `user_roles`).

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
