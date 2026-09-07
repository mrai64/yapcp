# Feature: Modifica ContestSection (modify.blade.php)

> **Branch:** `feat/0076-contest-section-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2025-09-27.02  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / ContestSection - Modify update  
> **Project/issue link:** [#76](https://github.com/mrai64/yapcp/issues/76)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Architettura Componente (Livewire Volt)
La funzionalità implementa la modifica delle sezioni/temi di un concorso (`ContestSection`) attraverso un componente Volt Single-File Component (`organization.design.contest-section.modify`).

1. **Inizializzazione e Autorizzazione (`mount`)**:
   - Viene verficiata l'autorizzazione tramite `ContestSectionPolicy@update`. Un utente può aggiornare la sezione solo se ha il ruolo di amministratore (`isAdmin`) oppure se appartiene all'organizzazione proprietaria del concorso (`isMemberOfOrganization`).
   - Popolamento delle proprietà del componente con i dati del modello `ContestSection` e configurazione automatica dei campi relativi al patrocinio federale se presente.

2. **Gestione Dinamica dei Patrocini (`updatedSelectedFederationId`, `updatedSelectedSectionCode`, `updatedContestSectionUnderPatronage`)**:
   - Se `under_patronage` è attivo, l'utente può selezionare una Federazione (`selectedFederationId`) e successivamente una sezione predefinita (`selectedSectionCode`).
   - All'aggiornamento della sezione federale, i campi del form (codice, titolo in inglese, sinossi, formati file, limiti min/max opere, dimensioni pixel e peso file) vengono auto-compilati a partire dai requisiti ufficiali della `FederationSection`.
   - Disattivando la spunta `under_patronage`, i campi correlati alla federazione vengono resettati a valori nulli/vuoti.

3. **Validazione Avanzata (`rules`)**:
   - Le regole di validazione sono condizionali rispetto allo stato del patrocinio (`under_patronage`).
   - Validazione custom dei formati file supportati tramite la regola `ValidFileFormats`.
   - Controllo dei vincoli dimensionali e di congruenza (es. `max_works >= min_works`, `long_size_max >= short_size_max`).

4. **Persistenza e Reindirizzamento (`modifyContestSection`)**:
   - Aggiornamento/Creazione tramite `ContestSection::updateOrCreate` identificando il record per `contest_id` e `code`.
   - Reindirizzamento alla rotta `organization.design.contest-section.listed` fornendo un messaggio flash di successo.

---

## 🗄️ Modifiche al Database

- [x] Tabella interessata: `contest_sections`
- [x] Campi gestiti: `contest_id`, `code`, `under_patronage`, `federation_section_id`, `name_en`, `name_local`, `synopsis`, `file_formats`, `min_works`, `max_works`, `short_size_max`, `long_size_max`, `file_size_max`, `monochromatic_required`, `raw_required`, `unique_prize`.
- [x] Cast dei tipi sul modello `ContestSection`: boolean per `under_patronage`, `monochromatic_required`, `raw_required`, `unique_prize`; integer per vincoli di dimensione/peso e relazioni.

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`) - Verificato tramite test di feature `ContestSectionModifyTest.php`.
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

---

## 🚀 Note per il Deploy

- Assicurarsi che le tabelle `federations` e `federation_sections` siano popolate per la selezione dei dati di patrocinio.
- Nessuna ulteriore migration o operazione manuale richiesta a database se le tabelle esistenti sono già aggiornate.
