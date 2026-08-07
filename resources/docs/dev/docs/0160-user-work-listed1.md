# Docs: Galleria e Vista Tabellare Lavori Utente (UserWork)

> **Branch:** `docs/0160-user-work-listed1`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-08-06.02  
> **Titolo e urgenza:** (A) docs: User and Dev docs for UserWork listing in table form  
> **Project/issue link:** [#160](https://github.com/mrai64/yapcp/issues/160)
> **milestone link:** [M2](https://github.com/mrai64/yapcp/milestones/2)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

- **Componente Volt con Paginate:** Utilizzato Livewire Volt in sintassi funzionale/anonima (`new class extends Component`). Per la gestione della paginazione è stato incluso il trait `WithPagination`. Come da convenzione Volt con impaginazione, viene implementato il metodo `with()` anziché `mount()` o `render()`.
- **Filtro e Ordinamento:** Vengono estratti solo i record associati all'utente correntemente autenticato (`Auth::id()`). L'ordinamento primario è alfabetico su `title_en` (`asc`), mentre l'ordinamento secondario è basato sulla data di ultimo aggiornamento `updated_at` (`desc`). La paginazione è impostata a 10 elementi per pagina.
- **Determinazione Risoluzione (Width / Height):** All'interno del ciclo di rendering `@foreach`, le dimensioni di larghezza e altezza vengono calcolate a runtime sui campi `long_size` e `short_size`:
- Se `long_size >= short_size` (orientamento landscape/orizzontale), la larghezza corrisponde a `long_size` e l'altezza a `short_size`.
- In caso contrario (orientamento portrait/verticale), i valori vengono invertiti.

- **Gestione UI e Feedback:**
- Gestione e visualizzazione dei messaggi di successo da sessione (`session('success')`) e dei messaggi di errore di validazione (`$errors->any()`).
- Gestione del caso *empty set* quando l'utente non ha ancora caricato alcun lavoro (`$userWorks->isEmpty()`).
- Link di navigazione nell'header verso la Dashboard utente e la pagina di aggiunta di un nuovo lavoro.

---

## 🗄️ Modifiche al Database

nessuna modifica al database. Nota

- [x] Tabella `user_works` già esistente ed associata al modello `App\Models\UserWork`.
- [x] Campi impiegati nel componente: `id`, `user_id`, `title_en`, `long_size`, `short_size`, `updated_at`.

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

---

## 🚀 Note per il Deploy

- Nessuna migration aggiuntiva richiesta per questa vista.
- Assicurarsi che le route `user.dashboard` e `user.work.add` siano correttamente registrate e gestite nei file di routing.
