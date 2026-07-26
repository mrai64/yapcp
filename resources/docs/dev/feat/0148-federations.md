# Feature: Aumento federazioni nel seeder

> **Branch:** `0148/feat-federations`  
> **Stato:** In chiusura
> **priorità:** A 
> **id assegnato:** 2026-07-26.03 
> **Titolo e urgenza:** (A) feat: fill seeder with more Federations
> **Project/issue link:** [#148](https://github.com/mrai64/yapcp/issues/148)
> **milestone link:** [n.d.](https://github.com/mrai64/yapcp/milestones/1)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Aggiornato il `FederationSeeder` passando all'utilizzo di `firstOrCreate`. Questo consente di aggiungere un set completo di nuove federazioni internazionali e nazionali garantendo l'idempotenza dello script, che può essere eseguito più volte in sicurezza senza duplicare i record o sovrascrivere modifiche esistenti.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Modificato seeder `FederationSeeder` (inserito approccio idempotente con `firstOrCreate`)
- [x] Eseguito aggiornamento `php artisan db:seed --class=FederationSeeder`

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte? (Non necessario)
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna operazione straordinaria richiesta; il seeder è sicuro grazie all'adozione di `firstOrCreate`.
