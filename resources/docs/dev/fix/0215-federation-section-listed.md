# Fix: Federation Section List

> **Branch:** `fix/0215-federation-section-listed`  
> **Stato:** Revisione
> **priorità:** A  
> **id assegnato:** 2026-08-20.01  
> **Titolo e urgenza:** Quello riportato nel project, solo senza [id...]  
> **Project/issue link:** [#215](https://github.com/mrai64/yapcp/issues/215)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Problema: la lista delle FederationSection non effettuava distinzione tra utenti amministratori e utenti normali, esponendo i link di azione (Aggiungi / Modifica / Rimuovi) a tutti gli utenti.

Analisi: la vista è stata riscritta in questa branch per adottare un componente Livewire class-based che espone lo stato necessario alla view, inclusa la verifica del ruolo admin tramite `Auth::user()->isAdmin()`.

Intervento tecnico effettuato:
- Aggiornata la view `resources/views/livewire/federation-section/listed.blade.php` per usare un componente class-based Livewire (con `WithPagination`) che carica le sezioni ordinate per `code` nella proprietà `sectionSet`.
- Introduzione della proprietà `isAdmin` valorizzata in `mount()` con `Auth::user()->isAdmin()` e utilizzata nella blade per mostrare i link di azione solo agli amministratori:
  - Link "Add a Federation Section" nell'header.
  - Link inline "Update" e "Remove" per ogni sezione.
- Migliorata la resa delle informazioni di sezione: `code`, `name_en`, `synopsis`, `file_formats`, `min_works`, `max_works`, dimensioni massime (`short_size_max`, `long_size_max`) e flag booleani (`monochrome_required`, `raw_required`, `unique_prize`).
- Gestione dei messaggi di successo ed errori (session + $errors) già presente e mantenuta.

Motivazione: utilizzare il controllo `isAdmin` lato server nella view evita che utenti non autorizzati vedano collegamenti che non possono usare e mantiene la UI coerente con i permessi applicativi.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->

Nessuna modifica al database: nessuna migration, nessun cambiamento di schema o dati.

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->

- Nessuna migration da eseguire.
- Pulire le cache e le view compilate prima del deploy o direttamente dopo il deploy: `php artisan optimize:clear` (consigliato), `php artisan view:clear`.
- Assicurarsi che il metodo `isAdmin()` sia presente e funzionante sul model `User` in produzione (coerente con l'ambiente di sviluppo).
- Eseguire la suite di test: `php artisan test`.

