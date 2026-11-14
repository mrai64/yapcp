---
title: 'Feature: Avviso db manager down'
---

# Feature: Avviso server DB spento

> **Branch:** `feat/0430-warn-db-down`  
> **Stato:** Revisione  
> **priorità:** B  
> **id assegnato:** 2026-11-14.01  
> **Titolo e urgenza:** (B) feat: funzione di avviso "server DB spento"  
> **Project/issue link:** [#430](https://github.com/mrai64/yapcp/issues/430)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
  - [1. Contesto e Motivazione (Confronto con `main-2026`)](#1-contesto-e-motivazione-confronto-con-main-2026)
  - [2. Configurazione del Bootstrap e Gestione Eccezioni (`bootstrap/app.php`)](#2-configurazione-del-bootstrap-e-gestione-eccezioni-bootstrapappphp)
  - [3. Interfaccia Utente e Vista di Errore (`db-offline.blade.php`)](#3-interfaccia-utente-e-vista-di-errore-db-offlinebladephp)
  - [4. Risoluzione del Path della Vista ed Evidenze di Integrazione](#4-risoluzione-del-path-della-vista-ed-evidenze-di-integrazione)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Quando l'applicazione viene avviata in ambiente locale (es. Laravel Herd su macOS o container) o in produzione senza che il demone del database (MySQL) sia attivo o raggiungibile, l'utente o lo sviluppatore si trova di fronte a un errore fatale non gestito. Questa funzionalità introduce un'intercettazione mirata a livello di bootstrap per restituire una pagina informativa dedicata con status HTTP 500, spiegando con chiarezza la natura del problema e invitando ad avviare il servizio del database.

---

### 1. Contesto e Motivazione (Confronto con `main-2026`)

Nel branch di default `main-2026`:

- **Gestione eccezioni non configurata:** La configurazione di bootstrap in `bootstrap/app.php` lascia vuota la sezione `->withExceptions(...)`:

  ```php
  ->withExceptions(function (Exceptions $exceptions): void {
      //
  })->create();
  ```

- **Fallimento immediato a livello middleware per le sessioni:** L'applicazione utilizza il driver database per le sessioni (`SESSION_DRIVER=database` / `DatabaseSessionHandler`). All'arrivo di qualsiasi richiesta HTTP, il middleware globale `StartSession` tenta immediatamente di interrogare la tabella `sessions` via query SQL prima ancora di raggiungere routing o controller.
- **Comportamento in caso di MySQL spento:** Se MySQL non è avviato o rifiuta la connessione sulla porta 3306, viene generata un'eccezione non intercettata `Illuminate\Database\QueryException` (o `PDOException`) con codice `2002` (*Connection refused* / `SQLSTATE[HY000] [2002]`). In modalità debug viene esposto l'intero stack trace di Ignition/Laravel, mentre in produzione viene mostrata una pagina generica 500 priva di indicazioni operative.

Nel branch `feat/0430-warn-db-down`:

- **Intercettazione globale precoce:** Viene registrato un handler personalizzato tramite `$exceptions->render()` in `bootstrap/app.php` per catturare specificamente le `QueryException` dovute a mancata connessione al database.
- **Risposta HTTP controllata:** Viene restituita una vista Blade dedicata (`errors.db-offline`) con codice di stato HTTP 500, coerente con lo stile grafico e i componenti dell'applicazione.
- **Messaggio chiaro e orientato all'azione:** L'interfaccia segnala esplicitamente che il gestore del database è inattivo (*"The archive / data base manager is down"*) e consiglia di avviarlo per procedere (*"Start it, or solve the problem, then restart"*).

---

### 2. Configurazione del Bootstrap e Gestione Eccezioni (`bootstrap/app.php`)

Nel file `bootstrap/app.php` sono state introdotte le seguenti modifiche:

1. **Import delle classi necessarie:**

   ```php
   use Illuminate\Database\QueryException;
   use Illuminate\Http\Request;
   ```

2. **Registrazione del renderer di eccezione:**

   ```php
   ->withExceptions(function (Exceptions $exceptions): void {
       // added check for db offline
       $exceptions->render(function (QueryException $e, Request $request) {
           // connection refused
           if ($e->getCode() == 2002 || str_contains($e->getMessage(), 'Connection refused')) {
               return response()->view(
                   view: 'errors.db-offline',
                   data: [],
                   status: 500
               );
           }
       });
   })->create();
   ```

- **Criterio di filtro:** L'eccezione viene intercettata controllando sia il codice numerico `$e->getCode() == 2002` (codice standard MySQL per mancata connessione socket o TCP) sia la presenza della stringa `'Connection refused'` nel messaggio d'errore.
- **Ritorno controllato:** Anziché interrompere l'esecuzione con una schermata d'errore grezza, viene restituito l'oggetto risposta `response()->view(...)` con status code 500.

---

### 3. Interfaccia Utente e Vista di Errore (`db-offline.blade.php`)

È stata predisposta la vista per visualizzare l'avviso di database offline:

- **Collocazione file:** `resources/views/livewire/errors/db-offline.blade.php` (strutturata come componente Volt single-file con classe anonima `new class extends Component`).
- **Asset e Font:**
  - Font Figtree e Yanone Kaffeesatz (classe `fyk`).
  - Integrazione bundle Vite `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- **Layout e Branding:**
  - Header applicativo con logo `<x-application-logo>` e nome applicazione `config('app.name')`.
  - Link rapido di ritorno alla dashboard: `<x-yapcp.header-link txt="Back to dashboard" url="{{ route('user.dashboard') }}" />`.
  - Box informativo in evidenza (`bg-white shadow-xl sm:rounded-lg p-6`):
    - Titolo di allerta (rosso): `{{ __('The archive / data base manager is down') }}`
    - Istruzione di risoluzione (blu): `{{ __("Start it, or solve the problem, then restart") }}`
  - Footer standard dell'applicazione: `<x-footer-app />`.

---

### 4. Risoluzione del Path della Vista ed Evidenze di Integrazione

- **Allineamento nome vista:** In `bootstrap/app.php` il renderer invoca `response()->view(view: 'errors.db-offline', ...)`. Affinché il View Factory di Laravel localizzi correttamente il template, la vista deve essere risolvibile come `errors.db-offline` (posizionata in `resources/views/errors/db-offline.blade.php`) oppure, se mantenuta sotto la cartella dei componenti Livewire, richiamata tramite `view: 'livewire.errors.db-offline'`.
- **Autonomia da query database:** La pagina di errore non esegue alcuna query Eloquent o session query per il rendering, evitando loop di eccezioni quando il database non è raggiungibile.

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database (nessuna migrazione o modifica a tabelle esistenti).

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
