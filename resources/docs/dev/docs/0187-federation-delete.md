# Docs: Federation Remove (Cancellazione Federazione)

> **Branch:** `docs/0187-federation-delete`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-15.07  
> **Titolo e urgenza:** (A) docs: documentazione form di modifica e validazione per Federation (admin group)  
> **Project/issue link:** [#187](https://github.com/mrai64/yapcp/issues/187)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 🌐 Rotta e Controllo Accessi

- **Endpoint / URL:** `<https://yapcp.test/federation/remove/{federation}>`
- **Nome Rotta:** `route('federation.remove', ['federation' => $federation])`
- **Middleware:** `auth`, `verified`, `can:delete,federation` (accesso riservato esclusivamente agli amministratori autorizzati; policy `delete` in `App\Policies\FederationPolicy`; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (non admin):**
    - Accesso inibito alla pagina (HTTP 403 Forbidden).
  - **Guest (non autenticato):**
    - Reindirizzamento alla pagina di login (`route('login')`).
  - **Gruppo Amministratori (`isAdmin == true` / policy `delete`):**
    - Visualizzazione e richiesta conferma con i dati della federazione selezionata.
      Nel caso si arrivi comunque al link con concorsi attivi non viene presentato il pulsante di conferma ma un avviso.
    - Link di navigazione rapida nell'header:
      - **"Back to User dashboard"** (`route('user.dashboard')`) per tornare alla dashboard utente.
      - **"Federation list"** (`route('federation.listed')`) per tornare all'elenco delle federazioni.

---

## 📝 Logica Tecnica

- **Componente Livewire Volt:** Implementato come Single File Component (SFC) anonimo in `resources/views/livewire/federation/remove.blade.php` (`new class extends Component`).
- **Inizializzazione dello Stato (`mount(Federation $federation)`):**
  - Riceve il modello `Federation` tramite Route Model Binding.
  - Assegna l'istanza `$this->federation = $federation`.
  - Visualizza i dati della Federation per la conferma della cancellazione intenzionale del record:
    - `$federationId`, `$federationCountryId`, `$federationNameEn`, `$federationWebsite`, `$federationContactInfo`, `$federationLocalLang`, `$federationNameLocal`, `$federationTimezoneId`.
- **Feedback Utente ed Error Handling:**
  - Messaggio flash di successo (`session('success')`).
- **Componenti Blade Riutilizzabili:**
  - `<x-yapcp.header-link>` per i collegamenti standard nell'header.
  - `<x-button>`, `<x-footer-app>`.

---

## 🗄️ Modifiche al Database

Nessuna modifica strutturale alla base dati.

- [x] Tabella `federations` e modello `App\Models\Federation` già esistenti.
- [x] Chiave primaria non auto-incrementale `id` di tipo stringa (`char(10)`).
- [x] Vincoli di chiave esterna attivi verso `countries.id` e `timezones.id`.
- [x] Nessuna nuova migrazione richiesta.

---

## 🔎 Test

La funzionalità è coperta dai test Pest nel file dedicato:  
[`tests/Feature/m003/i0187/FederationDeleteTest.php`](/tests/Feature/m003/i0187/FederationDeleteTest.php)

- [x] **Accesso Admin:** Accesso consentito HTTP 200 alla pagina di modifica (`route('federation.remove', $federation)`) per utente con ruolo amministratore.
- [x] **Blocco Utente Non Admin:** Accesso inibito con HTTP 403 Forbidden per utenti privi di privilegi amministrativi.
- [x] **Reindirizzamento Guest:** Reindirizzamento a `route('login')` per utenti non autenticati.
- [x] **Aggiornamento Record Federazione (Happy Path):** Soft-delete tramite Volt SFC, redirect a `route('federation.listed')`, messaggio di successo in sessione.

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test dedicati ed esistenti passano in verde (`php artisan test --compact tests/Feature/m003/i0187/FederationDeleteTest.php`).
- [x] **Docs:** La scheda tecnica in `/resources/docs/dev/docs/0187-federation-delete.md` è aggiornata, completa e verificata.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte.
- [x] **Cleanup:** Nessun `dd()`, `dump()` o log di debug residuo.
- [x] **Commit:** I messaggi dei commit sono chiari e conformi alle convenzioni di progetto.

---

## 🚀 Note per il Deploy

- Nessuna migrazione da eseguire.
- Nessun parametro `.env` aggiuntivo richiesto.
