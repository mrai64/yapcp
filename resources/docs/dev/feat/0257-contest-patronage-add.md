# Feature: Aggiunta Patrocinio Federazione al Concorso (ContestPatronage)

> **Branch:** `feat/0257-contest-patronage-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-31.01  
> **Titolo e urgenza:** Implementazione componente Livewire Volt e blade per aggiungere un ContestPatronage  
> **Project/issue link:** [#257](https://github.com/mrai64/yapcp/issues/257)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Questa funzionalità consente a un'organizzazione di associare un patrocinio di una federazione fotografica (`ContestPatronage`) a uno specifico concorso (`Contest`).

### Scelte di Design e Architettura
1. **Componente Livewire Volt (Single File Component):**
   - Utilizzo di Volt per incapsulare la logica di backend PHP e il template Blade nello stesso file view.
   - **Autorizzazione (`mount`):** Viene verificata la policy `$this->authorize('create', [ContestPatronage::class, $contest])` al caricamento della pagina per garantire che solo gli utenti autorizzati possano aggiungere patrocini.
   - **Caricamento dati:** Nel metodo `mount()`, vengono recuperati i modelli del concorso (`Contest`) e della relativa organizzazione (`Organization`). Viene inoltre caricata la lista di tutte le federazioni (`Federation`) pre-caricando la relazione `country` in eager loading (`with(['country'])`) e ordinata per paese (`country_id`) e nome (`name_en`).

2. **Validazione e Salvataggio:**
   - Regole definite nel metodo `rules()`:
     - `contPatrFederationId`: campo obbligatorio, stringa, deve esistere nella tabella `federations` (colonna `id`).
     - `contPatrPatronageCode`: campo obbligatorio, stringa, convertito automaticamente in maiuscolo (`uppercase`), con lunghezza massima di 20 caratteri.
   - Nel metodo `addContestPatronage()`:
     - Esecuzione di `$this->validate()`.
     - Creazione del record tramite `ContestPatronage::create()`.
     - Reindirizzamento alla rotta `organization.design.contest-patronage.listed` passando l'istanza di `$contest` e un messaggio flash di successo (`success`).

3. **Interfaccia Utente (Blade):**
   - Integrazione con i componenti della suite `x-yapcp` per la navigazione (`contest-nav`, `header-link`, `footer-app`).
   - Visualizzazione dei messaggi di errore e di avviso/successo.
   - Form interattivo con selezione della federazione (inclusa la visualizzazione del flag/paese `flag_code`) e campo testo per l'inserimento del codice di patrocinio (`patronage_code`).

4. **Relazioni di Modello coinvolte:**
   - `Contest` **1:N** `ContestPatronage` (`$contest->contestPatronage()`)
   - `Federation` **1:N** `ContestPatronage` (`$contestPatronage->federation()`)
   - `ContestPatronage` appartiene a (`belongsTo`) `Contest` e `Federation`.

---

## 🗄️ Modifiche al Database

- [x] Utilizzo della tabella esistente `contest_patronages` (modello `ContestPatronage`).
  - `id`: Chiave primaria auto-incrementante (`integer`).
  - `contest_id`: FK verso `contests.id` (`string` / UUID).
  - `federation_id`: FK verso `federations.id` (`string`).
  - `patronage_code`: Codice identificativo del patrocinio (`string`, max 20).
  - Gestione del Soft Delete (`deleted_at`).
- [x] Progressiva dismissione e rimozione del campo `federation_list` (stringa testo libero) presente nel modello `Contest` a favore della tabella relazionale `contest_patronages`.

---

## 👮‍♂️ Pre Merge check

- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato con le specifiche di `ContestPatronage`
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte per l'aggiunta dei patrocini
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati
- [ ] **Commit:** I messaggi dei commit sono chiari e seguono le convenzioni del progetto

---

## 🚀 Note per il Deploy

- Assicurarsi che la tabella `contest_patronages` e la tabella `federations` siano gia consolidate nel database di produzione tramite `php artisan migrate`.
- Verificare che le rotte per `organization.design.contest-patronage.listed` siano correttamente configurate in `routes/web.php`.
