# Feature: Nome Funzione

> **Branch:** `feat/nome-funzione`  
> **Stato:** In Corso / Revisione / Chiuso
> **priorità:** A B C D E  
> **id assegnato:** aaaa-mm-gg.nn  
> **Titolo e urgenza:** Quello riportato nel project, solo senza [id...]  
> **Project/issue link:** [#89](https://github.com/mrai64/yapcp/issues/89)
> **milestone link:** [M1](https://github.com/mrai64/yapcp/milestones/1)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Spiega qui il "perché" hai scelto una certa soluzione (es. "Uso un Job invece di un listener sincrono perché l'API esterna è lenta").

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `create_xxx_table`
- [ ] Lorem ipsum
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
