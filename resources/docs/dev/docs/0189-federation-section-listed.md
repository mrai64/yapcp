# docs: Federation Section Listed

> **Branch:** `docs/0189-federation-section-listed`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-16.01  
> **Titolo e urgenza:** (A) docs: documentazione vista di consultazione e navigazione per FederationSection  
> **Project/issue link:** [#189](https://github.com/mrai64/yapcp/issues/189)
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

---

## 📝 Logica Tecnica

La pagina di elenco delle sezioni e temi da concorso di una federazione (`federation-section.listed`) espone le sezioni e i temi con i codici previsti dalla federazione, o altrimenti assegnati dalla Piattaforma, permettendo agli utenti registrati di consultarle e agli amministratori di gestirle (aggiungere, modificare, rimuovere). La consultazione degli utenti può essere finalizzata a una successiva preparazione di concorso. O alla partecipazione consentendo di preparare versioni delle opere conformi ai controlli che saranno effettuati automaticamente nel caso di partecipazione a concorso.

**Componente Livewire class-based** (`resources/views/livewire/federation-section/listed.blade.php`):

- Carica tutte le `FederationSection` associate alla federazione selezionata, ordinate per `code`.
- Espone la proprietà `isAdmin` valorizzata in `mount()` tramite `Auth::user()->isAdmin()`.
- Nella view, il flag amministratore abilita i link di azione (Add, Update, Remove) solo per utenti admin.
- Mostra un messaggio amichevole se nessuna sezione è registrata per la federazione.

**Dati visualizzati per ogni sezione:**

- Codice e nome inglese (`code`, `name_en`)
- Descrizione breve (`synopsis`)
- Elenco dei formati file consentiti  - lista di estensioni file minuscole separate da virgole - (`file_formats`)
- Numero minimo/massimo di opere ammesse (`min_works`, `max_works`)
- Dimensioni massime in pixel per i lati corti e lunghi (`short_size_max`, `long_size_max`)
- Flag booleani:
  - `monochromatic_required` → Monocromatico richiesto
  - `raw_required` → RAW quando richiesto
  - `unique_prize` → Premi non cumulabili nella sezione

**Routing e Policy:**

- Route pubblica (autenticati): `/federation-section/listed/{federation}`
- Route admin (policy-protette):
  - `/federation-section/add/{federation}` → Aggiungi sezione
  - `/federation-section/modify/{federation_section}` → Modifica sezione
  - `/federation-section/remove/{federation_section}` → Rimuovi sezione

**Bug risolti durante lo sviluppo:**

1. **fix/0215**: La lista non distingueva tra utenti admin e normali → ora mostra i link di azione solo agli admin.
2. **fix/0217**: La lista mostrava tutte le sezioni di tutte le federazioni → ora filtra per `federation_id`.
3. **fix/0219**: Il flag `monochrome_required` era referenziato con nome errato (`monochrome_required` invece di `monochromatic_required`) → corretto.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Nessuna modifica al database (nessuna migration)
- [x] Utilizzo del modello `FederationSection` esistente
- [x] Utilizzo della relazione `federation_id` esistente

## 👮‍♂️ Pre Merge check

> <!-- to avoid index -->
- [x] **Test:** Nuovi test feature per listaggio (`tests/Feature/Admin/FederationSectionListTest.php`)?
- [x] **Docs:** File in `/resources/docs/dev/` aggiornati?
- [x] **Manual:** Manuali utente e admin redatti?
- [x] **Cleanup:** Rimossi `dd()` e `dump()`?
- [x] **Commit:** Messaggi dei commit chiari e coerenti?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna migration da eseguire.
- Pulire cache e view compilate: `php artisan optimize:clear` (consigliato) o `php artisan view:clear`.
- Assicurarsi che il metodo `isAdmin()` sia presente e funzionante sul model `User` in produzione.
- Eseguire la suite di test: `php artisan test`.
- Verificare il corretto caricamento della rotta `/federation-section/listed/{federation}` in ambiente di staging.
- Includere le nuove immagini di documentazione (6 PNG) nel deployment della cartella `/storage/app/public/docs/federation_sections/`.

## 📎 Link Correlati

- **Branch da mergare in:** `docs/0182-federation-section-all`
- **Branch correlate (sub-issue):**
  - `fix/0215-federation-section-listed` → Fix distinzione admin/user
  - `fix/0217-federation-section-listed` → Fix filtro per federazione
  - `fix/0219-federation-section-mono` → Fix nome campo monochromatic
- **Issue:** <https://github.com/mrai64/yapcp/issues/189>

author: copilot
review: mrai64
last update: 21 agosto 2026
