# Feature: Aggiunta colonna a model ContestJury

> **Branch:** `feat/0288-contest-jury-qualify`  
> **Stato:** Corso  
> **priorità:** A  
> **id assegnato:** 2026-09-08.01  
> **Titolo e urgenza:** (A) feat: ContestJury: aggiungere un campo 'qualify'  
> **Project/issue link:** [#288](https://github.com/mrai64/yapcp/issues/288)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Preparando la documentazione per la gestione delle giurie di concorso da parte dell'organizzazione
si è rilevato che manca un dato informativo riportato in tutti i bandi concorso, ovvero
la "qualifica" dei giurati che di volta in volta possono essere presidenti di ...,
rappresentanti di ..., Professionisti. Si tratta di un dato informativo che si può
associare a uno UserRole? Sì, ma essendo applicato sempre solo all'elenco giurati

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `add_cols_to_contest_juries_table`, il campo
  viene definito con default ''.
- [x] Eseguita modifica

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Eseguire `php artisan migrate`
