# Feature: Backup yaml di UserWork e correlati

> **Branch:** `feat/0317-user-work-backup`  
> **Stato:** Chiuso  
> **Priorità:** A  
> **ID assegnato:** 2026-09-12.02  
> **Titolo e urgenza:** (A) feat: Admin / UserWork - Backup for single User  
> **Project/issue link:** [#317](https://github.com/mrai64/yapcp/issues/317)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'utente admin, attraverso il pannello di amministrazione (Admin Dashboard), può selezionare e avviare il Job asincrono `UserWorkAndRelatedSingleBackupJob` per eseguire l'esportazione/backup dei dati relativi ai modelli:

- **User**
- **UserContact**
- **UserWork**
- **UserWorkMore**

I contenuti generati nel file YAML servono per il successivo ripristino dell'archivio. Per ogni opera (`user_works`), oltre al `file_path`, viene generato un campo temporaneo `url_path` (la cui gestione dell'accesso protetto e la relativa modifica saranno oggetto di una successiva issue).  
L'esportazione include anche i record eliminati logicamente (`withTrashed()`) sia per l'estrazione globale (tutti gli utenti) sia per quella puntuale di un singolo utente selezionato.

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
