# Feature: Aumento federazioni nel seeder

> **Branch:** `0146/feat-federations`  
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

## 📝 Logica Tecnica

Aggiornato il `FederationSeeder` per includere un set completo di nuove federazioni 
rilevate durante l'analisi dei requisiti del concorso X, garantendo un database di test 
più aderente agli scenari reali.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Modificato seeder `FederationSeeder`  
  Ora l'esecuzione può essere fatta e rifatta più volte senza rompere
  eventuali altre federazioni già caricate
- [x] Eseguito aggiornamento `php artisan db:seed --class=FederationSeeder`

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
  Sì
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
  Sì
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
  Non necessario
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
  Verificato
- [ ] **Commit:** I messaggi dei commit sono chiari?
  Sì

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire backup tabelle (non solo federation)
