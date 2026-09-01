# Scheda Tecnica: Componente Blade "ContestPatronage"

> **Branch:** `docs/0258-contest-patronage-listed`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-31.02  
> **Titolo e urgenza:** Implementazione componente Livewire Volt e blade per aggiungere un ContestPatronage  
> **Project/issue link:** [#258](https://github.com/mrai64/yapcp/issues/258)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Questa funzionalità fornisce l'interfaccia di visualizzazione dell'elenco dei patrocini delle federazioni fotografiche (`ContestPatronage`) associati a uno specifico concorso (`Contest`).

### Scelte di Design e Architettura

1. **Componente Livewire Volt (Single File Component):**
   - Implementazione tramite componente Volt per una gestione snella e integrata tra logica PHP e template Blade.
   - **Inizializzazione (`mount`):**
     - Riceve l'istanza del modello `Contest` passato come parametro di rotta.
     - Recupera l'organizzazione associata tramite `$contest->organization`.
     - Effettua la query sulla tabella `contest_patronages` filtrando per `contest_id` ed ordinando per `federation_id` e `patronage_code`.

2. **Caricamento Dati e Navigazione Relazionale:**
   - La vista accede alle relazioni definite nel modello `ContestPatronage`:
     - `$contestPatronage->federation`: ottiene i dettagli della federazione (es. `id`, `name_en`).
     - `$contestPatronage->federation->country`: accede ai dati del paese correlato per visualizzare il codice/flag (`flag_code`).

3. **Interfaccia Utente e UX (Blade):**
   - Utilizzo dell'header strutturato con i componenti `x-yapcp.organization.design.contest-nav` (con stato attivo su `patronages`) e i link di navigazione rapida (`header-link`) verso Dashboard Utente, Dashboard Organizzazione e Form di Aggiunta Patrocinio (`organization.design.contest-patronage.add`).
   - **Stato Vuoto (Empty State):** Se non sono presenti patrocini assegnati, mostra un messaggio informativo indicando che i patrocini sono facoltativi ed invita ad aggiungerne uno.
   - **Visualizzazione Elenco:** In presenza di patrocini, viene mostrato l'elenco stilizzato in font monospaziale contenente flag del paese, identificativo della federazione, codice del patrocinio e nome completo della federazione in inglese.

---

## 🗄️ Modifiche al Database

- [x] Utilizzo della tabella esistente `contest_patronages` per la consultazione dei record.
  - Query in lettura filtrata su colonna `contest_id` ed ordinamento `federation_id`, `patronage_code`.
- [x] Sostituzione funzionale della colonna legacy `federation_list` nel modello `Contest` con la relazione strutturata `ContestPatronage`.

---

## 👮‍♂️ Pre Merge check

- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

---

## 🚀 Note per il Deploy

- Eseguire `php artisan migrate` per garantire l'esistenza della tabella `contest_patronages`.
- Verificare la presenza delle rotte `organization.design.contest-patronage.listed` e `organization.design.contest-patronage.add` in `routes/web.php`.
