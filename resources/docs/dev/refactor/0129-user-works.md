# Feature: Nome Funzione

> **Branch:** `refactor/0129-user-works`  
> **Stato:** In Corso
> **priorità:** B  
> **id assegnato:** 2026-05-09.01  
> **Titolo e urgenza:** (B) refactor: remove user_works->reference_year because is now in user_work_mores  
> **Project/issue link:** [#129](https://github.com/mrai64/yapcp/issues/129)
> **milestone link:** [M2](https://github.com/mrai64/yapcp/milestones/2)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Poiché la tabella `user_works` è attualmente vuota negli ambienti di destinazione e il progetto è in fase di refactoring architetturale verso Livewire Volt SFC, si è optato per la modifica diretta della migration originale `create_user_works_table` anziché aggiungere una migration di update. Questo mantiene lo storico delle migrazioni snello e coerente.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Riscritta migration `create_user_works_table`
  - [x] Aggiunto il campo `file_size` a `user_works`
  - [x] Rimosso il campo `reference_year` da `user_works`
  - [x] Rinominato il campo `work_file` in `file_path`
  - [x] Rinominato il campo `extension` in `file_format`
  - [x] Rinominato il campo `long_side` in `long_size`
  - [x] Rinominato il campo `short_side` in `short_size`
  - [x] Rinominato il campo `monochromatic` in `is_monochromatic`
  - [x] Rinominato il campo `raw` in `has_raw_file`

## 👮‍♂️ Pre Merge check

> <!-- to avoid index -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Se la tabella `user_works` non è mai stata migrata nei target environment: eseguire `php artisan migrate`
- Se la migration originale era già stata eseguita ed il DB è vuoto: eseguire `php artisan migrate:rollback --step=1` (o eliminare la riga dal DB) e poi `php artisan migrate`
- Se la tabella è già riempita: fermare ogni attività e rivalutare una 
  conversione dei nomi.