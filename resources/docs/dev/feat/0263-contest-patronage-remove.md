# Feature: Rimozione Patrocinio Federazione al Concorso (ContestPatronage)

> **Branch:** `feat/0263-contest-patronage-remove`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-01.02  
> **Titolo e urgenza:** (A) feat: ContestPatronage / Remove - blade  
> **Project/issue link:** [#263](https://github.com/mrai64/yapcp/issues/263)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Questa funzionalità permette a un'organizzazione autorizzata di rimuovere in modo sicuro un patrocinio di una federazione fotografica (`ContestPatronage`) precedentemente assegnato a un concorso (`Contest`).

### Scelte di Design e Architettura

1. **Componente Livewire Volt (Single File Component):**
   - Implementato nel file view `resources/views/livewire/organization/design/contest-patronage/remove.blade.php`.
   - **Autorizzazione (`mount`):**
     All'inizializzazione del componente viene invocata la policy `$this->authorize('delete', [ContestPatronage::class, $contest_patronage])`.
     L'eliminazione è consentita agli amministratori di sistema (`isAdmin()`) oppure ai membri appartenenti all'organizzazione (`isMemberOfOrganization()`) proprietaria del concorso collegato.
   - **Binding e Inizializzazione:**
     Riceve il modello `ContestPatronage` tramite *route model binding*. Nel metodo `mount()` vengono collegate le istanze di `$this->contestPatronage`, del concorso associato `$this->contest = $contest_patronage->contest` e della relativa organizzazione `$this->organization = $this->contest->organization`.

2. **Azione di Rimozione (`removeContestPatronage`):**
   - Non sono richieste regole di validazione input (`rules() no`) trattandosi di una conferma di eliminazione diretta.
   - Esecuzione del Soft Delete tramite `$this->contestPatronage->delete()`.
   - Reindirizzamento alla vista `organization.design.contest-patronage.listed` passando l'istanza del concorso (`$this->contest`) e impostando il messaggio di successo in sessione flash (`with('success', ...)`).

3. **Interfaccia Utente e Misure di Sicurezza (Blade):**
   - Header con navigazione del concorso (`x-yapcp.organization.design.contest-nav` con tab `patronages` attivo) e percorsi rapidi verso Dashboard Utente, Dashboard Organizzazione e Elenco Patrocini.
   - Sezione visiva di avviso ad alto contrasto (testo rosso ed enfasi sui rischi) con il messaggio esplicito: *"Remove only if you ABSOLUTELY KNOW what are the consequences"*.
   - Scheda di riepilogo con i dati puntuali del record da eliminare: bandiera del paese (`flag_code`), ID federazione (`federation_id`), codice del patrocinio (`patronage_code`) e denominazione in lingua inglese della federazione (`name_en`).
   - Form di conferma esplicita con pulsante di invio *"LAST CALL. Are you SURE to delete that?"*.

---

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Utilizzo della tabella `contest_patronages` con supporto nativo al Soft Delete (`deleted_at`).
  - All'eliminazione, il record non viene cancellato fisicamente ma archiviato impostando la colonna timestamp `deleted_at`.
- [x] Nessuna modifica strutturale o nuova migration richiesta al database.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)
- [x] **Docs:** Il file in `/resources/docs/dev/feat/0263-contest-patronage-remove.md` è aggiornato
- [ ] **Manual:** Il manuale utente riflette la procedura di rimozione dei patrocini dal concorso
- [x] **Cleanup:** Nessun residuo di `dd()`, `dump()` o codice superfluo nel componente
- [x] **Commit:** I messaggi dei commit sono chiari e conformi agli standard di progetto

---

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Verificare che la rotta `organization.design.contest-patronage.remove` sia configurata correttamente con middleware `auth` e `verified`.
- Assicurarsi che le policy definite in `ContestPatronagePolicy` siano correttamente registrate.
