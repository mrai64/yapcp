# feat/0115 - Cascade delete for Federation

## Sommario
Questa scheda tecnica descrive le modifiche introdotte nel branch `feat/0115-federation-delete` rispetto a `docs/0181-federation-all`.
Lo scopo principale è introdurre una cancellazione a cascata controllata (soft-delete) per le entità correlate ad una Federation, evitando lock lunghi e blocchi della piattaforma quando le righe correlate sono molte.

## File aggiunti / modificati
- Aggiunti
  - app/Jobs/CascadeDeleteFederationJob.php
  - app/Observers/FederationObserver.php
  - tests/Feature/Jobs/CascadeDeleteFederationJobTest.php
  - dev-diary/2026-08/2026-08-18_IT.md
- Modificati
  - app/Models/Federation.php
  - app/Models/UserWorkMore.php
  - app/Models/FederationMoresReferencedSets.php
  - app/Providers/AppServiceProvider.php

## Descrizione tecnica delle modifiche
1. CascadeDeleteFederationJob (nuovo)
   - Job che implementa ShouldQueue.
   - Riceve una Federation e procede a cancellare (soft delete) i record correlati in batch, per tabelle che contengono `federation_id` come ponte.
   - Strategie usate:
     - withTrashed() per includere eventuali record già soft-deleted.
     - chunkById(100) per processare i record a piccoli lotti ed evitare lock lunghi.
     - Per ogni lotto, richiama ->delete() su ogni record (soft delete).
   - Tabelle interessate dal job (nell'ordine usato): user_work_mores, user_contact_mores, federation_mores, federation_sections, user_roles.

2. FederationObserver (nuovo)
   - Osservatore su Federation.
   - Alla cancellazione (deleted event) logga e dispatcha CascadeDeleteFederationJob per la Federation appena soft-deleted.
   - Questo separa l'operazione pesante dalla transazione che effettua la soft-delete della Federation.

3. Modifiche al model Federation
   - Aggiunte le type-hint dei metodi di relazione (HasMany/BelongsTo) per migliorare l'autocomplete e la documentazione.
   - Aggiunta la relazione `moreWorkFields()` che ritorna i UserWorkMore associati alla Federation.

4. Modifiche al model UserWorkMore
   - Aggiunta di costanti, $fillable e casts per rendere il model più esplicito e sicuro.
   - Definite relazioni `userWork()` e `federation()` (BelongsTo).
   - Aggiornati i phpdoc per riflettere le proprietà e le relazioni.

5. Modifica a FederationMoresReferencedSets
   - Aggiunto `$fillable = ['id']` per evitare problemi di mass-assignment nella creazione/firstOrCreate dal test o da runtime.

6. Registrazione dell'observer
   - In AppServiceProvider::boot() è stata aggiunta la registrazione: `Federation::observe(FederationObserver::class);`

7. Test
   - tests/Feature/Jobs/CascadeDeleteFederationJobTest.php
     - Test che il job soft-deletta i record correlati alla Federation A ma non quelli della Federation B.
     - Test che la cancellazione di una Federation dispatcha il job (usando Queue::fake()).
   - I test coprono i principali casi di integrazione della feature.

8. Dev-diary
   - Aggiunto un diario che documenta brevemente lo scopo e lo stato della subissue.

## Motivazione
Quando la quantità di record correlati cresce, affidarsi ad onDelete(cascade) a livello DB può causare blocchi lunghi e impatti sulle prestazioni. La soluzione presentata esegue la pulizia in background, a batch, limitando l'impatto sul database e consentendo di processare le cancellazioni in modo scalabile.

## Come usare / verificare
- Per eseguire i test relativi:
  - php artisan test --filter CascadeDeleteFederationJobTest
- Per simulare manualmente (da tinker o codice):
  - Dal tinker: $f = App\\Models\\Federation::find('FEDA'); $f->delete();
  - Assicurarsi che un worker consumi la coda: php artisan queue:work (oppure usare dispatchSync nelle verifiche locali).
- Nota: i test già usano dispatchSync per il job in fase di verifica e Queue::fake per l'altro test.

## Note operative e rischi
- Assicurarsi che tutte le tabelle referenziate (user_work_mores, user_contact_mores, federation_mores, federation_sections, user_roles) esistano e abbiano soft deletes abilitati (colonna `deleted_at`) se ci si aspetta soft-delete.
- Verificare che non ci siano altre logiche legate a onDelete(cascade) che possano entrare in conflitto con questo approccio.
- Il job esegue più chiamate delete individuali; se ci sono trigger o logiche onDelete complesse, valutare l'impatto e i tempi.

## Miglioramenti possibili
- Aggiungere metriche/log più dettagliati nel job (conteggio record processati, tempi, errori).
- Supportare chunk dinamici o limiti configurabili via config.
- Prevedere una strategia di retry avanzata in caso di errori transitori.

## Changelog sintetico (per la PR)
- Aggiunto Job per cancellazione a cascata batch
- Aggiunto Observer per dispatch del job alla cancellazione di una Federation
- Aggiornati i model Federation e UserWorkMore
- Aggiunti test di integrazione

