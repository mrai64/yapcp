# Feature: Assegnazione Premi Contest

> **Branch:** `feat/0063-contest-award-modify`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 0063  
> **Titolo e urgenza:** Assegnazione premi contest e gestione vincitori  
> **Project/issue link:** [#89](https://github.com/mrai64/yapcp/issues/89)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

La modifica riguarda la gestione dei premi associati a un contest (`ContestAward`), in particolare l’assegnazione del vincitore tra tre possibilità distinte:

- `winner_work_id`: premio attribuito a un lavoro specifico
- `winner_user_id`: premio attribuito a un utente specifico
- `winner_name`: premio attribuito a un nome libero, senza riferimento a un lavoro o utente

La scelta di usare tre colonne separate invece di una relazione polimorfica con chiave generica (`work`, `user`, `name`) + codice identificativo nasce dalla necessità di mantenere la logica di business semplice e immediata in UI e in query. In pratica, il sistema deve poter:

1. elencare tutti i premi di un contest e capire rapidamente se sono già assegnati o ancora pendenti;
2. mostrare i premi in una vista dedicata, completando i campi di assegnazione;
3. mostrare i lavori in una seconda vista, permettendo di assegnare un lavoro ai premi ancora aperti.

Questa struttura consente due blade principali:

- una blade che elenca i premi del contest e mostra lo stato di completamento;
- una seconda blade che elenca i lavori del contest e permette di assegnare i lavori ai premi non ancora valorizzati.

Il vantaggio principale è che le query e i controlli sono più leggibili: non serve costruire logica di tipo polimorfico per capire se un premio è stato assegnato a un lavoro, a un utente o a un nome manuale. Inoltre, il rendering in Blade è più diretto e meno fragile, perché i campi sono espliciti e facilmente leggibili dal front-end.

In sintesi, la soluzione è stata scelta per bilanciare flessibilità, semplicità di sviluppo e chiarezza del dato nel database.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `modify_contest_awards_winner_fields`
- [x] Aggiunti campi `winner_work_id`, `winner_user_id`, `winner_name` a `contest_awards`
- [ ] Verifica/validazione per garantire che solo uno tra i tre campi sia valorizzato
- [ ] Aggiornati model e query per determinare lo stato di completamento del premio
- [ ] Aggiornata la logica di assegnazione nelle view Blade per premi e lavori

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
- Verificare che i premi esistenti vengano aggiornati correttamente con eventuali assegnazioni già presenti
- Controllare le Blade di elenco premi e elenco lavori per assicurarsi che i nuovi campi siano visualizzati e salvati correttamente
- Verificare la validazione di business: un premio deve avere un solo vincitore valorizzato tra `winner_work_id`, `winner_user_id` e `winner_name`