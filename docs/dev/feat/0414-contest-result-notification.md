---
title: 'Feature: Notifica risultati concorso per email'
---

# Feature: Notifica risultati concorso per email

> **Branch:** `feat/0414-contest-result-notification`  
> **Stato:** Revisione  
> **priorità:** A  
> **id assegnato:** 2026-11-03.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Manage / Result Notification  
> **Project/issue link:** [#414](https://github.com/mrai64/yapcp/issues/414)  
> **Milestone link:** [M6](https://github.com/mrai64/yapcp/milestones/6)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Al termine delle votazioni e delle deliberazioni della giuria, ogni partecipante al concorso deve poter ricevere un resoconto individuale contenente l'esito dei lavori presentati (opere ammesse e non ammesse) e l'invito formale alla cerimonia di premiazione. L'intero flusso di notifica dei risultati è stato progettato e implementato ex novo con un'architettura asincrona, scalabile e resiliente.

---

### 1. Motivazione ed Evoluzione Architetturale (Confronto con `refactor/0140-big-rebuild`)

Nel branch precedente `refactor/0140-big-rebuild`:

- **Assenza di notifica esiti:** Non esisteva alcun meccanismo automatizzato per notificare via email ai singoli concorrenti gli esiti della giuria relativi alle proprie opere.
- **Modello non notificabile:** Il modello `App\Models\UserContact`, che detiene i dati anagrafici e l'indirizzo email dei partecipanti/concorrenti, non implementava il trait `Notifiable` di Laravel né definiva un canale di instradamento mail, precludendo l'uso diretto del sistema nativo di notifiche (`$userContact->notify(...)`).
- **Nessuna gestione del flusso massivo e rischio rate limiting:** L'invio sincrono o seriale di email a centinaia di partecipanti per concorso avrebbe causato blocchi dell'interfaccia utente, timeout PHP e concreti rischi di rifiuto da parte dei server SMTP (throttling, blacklisting o superamento delle soglie consentite dal provider).
- **Assenza di trigger operativo:** Nella dashboard di giuria (`juror-board.blade.php`) e nella dashboard organizzativa non era presente alcun comando per autorizzare e avviare la rivelazione/comunicazione dei risultati post-giuria.

Nel branch `feat/0414-contest-result-notification`:

- **Architettura asincrona con Laravel Bus Batching:** L'organizzazione avvia l'invio tramite un unico click che genera un batch di job (`Bus::batch`), delegando l'elaborazione alla coda in background e fornendo immediato riscontro visivo all'utente senza bloccare l'interfaccia.
- **Rate Limiting dedicato su SMTP:** È stato introdotto in `AppServiceProvider` un rate limiter globale a **5 email/secondo**, applicato come middleware ai singoli job (`RateLimited('emails')`), garantendo una distribuzione controllata e sostenibile del traffico verso il server SMTP.
- **`UserContact` come entità `Notifiable`:** Il modello `UserContact` implementa nativamente `Notifiable` e definisce `routeNotificationForMail`, consentendo l'invio su entrambi i canali `mail` e `database`.
- **Query mirata e ordinata delle opere:** La notifica estrae le opere del singolo autore ordinate coerentemente per codice sezione e sequenza portfolio, prevenendo conflitti di id con `select('contest_works.*')`.
- **Template Markdown standardizzato:** L'email è renderizzata tramite componenti Markdown ufficiali di Laravel (`mail::message`, `mail::table`), includendo tabella riassuntiva con esito (`ADMIT` / `not admit`), messaggio di incoraggiamento e indicazioni dinamiche per la cerimonia di premiazione.

---

### 2. Dettaglio dei Componenti e Scelte Implementative

#### 2.1. Il Modello Destinatario: `App\Models\UserContact`

In yaPCP la persona fisica partecipante è rappresentata dal modello `UserContact`, collegato al concorso tramite `ContestParticipant` e alle opere tramite `ContestWork`.

- È stato aggiunto il trait `Illuminate\Notifications\Notifiable`:

  ```php
  use Illuminate\Notifications\Notifiable;

  class UserContact extends Model
  {
      use HasFactory;
      use HasUuids;
      use Notifiable;
      use SoftDeletes;
      ...
  ```

- È stato implementato il metodo di routing per il canale mail:

  ```php
  public function routeNotificationForMail($notification): mixed
  {
      return $this->email;
  }
  ```

- Sono stati aggiornati i PHPDoc del modello per includere `@property-read DatabaseNotificationCollection $notifications` e `notifications_count`.

Questa modifica consente di invocare direttamente `$userContact->notify(new JuryResultsNotification(...))` mantenendo pulita la separazione tra account di autenticazione (`User`) e profilo anagrafico di contatto (`UserContact`).

---

#### 2.2. Rate Limiting nel Service Provider (`App\Providers\AppServiceProvider`)

Per proteggere l'infrastruttura di posta e conformarsi ai limiti imposti dai server SMTP per l'invio di massa, in `AppServiceProvider::boot()` è stato registrato un limiter nominale:

```php
// limitazione delle email da spedire: 5 per ogni secondo
RateLimiter::for('emails', function (object $job) {
    return Limit::perSecond(5);
});
```

Il limite di 5 email/secondo garantisce un throughput regolare ed evita picchi di carico sia sul worker che sull'agente di trasporto SMTP.

---

#### 2.3. Job in Coda con Batching: `App\Jobs\SendJuryResultJob`

La classe `SendJuryResultJob` incapsula l'invio della notifica al singolo concorrente:

- **Interfacce e Trait:** implementa `ShouldQueue` e utilizza i trait `Dispatchable`, `InteractsWithQueue`, `Queueable`, `SerializesModels` e `Batchable`.
- **Dipendenze:** riceve nel costruttore `Contest $contest` e `UserContact $userContact`.
- **Middleware di Coda:** applica il limitatore di velocità tramite:

  ```php
  public function middleware(): array
  {
      return [new RateLimited('emails')];
  }
  ```

- **Controllo dello Stato del Batch:** prima di effettuare l'invio, verifica che il batch non sia stato cancellato (`if ($this->batch()->cancelled()) { return; }`), permettendo di abortire in sicurezza l'invio massivo in caso di emergenza.
- **Esecuzione (`handle`):** delega la notifica invocando:

  ```php
  $this->userContact->notify(new JuryResultsNotification($this->contest, $this->userContact));
  ```

---

#### 2.4. Notifica Risultati: `App\Notifications\JuryResultsNotification`

La classe `JuryResultsNotification` si occupa del recupero dei dati per lo specifico binomio (concorso, concorrente) e della composizione del messaggio:

- **Canali attivi (`via`):** restituisce `['mail', 'database']`.
- **Estrazione Dati (`toMail`):**
  - Recupera le opere del concorrente per il concorso eseguendo un'inner join con `contest_sections`:

    ```php
    $this->contestWorks = ContestWork::query()
        ->join('contest_sections', 'contest_works.section_id', '=', 'contest_sections.id')
        ->where('contest_works.contest_id', $this->contest->id)
        ->where('contest_works.user_id', $this->userContact->id)
        ->where('contest_sections.contest_id', $this->contest->id)
        ->orderBy('contest_sections.code')
        ->orderBy('contest_works.portfolio_sequence')
        ->select('contest_works.*')
        ->get();
    ```

  - L'uso di `select('contest_works.*')` evita collisioni di colonne (es. `id`, `created_at`) causate dalla join con `contest_sections`.
  - L'ordinamento prima per codice sezione (`contest_sections.code`) e poi per sequenza (`portfolio_sequence`) garantisce una consultazione coerente e leggibile.
- **Oggetto e Vista Markdown:**
  - Oggetto formattato: `[RESULTS] {Nome Concorso in Inglese}`.
  - Template Markdown: `emails.contest-individual-result`, alimentato con `userContact`, `contest` e `contestWorks`.
- **Rappresentazione a Database (`toArray`):** memorizza `contest_id` e `user_contact_id` per consentire audit e consultazione futura dalla dashboard utente.

> [!NOTE]
> La notifica individuale ha lo scopo di comunicare gli esiti di ammissione/non ammissione (`is_admit`) e ringraziare per la partecipazione; l'assegnazione dei singoli premi speciali o di categoria fa capo al verbale ufficiale di giuria e alla cerimonia conclusiva.

---

#### 2.5. Template Email Markdown (`resources/views/emails/contest-individual-result.blade.php`)

Il template email sfrutta i componenti nativi `@component('mail::message')` e `@component('mail::table')`:

1. **Intestazione personalizzata:** Saluto al concorrente e menzione del concorso fotografico.
2. **Tabella Risultati:**
   - Colonne: `Section` (codice e nome sezione), `Work Title` (`userWork->title_en`), `Result` (`ADMIT` in caso di ammissione, `not admit` altrimenti).
   - In caso di assenza opere, mostra un messaggio di fallback.
3. **Messaggio di supporto e sportività:** Un testo empatico che sottolinea il valore della partecipazione e del miglioramento continuo oltre il singolo risultato della giuria.
4. **Informazioni Cerimonia:** Integrazione dinamica del testo configurato dagli organizzatori nel campo del concorso:

   ```blade
   {{ __("We invite you to participate at our award ceremony, here the infos: ")}}
   {{ $contest->award_ceremony_info }}
   ```

5. **Chiusura e Saluti:** Invito a confermare la presenza e firma formale del comitato organizzatore.

---

#### 2.6. Interfaccia e Trigger Livewire Volt (`juror-board.blade.php`)

Nel componente single-file Livewire Volt `resources/views/livewire/organization/contest-jury/juror-board.blade.php`:

- **Caricamento Partecipanti (`mount`):**

  ```php
  $this->participants = ContestParticipant::where('contest_id', $this->contest->id)->get();
  ```

- **Azione `revelationResults()`:**
  - Crea e avvia un batch Laravel vuoto:

    ```php
    $batch = Bus::batch([])->dispatch();
    ```

  - Itera sui partecipanti del concorso e, per ciascuno con record `userContact` associato, accoda un job:

    ```php
    foreach ($this->participants as $contestParticipant) {
        if ($contestParticipant->userContact) {
            $batch->add(new SendJuryResultJob($this->contest, $contestParticipant->userContact));
        }
    }
    ```

  - Invia un messaggio di feedback in sessione: `session()->flash('success', __("Started Job for Result Notification"));`.
- **Integrazione Grafica Blade:**
  - Aggiunta una nuova sezione **"After Jury"** con tabella dedicata e link inline:

    ```html
    <x-yapcp.inline-link 
        txt="Results NOTIFY" 
        url="#" 
        wire:click="revelationResults"
    />
    ```

  - Aggiunto blocco visuale per la notifica di successo `session('success')` ed elenco eventuali `$errors->any()`.
- **Riflesso nella UI di configurazione concorso (`modify-name.blade.php`):**
  - Aggiunto un testo di aiuto sotto il campo `contestAwardCeremonyInfo` per chiarire agli organizzatori che tale testo verrà inserito automaticamente nel corpo delle email di notifica dei risultati sotto la dicitura: *« We invite you to participate at our award ceremony »*.

---

### 3. Interventi Correlati e Fix Tecnici

Durante lo sviluppo della feature sono stati apportati i seguenti miglioramenti di coerenza:

1. **`app/Models/ContestWork.php`:** Corretto il metodo di relazione `country()` in cui la foreign key e la parent key erano invertite nel `belongsTo`:

   ```php
   // Da: belongsTo(Country::class, 'id', 'country_id')
   // A:  belongsTo(Country::class, 'country_id', 'id')
   ```

2. **`app/Notifications/ContestWarning.php`:** Rimosse le chiamate residue alla funzione di debug `ds()` per garantire conformità agli ambienti di staging e produzione.
3. **`app/Notifications/WorkUpdatedNotification.php`:** Integrato il titolo dell'opera aggiornata (`title_en`) nel testo del messaggio informativo.
4. **Localizzazione (`resources/lang/it.json`, `resources/lang/en.json`):** Censite le nuove etichette dell'interfaccia utente ("After Jury", "Results NOTIFY", "Started Job for Result Notification") e le frasi del template email.

---

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

> <!-- to avoid index in Larecipe -->
- Vengono utilizzate le tabelle preesistenti del framework `notifications` e `job_batches`.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy. Assicurarsi che i queue worker (`php artisan queue:work`) siano attivi e configurati per elaborare la coda dei job in batch.
