# Feature: Federation Delete Policy

> **Branch:** `feat/0114-federation-delete-policy`  
> **Stato:** Revisione
> **priorità:** A  
> **id assegnato:** 2026-03-23.01  
> **Titolo e urgenza:** (A) feat: Federation CRUD / delete, remove only under certain conditions  
> **Project/issue link:** [#114](https://github.com/mrai64/yapcp/issues/114)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Si richiede che la cancellazione di una `Federation` sia consentita **solo a un utente admin** e **solo se non vi sono concorsi attivi** associati.

- **Check Policy (`FederationPolicy::delete`)**:
- Verifica che `$user->isAdmin()` sia `true`.
- Controlla la relazione `$federation->activeContests()->exists()`.
- La cancellazione è permessa solo se `! $federation->activeContests()->exists()`.

- **Definizione di "Concorso Attivo" (`Federation::activeContests`)**:
- Un concorso è attivo se la data odierna si trova compresa nel range tra l'apertura e la chiusura: `day_1_opening <= NOW() <= day_8_closing`.

- **Protezione della rotta Volt**:
- La rotta `federation.remove` applica il middleware `can:delete,federation` basato sulla policy per bloccare tentativi non autorizzati (restituendo `403 Forbidden`).

## 🗄️ Modifiche al Database

Nessuna modifica alle migrazioni o allo schema del database.

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test passano in verde (`vendor/bin/pest tests/Feature/m003/i0114/FederationDeletePolicyTest.php`)
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?


## 🚀 Note per il Deploy

Nessuna nota specifica per il deploy.
