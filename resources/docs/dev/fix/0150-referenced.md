# Fix: colonna non trovata | referenced_table

> **Branch:** `fix/0150-referenced`  
> **Stato:** Completato  
> **priorità:** A  
> **id assegnato:** 2026-07-31.01  
> **Titolo e urgenza:** (A) User Contact Info / errore sql su 5a scheda  
> **Project/issue link:** [#150](https://github.com/mrai64/yapcp/issues/150)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

L'errore originario è l'uso di un "nome vecchio" di colonna, e con l'occasione
verificare se questo nome vecchio stia ancora girando in altri punti: Sì.

Sistemati i punti e generato un test con Agy. Chiesto ad Agy d capire perché.

Durante l'esecuzione del nuovo test `./vendor/bin/pest tests/Feature/User/UserContactModifyTest.php`
si verificavano due errori, durante la fase di setup dei dati nel database:

1. **Errore dei Savepoint in MySQL (`PDOException: SAVEPOINT trans2 does not exist`)**:
   L'utilizzo di `TRUNCATE TABLE` e `Schema::disableForeignKeyConstraints()` all'interno dei seeder (`UserRolesRoleContextSeeder` e `FederationSeeder`) eseguiva comandi DDL/session in MySQL. Durante l'esecuzione dei test in Laravel con il trait `RefreshDatabase` (che avvolge ciascun test in una transazione), i comandi DDL resettavano la transazione e i relativi savepoint (`SAVEPOINT trans1`, `trans2` generati internamente da `firstOrCreate()`). Di conseguenza, Laravel falliva cercando di fare il rollback a un savepoint annullato da MySQL.

2. **Errore campo obbligatorio in `FederationSeeder` (`Field 'contact_info' doesn't have a default value`)**:
   Nel seeder `FederationSeeder.php`, le definizioni `firstOrCreate` per i record `GPU` e `PAA` omettevano la chiave `contact_info`. Poiché la colonna `contact_info` nella tabella `federations` è definita come `NOT NULL` senza valore di default, MySQL restituiva un errore SQL 1364.

### Modifiche effettuate

- **`resources/views/livewire/user/contact/modify5.blade.php`**: il "core" della modifica
- **`app/Models/FederationMore.php`**: cambiato nei commenti del PHPDoc
- **`tests/Feature/Admin/FederationMoreCrudTest.php`**: anche questo referenziava la colonna old
- **`tests/Feature/User/UserContactModifyTest.php`**: creato da Agy il test, corretto, lui, però...

- **`database/seeders/UserRolesRoleContextSeeder.php`**:
  Sostituito `UserRolesRoleContext::truncate();` con `UserRolesRoleContext::query()->delete();` per evitare l'esecuzione di comandi DDL che resettano la transazione e i savepoint durante i test.
- **`database/seeders/FederationSeeder.php`**:
  Rimossi i comandi `Schema::disableForeignKeyConstraints()` / 
  `Schema::enableForeignKeyConstraints()` e aggiunta 
  la chiave `'contact_info' => ' '` ai record `GPU` e `PAA`.

```bash
$ ./vendor/bin/pest tests/Feature/User/UserContactModifyTest.php

   PASS  Tests\Feature\User\UserContactModifyTest
  ✓ it allows authenticated users to access user.contact.modify1 page
  ✓ it allows authenticated users to access user.contact.modify2 page
  ✓ it allows authenticated users to access user.contact.modify3 page
  ✓ it allows authenticated users to access user.contact.modify4 page
  ✓ it allows authenticated users to access user.contact.modify5 page
  ✓ it can access all user contact modify pages using a dataset with ('user.contact.modify1')
  ✓ it can access all user contact modify pages using a dataset with ('user.contact.modify2')
  ✓ it can access all user contact modify pages using a dataset with ('user.contact.modify3')
  ✓ it can access all user contact modify pages using a dataset with ('user.contact.modify4')
  ✓ it can access all user contact modify pages using a dataset with ('user.contact.modify5')
  ✓ it redirects unauthenticated users trying to access modify pages with ('user.contact.modify1')
  ✓ it redirects unauthenticated users trying to access modify pages with ('user.contact.modify2')
  ✓ it redirects unauthenticated users trying to access modify pages with ('user.contact.modify3')
  ✓ it redirects unauthenticated users trying to access modify pages with ('user.contact.modify4')
  ✓ it redirects unauthenticated users trying to access modify pages with ('user.contact.modify5')

  Tests:    15 passed (25 assertions)
  Duration: 5.95s
```

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- Nessuna modifica alle migrazioni del database.
- Corretto il seeder `FederationSeeder` aggiungendo il valore di `contact_info` per i record `GPU` e `PAA`.
- Sostituita la chiamata a `truncate()` con `delete()` nel seeder `UserRolesRoleContextSeeder`.

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna nota particolare per il deploy.
