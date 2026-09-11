# Feature: Organization / Contest Design / ContestAward - modify for section and contest

> **Branch:** `feat/0298-contest-award-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-09.04  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestAward - modify for section and contest  
> **Project/issue link:** [#298](https://github.com/mrai64/yapcp/issues/298)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Nel contesto della progettazione del concorso (`Organization / Contest Design`), una volta definite le sezioni/temi è possibile gestire l'elenco dei premi del concorso e delle singole sezioni. In caso di errori o ripensamenti, questa funzionalità gestisce la modifica di un premio esistente.

La logica implementata prevede:

- **Controllo Autorizzazioni:** La modifica è permessa solo agli utenti Admin o ai membri dell'organizzazione proprietaria del concorso (`ContestAwardPolicy`).
- **Invarianza dell'Ambito:** Non è prevista la modifica diretta di `contest_id` o `section_id`; i premi vengono modificati solo all'interno del loro settore di competenza originario.
- **Aggiornamento o Ricreazione (Handling del Codice):** Qualora l'utente modifichi `award_code`, la procedura esegue la cancellazione del vecchio record (`delete()`) e l'aggiornamento/ricreazione (`updateOrCreate()`) gestendo anche eventuali record in *soft-delete*.

I campi modificabili sono:

- **`award_code`:** Codice univoco (convertito in maiuscolo, max 10 caratteri) all'interno della combinazione concorso/sezione, utilizzato come chiave d'ordinamento per la visualizzazione.
- **`award_name`:** Denominazione testuale del premio (max 255 caratteri).
- **`is_award`:** Flag booleano per distinguere i premi principali/primari (es. trofei, medaglie) da quelli secondari/menzioni d'onore.

## 🗄️ Modifiche al Database

Nessuna modifica strutturale alle tabelle. La funzionalità opera sul modello esistente `ContestAward` legato a `Contest` e `ContestSection`.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Nessuna operazione o migration specifica richiesta per il deploy.
