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

Spiega qui il "perché" hai scelto una certa soluzione (es. "Uso un Job invece di un listener sincrono perché l'API esterna è lenta").

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `change_cols_name_in_federation_sections_table`
- [x] rinominati campi
- [x] ricerca e sostituzione campi dal model in avanti  
  no modifiche in dev diary no modifiche in database migration e
  no modifiche su contest_section
- [ ] Creare o modificare i blade che fanno CRUD per il model FederationSection

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
