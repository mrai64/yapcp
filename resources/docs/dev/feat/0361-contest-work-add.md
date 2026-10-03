# Feature: Aggiungere lavori partecipanti

> **Branch:** `feat/0361-contest-work-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-10-01.02  
> **Titolo e urgenza:** (A) User / ContestParticipate & ContestWork add  
> **Project/issue link:** [#361](https://github.com/mrai64/yapcp/issues/361)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Nel contesto della ristrutturazione generale avviata nel branch base `refactor/0140-big-rebuild`, la funzionalità di candidatura e gestione delle opere dei partecipanti a un concorso fotografico è stata completamente riscritta migrando dalla vecchia architettura Livewire a controller e viste separate verso i **Single-File Component di Livewire Volt**.

La logica si articola in tre componenti Volt interconnessi, affiancati da controlli di autorizzazione, validazione di conformità tecnica dell'opera e gestione del ciclo di vita con Soft Delete.

### 1. Componenti UI (Livewire Volt)

- **`user.contest.participate` (`resources/views/livewire/user/contest/participate.blade.php`):**
  - Rappresenta la pagina principale di partecipazione al concorso (rotta `/user/contest/participate/{contest}`).
  - **Autorizzazione d'accesso:** Nel metodo `mount()`, verifica tramite `$this->authorize('create', [ContestWork::class, $contest])` che il concorso sia aperto alle iscrizioni e che l'utente non sia un membro dell'organizzazione organizzatrice.
  - **Plance informative:** Espone nella testata sia la *Contest section plate* (riepilogo dei vincoli di ciascuna sezione: min/max opere, dimensioni massime pixel lato corto/lungo, obbligo monocromatico e disponibilità RAW) sia la *Your participation plate* (conteggio in tempo reale delle opere già iscritte rispetto al massimo consentito per sezione).
  - **Ripartizione delle opere:** Nel metodo `with()`, recupera le opere già candidate (`$contestWorks`) con eager loading (`userWork`, `section`) e, tramite `whereNotIn`, seleziona le opere ancora candidabili (`$availableUserWorks`) presenti nella galleria dell'autore, impedendo candidature duplicate della medesima opera nello stesso concorso.
  - **Tabelle interattive:**
    - *Your Submitted Works:* Elenca le opere iscritte con miniatura, metadati tecnici e pulsante di rimozione delegato al sub-componente `user.contest-work.remove`.
    - *Your Selectable Works:* Elenca le opere disponibili con form di associazione alla sezione e numero di portfolio delegato al sub-componente `user.contest-work.add`.

- **`user.contest-work.add` (`resources/views/livewire/user/contest-work/add.blade.php`):**
  - Sub-componente (form inline) per iscrivere una specifica opera (`UserWork`) a una sezione (`ContestSection`).
  - Riceve i dati di contesto tramite JSON (`dataJson`: `contestId`, `workId`, `contestSectionSet`).
  - **Validazione:** Valida `sectionId` e `userWorkId` sfruttando la regola personalizzata `ContestSectionRule` per accertare che l'opera rispetti i vincoli tecnici della sezione.
  - **Progressivo portfolio (`portfolio_sequence`):** Se impostato a `0`, viene calcolato in automatico determinando il numero di opere già caricate dall'utente in quella sezione incrementato di 1.
  - **Atomicità (`DB::transaction`):** Registra il partecipante (`ContestParticipant::firstOrCreate`) e crea il record `ContestWork` con stato iniziale `is_admit = false`, copia di estensione e paese d'origine.
  - Al salvataggio esegue il reindirizzamento alla schermata di partecipazione con flash message di successo (`Work added, Great!`).

- **`user.contest-work.remove` (`resources/views/livewire/user/contest-work/remove.blade.php`):**
  - Sub-componente inline per ritirare la partecipazione di un'opera dal concorso.
  - Esegue la soft-delete (`$this->contestWork->delete()`), mantenendo traccia dello storico sul database ma liberando lo slot per l'utente, e ricarica la pagina con messaggio di conferma (`Work Removed, Ok!`).

### 2. Modello Dati e Helper Temporali (`Contest.php`)

Nel model `App\Models\Contest` sono stati introdotti helper per verificare programmaticamente le finestre temporali del concorso:
- `isRegistrationOpen(?DateTimeImmutable $refDate = null): bool`: verifica che la data corrente (o di riferimento) sia compresa tra la data di apertura iscrizioni (`day_1_opening`) e la chiusura (`day_2_closing`).
- `isJuryWorking(?DateTimeInterface $refDate = null): bool`: verifica se il concorso si trova nella finestra operativa delle votazioni di giuria (tra `day_3_jury_opening` e `day_4_jury_closing`).

### 3. Policy di Sicurezza (`ContestWorkPolicy.php`)

Il metodo `create(User $user, ?Contest $contest = null): bool` in `ContestWorkPolicy` implementa le seguenti regole di business:
- Il concorso deve essere obbligatoriamente passato come parametro.
- Il concorso deve avere le iscrizioni aperte (`$contest->isRegistrationOpen()`).
- L'utente **non** deve appartenere all'organizzazione organizzatrice del concorso (`!$user->isMemberOfOrganization($contest->organization_id)`), scongiurando conflitti di interesse.

### 4. Regola di Validazione Tecnica (`ContestSectionRule.php`)

La validation rule `ContestSectionRule` controlla la compatibilità tra opera e sezione:
- Memorizza temporaneamente `sectionId` in sessione durante la validazione dell'attributo sezione.
- All'elaborazione di `userWorkId`, carica l'opera e la sezione verificando:
  - Lato lungo: `$userWork->long_size <= $section->long_size_max`.
  - Lato corto: `$userWork->short_size >= $section->short_size_max`.
  - Obbligo monocromatico: se richiesto dalla sezione, l'opera deve avere `$userWork->is_monochromatic == true`.
  - Obbligo file RAW: se richiesto dalla sezione, l'opera deve avere `$userWork->has_raw_file == true`.

### 5. Binding e Pulizia Legacy

- **`AppServiceProvider`:** Aggiunto il route model binding esplicito `Route::model('contest-work', ContestWork::class)` e la registrazione di `Gate::policy(ContestWork::class, ContestWorkPolicy::class)`.
- **`routes/web.php`:** Registrate le rotte Volt `user.contest.participate` e `user.contest-work.remove` protette dai middleware `['auth', 'verified']`.
- **Pulizia codice obsoleto:** Rimossi i vecchi controller `app/Livewire/Contest/Subscribe/` (`Subscribe.php`, `Add.php`, `Remove.php`), le relative viste in `resources/views/livewire/contest/subscribe/` e i file `.bak` residui (`Add.bak`, `Modify.bak`).
- **Modifiche a `UserWork`:** Rimossi campi duplicati in `$fillable` e uniformato il nome della relazione a `userWorkMores()` (`HasMany`).

---

## 🗄️ Modifiche al Database

Nessuna nuova migrazione necessaria al database.
La feature opera sulle tabelle già strutturate ed esistenti:
- `contest_works`: gestione dei record con soft-delete (`deleted_at`), chiave univoca composta `sequence_idx` (`user_id`, `contest_id`, `section_id`, `portfolio_sequence`, `user_work_id`, `deleted_at`) e foreign key associate.
- `contest_participants`: associazione univoca tra autore e concorso.

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Verificata esecuzione suite test (`php artisan test`). I test specifici e le policy implementate rispondono correttamente; le residue segnalazioni nella suite globale riguardano test di sezioni legacy (`ContestSectionAddTest`) in attesa del completamento del branch padre `refactor/0140-big-rebuild`.
- [x] **Docs:** Scheda tecnica in `/resources/docs/dev/feat/0361-contest-work-add.md` completata e allineata.
- [x] **Manual:** Manuale utente redatto in `resources/docs/1.0/users/contest_subscribe.md` e indicizzato in `resources/docs/1.0/index.md`, corredato dalle relative schermate grafiche esplicative (`/storage/app/public/docs/users/contest_subscribe_img*.png`).
- [x] **Cleanup:** Eliminati vecchi controller, viste e file `.bak` obsoleti (`app/Livewire/Contest/Subscribe/*`, `resources/views/livewire/contest/subscribe/*`). Rimossi richiami di debug (`ds()`).
- [x] **Commit:** Messaggi dei commit strutturati e conformi alle convenzioni semantiche del repository.

---

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o comando speciale richiesto al deploy.
I collegamenti simbolici allo storage pubblico (`php artisan storage:link`) garantiscono la fruizione delle immagini della documentazione utente.
