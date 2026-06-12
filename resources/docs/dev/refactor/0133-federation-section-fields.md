# Refactor: FederationSection field names alignment

> **Branch:** `refactor/0133-federation-section-fields`  
> **Stato:** Concluso  
> **priorità:** A
> **id assegnato:** 2026-06-09.01  
> **Titolo e urgenza:** (A) refactor: FederationSection field names alignment  
> **Project/issue link:** [#133](https://github.com/mrai64/yapcp/issues/133)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Allineamento dei nomi dei campi per i limiti dimensionali delle sezioni federali per coerenza con il modello UserWork.

Campi rinominati:

1. `rule_definition` -> `synopsis`
2. `min_short_side` -> `short_size_max` (Nota: correzione semantica da min a max)
3. `max_long_side` -> `long_size_max`
4. `max_weight` -> `file_size_max`
5. `only_one` -> `unique_prize`

Inoltre, è prevista la migrazione delle pagine CRUD da Livewire 3 a Livewire 4 (Volt SFC).

- [x] pagina List
- [x] pagina Add
- [x] pagina Modify
- [x] pagina Remove

Rimosse le vecchie blade + component

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Modificata migration `create_federation_sections_table`
- [x] Rinominati campi per maggiore chiarezza (vedi nota seguente)
- [x] ricerca e sostituzione campi dal model in avanti
- [x] Aggiornato array `$fillable` nel Model `FederationSection`
- [x] Aggiornate le regole di validazione nelle FormRequest o componenti Volt
- [x] Aggiornati gli attributi nei file di traduzione (`lang/it/validation.php`)

Nota: non è stato fatto il canonico ciclo di migrazione colonna
vecchia > colonna nuova, essendo ancora il repository in sviluppo
e la tabella praticamente vuota o con pochi dati di test.

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Per ambienti di sviluppo/test: Eseguire `php artisan migrate:fresh` per applicare tutte le modifiche.
- Per la produzione: È **fondamentale** creare una migration dedicata per la rinomina delle colonne. Considerare l'approccio a più step (aggiunta nuova colonna, backfill dati, switch codice, rimozione vecchia colonna) per garantire zero-downtime, specialmente su tabelle con molti dati.
- Dopo la migration, eseguire `php artisan db:seed` se necessario per popolare dati di lookup o configurazione.
- Verificare il corretto funzionamento delle pagine CRUD di FederationSection.
- test with pest: `tests/Feature/Admin/FederationSectionCrudTest.php`
