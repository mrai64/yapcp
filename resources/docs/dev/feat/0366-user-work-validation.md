# Feature: Contest Work review before Jury start

> **Branch:** `feat/0366-user-work-validation`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-06.02  
> **Titolo e urgenza:** (A) feat: Organization / Contest Management - Revisione opere prima della giuria  
> **Project/issue link:** [#366](https://github.com/mrai64/yapcp/issues/366)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L’operazione introdotta da questa feature consente all’organizzazione di esaminare, prima dell’apertura della giuria, le opere presentate a un concorso per rilevare problemi che non possono essere validati automaticamente dal sistema. L’obiettivo non è solo mostrare la lista delle opere, ma filtrare in modo intelligente quelle già considerate idonee o già segnalate, riducendo così il carico di revisione e impedendo di ri-presentare lavori già esclusi o già validati.

La logica si sviluppa in tre passaggi principali:

1. Identificazione delle sezioni federali attive del contest
   - Il componente Livewire `listed.blade.php` recupera tutte le `ContestSection` collegate al contest in cui `federation_section_id` non sia nullo.
   - Questo filtro è importante perché la validazione umana riguarda i lavori che rientrano in una sezione riconosciuta dalla federazione, evitando di includere sezioni non pertinenti o ancora non configurate.

2. Raccolta degli id delle opere già escluse
   - Vengono caricati tutti i `ContestWork` legati al contest corrente tramite `contest_id`.
   - Da questa lista si costruisce l’array dei `user_work_id` associati.
   - Successivamente si recuperano:
     - i lavori già inseriti in `contest_waitings` per lo stesso contest;
     - i lavori già validati in `user_work_validations` per la stessa sezione federale.
   - Questi due insiemi vengono uniti in un unico insieme di esclusione (`$excludedUserWorkIds`).
   - In pratica: un lavoro che è stato già:
     - segnalato come problematico e messo in attesa;
     - oppure validato in precedenza per la stessa sezione federale;
     viene automaticamente eliminato dalla lista di revisione.

3. Query di presentazione e paginazione
   - Il componente usa il metodo `with()` del componente Livewire per costruire la lista di lavoro.
   - La query principale è:
     - `ContestWork::query()->with(['userWork'])`
     - `->where('contest_id', $this->contest->id)`
     - `->whereNotIn('user_work_id', $excludedUserWorkIds)`
     - `->orderBy('updated_at')`
     - `->paginate(6)`
   - Questo garantisce che la pagina mostri solo opere ancora da esaminare, ordinate per aggiornamento recente e con una navigazione paginata.
   - Ogni riga della tabella mostra un link `Review` che porta alla pagina di dettaglio del lavoro per la valutazione manuale.

La funzione centrale è quindi la logica di esclusione preventiva, che riduce il Dataset a soli lavori “ancora non esaminati” e “non già validati” per la sezione federale di appartenenza. Il comportamento è progettato per evitare duplicazioni, doppie segnalazioni e revisione di opere già definite come accettabili o già allertate all’autore.

Il componente non crea nuove tabelle o colonne: lavora esclusivamente sulle relazioni esistenti tra:

> <!-- to avoid index in Larecipe -->
- `contest_works`
- `contest_waitings`
- `user_work_validations`
- `contest_sections`

Questo mantiene la modifica semplice, compatibile con il modello dati attuale e senza impatto sull’import/export dei dati contestuali.

Inoltre la UX è orientata a una revisione guidata:

> <!-- to avoid index in Larecipe -->
- la pagina indica “No works to review” se il filtro esclude tutto;
- la tabella mostra il numero progressivo del lavoro e titolo dell’opera;
- il link “Review” apre il dettaglio della singola opera per il controllo umano.

Questo approccio è coerente con il requisito del problema: la revisione umana è necessaria per controllare elementi non rilevabili automaticamente, come aderenza ai requisiti del concorso, qualità visiva, completezza del file, coerenza con la sezione, correttezza del titolo o eventuali problemi non riconducibili a validazione tecnica.

---

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database.

La feature si appoggia alle tabelle già esistenti e non richiede nuove migrazioni:

> <!-- to avoid index in Larecipe -->
- `contest_works`: archivia le opere iscritte al contest;
- `contest_waitings`: registra le opere messe in attesa per problemi;
- `user_work_validations`: memorizza le validazioni già effettuate da parte dei revisori;
- `contest_sections`: identifica le sezioni del contest e il mapping federale.

Il pattern è quello di utilizzare query di filtro e non di introdurre nuove entità di dominio. La soluzione è quindi un’estensione del flusso di revisione esistente, non un nuovo modello di persistenza.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

---

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.

La modifica è completamente trasparente per il runtime applicativo:

> <!-- to avoid index in Larecipe -->
- non aggiunge nuovi trigger;
- non richiede nuovi asset front-end;
- non richiede warm-up del database;
- non necessita di job async o queue;
- non modifica schema o policy di accesso.

L’unica attenzione consiste nel verificare che le route e i permessi di autorizzazione `organization.contest-work.review` siano correttamente definiti e accessibili agli operatori organizzativi del contest. Inoltre va controllato che i dati di `contest_waitings` e `user_work_validations` siano coerenti con la logica di esclusione, evitando di filtrare erroneamente lavori ancora validi.
