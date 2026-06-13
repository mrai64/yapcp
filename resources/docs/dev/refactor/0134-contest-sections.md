# Refactor: ContestSection field' names alignment

> **Branch:** `refactor/0134-contest-section`  
> **Stato:** Completato  
> **priorità:** A  
> **id assegnato:** 2026-06-09.02  
> **Titolo e urgenza:** (A) refactor: ContestSection field names alignment  
> **Project/issue link:** [#134](https://github.com/mrai64/yapcp/issues/134)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

I nomi dei campi della tabella `contest_sections` sono stati rinominati
per migliorarne la semantica e la leggibilità, in favore di termini 
più vicini al dominio del concorso (es. `max_works`, `file_size_max`),
e corrispondenti alla tabella `federation_sections`.

È stata inoltre introdotta la gestione per la sinossi della sezione.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `2026_06_14_update_contest_sections_table_fields`
- [x] Ridenominazione campi per chiarezza:
    - `rule_format` → `file_formats`
    - `rule_min` → `min_works`
    - `rule_max` → `max_works`
    - `rule_min_size` → `short_size_max`
    - `rule_max_size` → `long_size_max`
    - `rule_max_weight` → `file_size_max`
    - `rule_monochromatic` → `monochromatic_required`
    - `rule_raw_required` → `raw_required`
    - `rule_only_one` → `unique_prize`
- [x] Aggiunti campi `synopsis_en` e `synopsis_local` (tipo `text`, nullable).

## 💻 Modifiche al Modello

> <!-- to avoid index -->
- [x] Aggiornati i `fillable` e i `casts` per riflettere i nuovi nomi dei campi.
- [x] Aggiornati i tag `@property` e `@method` nel PHPDoc per il supporto all'autocompletamento dell'IDE.
- [x] Corretta la relazione `awards()` (precedentemente corrotta da un errore di sintassi).

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
