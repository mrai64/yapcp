# Feature: Nome Funzione

> **Branch:** `feat/0167-user-work-wnh`  
> **Stato:** Chiuso
> **priorità:** A  
> **id assegnato:** 2026-08-08.01  
> **Titolo e urgenza:** Quello riportato nel project, solo senza [id...]  
> **Project/issue link:** [#167](https://github.com/mrai64/yapcp/issues/167)
> **milestone link:** [M2](https://github.com/mrai64/yapcp/milestones/2)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Per migliorare la visualizzazione della galleria, sono stati aggiunti al modello UserWork tre nuovi campi: width, height e il flag booleano is_landscape.

Invece di sostituire le metriche esistenti, si è deciso di mantenere sia width ed height sia i precedenti campi per il lato lungo e il lato corto. Di conseguenza, sono state aggiornate le viste Blade dedicate al caricamento dell'immagine e alla gestione delle gallery per esporre esplicitamente altezza e larghezza.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
cco il testo rielaborato e strutturato per aggiornare la scheda:

📝 Logica Tecnica
Per migliorare la visualizzazione della galleria, sono stati aggiunti al modello UserWork tre nuovi campi: width, height e il flag booleano is_landscape.

Invece di sostituire le metriche esistenti, si è deciso di mantenere sia width ed height sia i precedenti campi per il lato lungo e il lato corto. Di conseguenza, sono state aggiornate le viste Blade dedicate al caricamento dell'immagine e alla gestione delle gallery per esporre esplicitamente altezza e larghezza.

🗄️ Modifiche al Database

Poiché la tabella era di fatto vuota, si è optato per modificare direttamente la migration originale di creazione della tabella (create_user_works_table) aggiungendo le 3 nuove colonne, invece di generare una nuova migration di alterazione/aggiunta campi.

- [x] Aggiornata la migration iniziale di creazione tabella 
  user_works con i campi width, height e is_landscape.

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Database: Poiché la migration di creazione della tabella user_works è stata modificata direttamente:
  - In ambiente locale / staging: eseguire php artisan migrate:fresh 
    (o php artisan migrate:refresh) per ricreare le tabelle.
  - In ambiente di produzione: non rieseguire semplicemente 
    php artisan migrate. Occorre ricreare la tabella o allineare 
    manualmente la struttura eseguendo una query di alter per 
    aggiungere i campi width, height e is_landscape.
