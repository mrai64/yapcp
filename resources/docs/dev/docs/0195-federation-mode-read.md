# Feature: Elencare i "campi in più" richiesti dalle Federazioni

> **Branch:** `feat/0195-federation-more-read`  
> **Stato:** chiuso
> **priorità:** A  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, solo senza [id...]  
> **Project/issue link:** [#195](https://github.com/mrai64/yapcp/issues/195)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

---

## 📝 Logica Tecnica

Spiega qui il "perché" hai scelto una certa soluzione (es. "Uso un Job invece di un listener sincrono perché l'API esterna è lenta").

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `create_xxx_table`
- [ ] Aggiunto campo `status` a `users`
- [ ] Lorem ipsum

## 👮‍♂️ Pre Merge check

- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
- Aggiungere `STRIPE_SECRET` nel file .env
