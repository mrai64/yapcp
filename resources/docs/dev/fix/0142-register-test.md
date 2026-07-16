# Feature: fix: register test miss user.dashboard

> **Branch:** `fix/0142-register-test`  
> **Stato:** In Corso
> **priorità:** A
> **id assegnato:** 2026-07-15.01  
> **Titolo e urgenza:** (A) fix: register test miss user.dashboard [id:2026-07-15.01]  
> **Project/issue link:** [#142](https://github.com/mrai64/yapcp/issues/142)
> **milestone link:** [M1](https://github.com/mrai64/yapcp/milestones/1)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Il sito funziona tuttavia il test fallisce perché si è deciso,
a fronte della dashboard organization, della dashboard contest,
d distinguere la user dashboard spostandola da route('dashboard')
in route('user.dashboard'). Questa modifica non ha toccato i test.
Serve, al termine del test, risolvere l'errato puntamento.  
Il test non viene spostato da dov'è.

```bash
$ ./vendor/bin/pest tests/Feature/m001/i0141/RegistrationTest.php 

   FAIL  Tests\Feature\m001\i0141\RegistrationTest
  ✓ registration screen can be rendered                                                                            1.88s  
  - registration screen cannot be rendered if support is disabled → Registration support is enabled.               1.42s  
  ⨯ new users can register                                                                                         1.48s  
  ──────────  
   FAILED  Tests\Feature\m001\i0141\RegistrationTest > new users can register                    RouteNotFoundException   
  Route [dashboard] not defined.
```

Risolto modificando il file /config/fortify.php

```php
    // was 'home' => '/dashboard',
    'home' => '/user/dashboard',
```

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- Nessuna modifica al database

## 👮‍♂️ Pre Merge check

- [X] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?  
  Sì, ma è `php artisan test tests/Feature/m001/i0141/RegistrationTest.php`
- [X] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [X] **Manual:** Il manuale utente riflette le modifiche introdotte?  
  Non ci sono modifiche per l'utente
- [X] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?  
  Non sono stati usati dd()
- [X] **Commit:** I messaggi dei commit sono chiari?  
  Chiari e comprensibili

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Non deve essere eseguita la PR su 'main' ma su 'docs/0141-user-login'
