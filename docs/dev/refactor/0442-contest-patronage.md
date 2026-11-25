---
title: 'Refactor: Contest Design / ContestPatronage resize patronage_code'
---

> **Branch:** `refactor/0442-contest-patronage`  
> **Project/issue link:** [#442](https://github.com/mrai64/yapcp/issues/442)  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-11-25.01  
> **Titolo e urgenza:** (A) refactor: Organization / Contest Design / Contest - Circuit Add / 4 ContestPatronage  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Per inserire in un circuito tutti i codici di patrocinio assegnati da una
federazione, è necessario superare l'attuale limite di lunghezza del campo
`patronage_code` (20 caratteri) invece di rimuovere i vincoli di unicità
`con_fed_idx` (`contest_id`, `federation_id`) e
`fed_cod_idx` (`federation_id`, `patronage_code`)
sulla tabella `contest_patronages`.

- **Conservazione dei vincoli di unicità:** l'eliminazione degli indici univoci
esporrebbe al rischio di registrare due concorsi con lo stesso codice di
patrocinio per la medesima federazione.  
Con l'allargamento del campo a **72 caratteri**, se un circuito ha ad esempio
patrocinio `FIAF: 2026A1 2026A2 2026A3`, è possibile mantenere sia la stringa
combinata sul circuito, sia i tre singoli concorsi con `FIAF: 2026A1`,
`FIAF: 2026A2`, `FIAF: 2026A3` come 4 valori distinti.
- **Componenti Livewire Volt modificati:**
  - `resources/views/livewire/organization/design/contest-patronage/add.blade.php`:
  aggiornata in `rules()` la validazione di `contPatrPatronageCode`
  da `required|string|uppercase|max:20` a `required|string|uppercase|max:72`.
  - `resources/views/livewire/organization/design/contest-patronage/modify.blade.php`:
  aggiornata in `rules()` la validazione di `contPatrPatronageCode`
  da `required|string|uppercase|max:20` a `required|string|uppercase|max:72`.
- **Interfaccia utente invariata:** entrambe le viste mantengono l'aspetto
estetico, i testi e la larghezza dell'input (`w-60`), poiché sono pagine
dedicate ai singoli concorsi (che ospitano di norma un solo codice).
In una issue successiva saranno introdotte le pagine dedicate ai circuiti,
dove verrà indicato che il campo informativo `patronage_code` può contenere
più codici separati da spazio.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `database/migrations/2026_11_25_195803_mod_col_in_contest_patronages_table.php`:
  - `up()`: modifica nella tabella `contest_patronages` la colonna `patronage_code` da `string(20)` a `string(72)` con `charset('ascii')` e `collation('ascii_general_ci')`.
  - `down()`: ripristina `patronage_code` a `string(20)` con `charset('ascii')` e `collation('ascii_general_ci')`.
  - Indici univoci (`con_fed_idx`, `fed_cod_idx`) e foreign key (`con_pat_con_fk`, `con_pat_fed_fk`) restano invariati.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Eseguire `php artisan migrate`
- Verificare l'effettivo allargamento della colonna `patronage_code` nella tabella `contest_patronages` a `varchar(72)` (`ascii_general_ci`)
