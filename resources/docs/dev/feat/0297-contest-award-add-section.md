# Feature: Aggiunta di premi da assegnare a concorso

> **Branch:** `feat/0297-contest-award-add-section`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-09-09.03  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestAward - add for section and contest  
> **Project/issue link:** [#297](https://github.com/mrai64/yapcp/issues/297)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Nel contesto della progettazione del concorso (`Organization / Contest Design`), una volta definite le sezioni/temi è possibile gestire l'elenco dei premi del concorso, e delle singole sezioni.

I componenti Livewire/Volt responsabili della funzionalità sono:
- `listed.blade.php`: visualizza l'elenco dei premi raggruppati per `section_code` (utilizzando nella blade un segnaposto `..` per i premi generali del concorso) e ordinati per `section_id`, `is_award` (desc) e `section_code`.
- `add.blade.php`: consente l'inserimento o il ripristino (`updateOrCreate` con `withTrashed()`) di un premio (`ContestAward`), collegandolo facoltativamente a una sezione (`ContestSection`).

I campi gestiti per ciascun premio includono:
- **`section_id` / `section_code`:** identificatore e codice della sezione associata (se assente, il premio è a livello di concorso globale).
- **`award_code`:** codice univoco all'interno del concorso/sezione, utilizzato come chiave d'ordinamento per la visualizzazione.
- **`award_name`:** denominazione testuale del premio.
- **`is_award`:** flag booleano per distinguere i premi principali/primari (es. trofei, medaglie) da quelli secondari/menzioni d'onore.

La sicurezza e l'accesso alla gestione dei premi sono regolati dalla policy `ContestAwardPolicy` basata sulle relazioni dell'organizzazione e sui ruoli utente (`UserRole`).

## 🗄️ Modifiche al Database

Nessuna modifica strutturale alle tabelle. La funzionalità opera sul modello `ContestAward` legato a `Contest` e `ContestSection`.

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Nessuna operazione o migration specifica richiesta per il deploy.
