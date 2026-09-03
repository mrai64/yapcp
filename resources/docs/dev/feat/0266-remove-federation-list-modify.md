# Feature: Rimozione del campo federation_list nella creazione Contest

> **Branch:** `feat/0266-remove-federation-list-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-02.02  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / Contest Modify - rimuovere campo federation_list  
> **Project/issue link:** [#266](https://github.com/mrai64/yapcp/issues/266) (sub-issue di [#209](https://github.com/mrai64/yapcp/issues/209))  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Nel sistema originale, il modello `Contest` prevedeva una colonna testuale libera `federation_list` deputata a contenere i riferimenti ai patrocini ricevuti dal concorso. Con lo sviluppo dell'architettura relazionale dedicata incentrata sul modello `ContestPatronage` (e le relative viste Volt `contest-patronage.add`, `contest-patronage.modify`, `contest-patronage.remove`, `contest-patronage.listed`), il campo `federation_list` è stato reso obsoleto.

La macro-issue [#209](https://github.com/mrai64/yapcp/issues/209) (`feat/0209-contest-remove-federation-list`) scompone la rimozione progressiva del campo in 4 sotto-attività distinte:
1. **[#265](https://github.com/mrai64/yapcp/issues/265)** - Creazione / Add concorso (`make.blade.php`)
2. **[#266](https://github.com/mrai64/yapcp/issues/266)** - Modifica / Modify concorso
3. **[#267](https://github.com/mrai64/yapcp/issues/267)** - Elenco / Listed concorsi
4. **[#268](https://github.com/mrai64/yapcp/issues/268)** - Rimozione / Remove concorso

### Scelte di Design e Flusso Implementativo (`feat/0265-federation-list-add`)

1. **Flusso di Creazione Concorso (Step 0 - Make):**
   - Nel flusso `Organization Contest Design`, l'utente non compila un form interattivo iniziale ma attiva l'azione di creazione tramite il componente Livewire Volt `resources/views/livewire/organization/design/contest/make.blade.php`.
   - Nel metodo `mount(Organization $organization)` viene generato un record `Contest` bozza con valori predefiniti e calendario preimpostato (+1 anno), effettuando subito il redirect allo Step 1 (`organization.design.contest.modify-name`).

2. **Interventi sul campo `federation_list`:**
   - In `make.blade.php`, il campo `federation_list` è valorizzato a stringa vuota con annotazione `// TODO Remove - replaced by ContestPatronage`, preparando il modello al disuso completo senza interferire con la logica di creazione.

3. **Dismissione Componenti Legacy Orfani:**
   - I componenti obsoleti non più utilizzati `app/Livewire/Contest/Add.php` e `resources/views/livewire/contest/add.blade.php` sono stati rinominati in `Add.bak` e `add.blade.bak` come passaggio intermedio verso la loro eliminazione definitiva dal codebase.

4. **Documentazione Utente:**
   - Redazione e aggiornamento della documentazione per l'utente in `resources/docs/1.0/contest_design/contest/add.md`, corredata dalle relative schermate illustrative per la creazione e configurazione del concorso.

---

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Nessuna modifica strutturale o nuova migrazione in questa sotto-issue: il campo `federation_list` nella tabella `contests` non viene più gestito né popolato durante la fase di creazione.
- [ ] La migrazione per il drop della colonna `federation_list` dalla tabella `contests` verrà rilasciata al completamento dell'intero ciclo di rimozione previsto nella issue [#209](https://github.com/mrai64/yapcp/issues/209).

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)
- [x] **Docs:** Il file in `/resources/docs/dev/feat/0265-federation-list-add.md` è aggiornato
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte (`/resources/docs/1.0/contest_design/contest/add.md`)
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati
- [x] **Commit:** I messaggi dei commit sono chiari e conformi agli standard di progetto

---

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Nessuna migrazione database da eseguire per questa singola sotto-issue.
- Nessuna variabile d'ambiente (`.env`) aggiuntiva richiesta.
- I file con estensione `.bak` verranno eliminati nel commit di pulizia finale.
