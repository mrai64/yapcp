# Refactor: FederationSection field names alignment

> **Branch:** `feat/nome-funzione`  
> **Stato:** In Corso / Revisione
> **priorità:** A B C D E  
> **id assegnato:** aaaa-mm-gg-nn  
> **Titolo e urgenza:** Quello riportato nel project  
> **Project/issue link:** [#89](https://github.com/mrai64/yapcp/issues/89)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Allineamento dei nomi dei campi per i limiti dimensionali delle sezioni federali per coerenza con il modello UserWork. 

Campi rinominati:
1. `rule_definition` -> `synopsis`
2. `min_short_side` -> `short_side_max`
3. `max_long_side` -> `long_size_max`
4. `max_weight` -> `file_size_max`
5. `only_one` -> `unique_prize`

Inoltre, è prevista la migrazione delle pagine CRUD da Livewire 3 a Livewire 4 (Volt SFC).

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Modificata migration `create_federation_sections_table`
- [x] Rinominati campi per maggiore chiarezza semantica
- [x] ricerca e sostituzione campi dal model in avanti  
- [ ] Migrazione componenti Livewire a Volt SFC (Livewire 4 style)

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate:fresh` o creare una migration di rename.

