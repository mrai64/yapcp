# Refactor: UserContact / resize whatsapp field

> **Branch:** `refactor/0352-user-contact-whatsapp`  
> **Stato:** Revisione  
> **priorità:** B  
> **id assegnato:** 2026-09-19.03  
> **Titolo e urgenza:** (B) refactor: UserContact / resize whatsapp field  
> **Project/issue link:** [#352](https://github.com/mrai64/yapcp/issues/352)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)
- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [💻 Modifiche Applicative](#-modifiche-applicative)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La definizione originale del campo `whatsapp` come string generica (255 caratteri) nella tabella `user_contacts` è risultata sovradimensionata per l'effettivo scopo d'uso.
Il campo è destinato a contenere l'URL diretto al contatto nel formato `https://wa.me/<numero>`:

- Prefisso standard `https://wa.me/`: 14 caratteri.
- Numero di telefono internazionale secondo lo standard ITU-T E.164: fino a 15 cifre.
- Lunghezza massima tipica: ~29 caratteri.

La dimensione della colonna è stata quindi ridefinita a **36 caratteri** (`string(36)`), offrendo un margine di tolleranza per eventuali variazioni o prefissi mantenendo una corretta ottimizzazione dello schema.

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `database/migrations/2026_10_01_081137_resize_col_in_user_contacts_table.php` per modificare la colonna `whatsapp` a `string(36)` con `charset ascii` e `collation ascii_general_ci`.
- [x] Eseguita migration in locale (`php artisan migrate`).
- [x] Aggiornata documentazione dello schema in `resources/docs/dev/man/dbdoc.md`.

## 💻 Modifiche Applicative

> <!-- to avoid index in Larecipe -->
- [x] **Livewire View (`modify3`):** in `resources/views/livewire/user/contact/modify3.blade.php`, aggiornata la regola di validazione da `max:50` a `max:36` (con regex `^https:\/\/wa\.me\/[0-9]+$`), ridimensionato l'input field a `w-1/2` e aggiornato il placeholder esplicativo.
- [x] **Model UserContact:** allineato il blocco PHPDoc del model `app/Models/UserContact.php`.
- [x] **Job di Importazione:** verificato `App\Jobs\Imports\UserWorkAndRelatedImportYamlJob.php` (già configurato con `nullable|url|max:36`).
- [x] **Model Factory:** allineato `database/factories/UserContactFactory.php`.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Verificare con test specifici il limite a 36 caratteri e la validazione del campo `whatsapp`, e sistemare il factory `UserContactFactory`.
- [x] **Docs:** Aggiornato `resources/docs/dev/man/dbdoc.md`.
- [x] **Manual:** Il manuale utente in `resources/docs/1.0/users/contact_infos.md` descrive la card 3/5 per il contatto telefonico/WhatsApp.
- [x] **Cleanup:** Nessun `dd()` o `dump()` lasciato nel codice.
- [ ] **Commit:** Committare le modifiche non ancora tracciate (`modify3.blade.php`, `show.blade.php`, docs, ecc.).

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- **Backup preventivo:** eseguire un backup integrale della tabella `user_contacts`.
- **Pre-check dati esistenti (critico):** prima di applicare la migration in produzione, verificare che non vi siano record pregressi con lunghezza > 36 caratteri per evitare errori di troncamento o blocchi con MySQL strict mode:

  ```sql
  SELECT id, email, whatsapp, CHAR_LENGTH(whatsapp) AS len
  FROM user_contacts
  WHERE CHAR_LENGTH(whatsapp) > 36;
  ```

- **Migration:** eseguire `php artisan migrate`.
- **Post-check:** verificare da `SHOW COLUMNS FROM user_contacts LIKE 'whatsapp'` che il tipo sia `varchar(36)`.
