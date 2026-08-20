# Docs: Federation Update (Modifica Federazione)

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
  - **Gruppo Amministratori (`isAdmin == true` / policy `update`):**
    - Visualizzazione e modifica del modulo pre-popolato con i dati della federazione selezionata.
    - Link di navigazione rapida nell'header:
      - **"Back to User dashboard"** (`route('user.dashboard')`) per tornare alla dashboard utente.
      - **"Federation list"** (`route('federation.listed')`) per tornare all'elenco delle federazioni.

---

## 📝 Logica Tecnica

- **Componente Livewire Volt:** Implementato come Single File Component (SFC) anonimo in `resources/views/livewire/federation/remove.blade.php` (`new class extends Component`).
- **Inizializzazione dello Stato (`mount(Federation $federation)`):**
  - Riceve il modello `Federation` tramite Route Model Binding.
  - Assegna l'istanza `$this->federation = $federation`.
  - Inizializza tutte le proprietà pubbliche del componente estraendo i valori correnti del record per garantire il corretto two-way data binding con i controlli del modulo:
    - `$federationId`, `$federationCountryId`, `$federationNameEn`, `$federationWebsite`, `$federationContactInfo`, `$federationLocalLang`, `$federationNameLocal`, `$federationTimezoneId`.
- **Regole di Validazione (`rules()`):**
  - `federationId`: `['required', 'string', 'uppercase', 'min:2', 'max:10', Rule::unique(Federation::class, 'id')->whereNull('deleted_at')->ignore($this->federation->id)]` (controllo di univocità che ignora il record corrente e considera solo i record non soft-deleted).
  - `federationCountryId`: `required|string|uppercase|min:3|exists:countries,id` (esistenza verificata nella tabella `countries`).
  - `federationNameEn`: `required|string|min:3|max:255` (denominazione ufficiale internazionale).
  - `federationWebsite`: `string|active_url|max:255` (URL attivo e valido).
  - `federationContactInfo`: `required|string|max:2000` (indirizzo postale, contatti e riferimenti HQ).
  - `federationLocalLang`: `string|max:6` (codice ISO lingua locale).
  - `federationNameLocal`: `string|min:3|max:255` (denominazione in lingua locale).
  - `federationTimezoneId`: `required|exists:timezones,id` (fuso orario valido da tabella `timezones`).
- **Metodo di Salvataggio (`modifyFederation()`):**
  - Esegue la validazione dei dati con `$validated = $this->validate()`.
  - Mappa la chiave identificativa con `$validated['id'] = $validated['federationId']`.
  - Esegue l'aggiornamento/salvataggio del record nel database tramite `Federation::updateOrCreate(...)` utilizzando `id` come chiave di corrispondenza.
  - Esegue il redirect alla lista federazioni (`route('federation.listed')`) impostando il messaggio flash di sessione `success` con `__("Federation updated successfully")`.
- **Feedback Utente ed Error Handling:**
  - Messaggio flash di successo (`session('success')`).
  - Elenco riepilogativo di tutti gli errori di validazione riscontrati (`$errors->any()`).
  - Errori puntuali posizionati sotto ogni singolo campo (`<x-input-error>`).
- **Componenti Blade Riutilizzabili:**
  - `<x-select-country-app>` per la selezione guidata del paese con binding su `federationCountryId` e valore iniziale `:country_id="$federationCountryId"`.
  - `<x-select-timezone-app>` per la selezione del fuso orario di riferimento con binding su `federationTimezoneId` e valore iniziale `:country_id="$federationTimezoneId"`.
  - `<x-yapcp.header-link>` per i collegamenti standard nell'header.
  - `<x-input-label>`, `<x-text-input>`, `<x-input-error>`, `<x-button>`, `<x-footer-app>`.

---

## 🗄️ Campi del Modulo e Mappatura Database

Tutti i dati inseriti vengono persistiti nel modello `App\Models\Federation` (tabella `federations`).

| Campo UI | Proprietà Wire | Tipo / Regole Validazione | Colonna DB (`federations`) | Note / Descrizione |
| :--- | :--- | :--- | :--- | :--- |
| **Federation ID** | `federationId` | `required\|string\|uppercase\|min:2\|max:10\|unique:ignore(current)` | `id` (`char(10)` PK) | Codice acronimo univoco in maiuscolo (es. `FIAP`, `PSA`, `FAF:AND`) |
| **Country** | `federationCountryId` | `required\|string\|uppercase\|min:3\|exists:countries,id` | `country_id` (`char(3)` FK) | Codice ISO paese (es. `LUX`, `USA`, `ITA`) da `<x-select-country-app>` |
| **Federation Name, english** | `federationNameEn` | `required\|string\|min:3\|max:255` | `name_en` (`varchar(255)`) | Denominazione internazionale ufficiale in lingua inglese |
| **Official website** | `federationWebsite` | `string\|active_url\|max:255` | `website` (`varchar(255)`) | URL del sito ufficiale con verifica DNS/URL attiva |
| **Local lang code** | `federationLocalLang` | `string\|max:6` | `local_lang` (`varchar(6)`) | Codice lingua locale (es. `fr`, `it`, `ja`) |
| **Federation Name, local** | `federationNameLocal` | `string\|min:3\|max:255` | `name_local` (`varchar(255)`) | Nome della federazione nella lingua nazionale |
| **Timezone** | `federationTimezoneId` | `required\|exists:timezones,id` | `timezone_id` (`varchar(255)` FK) | Identificativo fuso orario (es. `Europe/Luxembourg`) da `<x-select-timezone-app>` |
| **Contact info, HQ postal address, english** | `federationContactInfo` | `required\|string\|max:2000` | `contact_info` (`text`) | Recapito postale della sede, contatti presidenziali e segreteria |

---

## 🗄️ Convenzione Codice Identificativo e Chiave Primaria

1. **Formato Codice:** Acronimo alfabetico sintetico in lettere maiuscole (es. `FIAP`, `PSA`, `GPU`).
2. **Risoluzione Omonimie / Conflitti:** Qualora due federazioni di paesi diversi condividano il medesimo acronimo (es. *FAF* per Federació Andorrana de Fotografia e *FAF* per Federación Argentina de Fotografía), si adotta la convenzione di inserire il suffisso del codice ISO paese a 3 caratteri separato da due punti (es. `FAF:AND` e `FAF:ARG`), anche questo in lettere maiuscole.
3. **Validazione di Univocità in Modifica:** La regola `Rule::unique(Federation::class, 'id')->whereNull('deleted_at')->ignore($this->federation->id)` garantisce che sia possibile mantenere invariato l'ID della federazione corrente senza incorrere in falsi positivi di unicità, bloccando al contempo collisioni con ID di altre federazioni.

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
[`tests/Feature/m003/i0186/FederationModifyTest.php`](/tests/Feature/m003/i0186/FederationModifyTest.php)

- [x] **Accesso Admin:** Accesso consentito HTTP 200 alla pagina di modifica (`route('federation.modify', $federation)`) per utente con ruolo amministratore.
- [x] **Blocco Utente Non Admin:** Accesso inibito con HTTP 403 Forbidden per utenti privi di privilegi amministrativi.
- [x] **Reindirizzamento Guest:** Reindirizzamento a `route('login')` per utenti non autenticati.
- [x] **Pre-popolamento Dati (`mount`):** Verifica del corretto popolamento iniziale dei campi con i dati della federazione.
- [x] **Aggiornamento Record Federazione (Happy Path):** Modifica e validazione dei campi tramite Volt SFC, redirect a `route('federation.listed')`, messaggio di successo in sessione e verifica della persistenza su DB (`federations`).
- [x] **Validazione Errori Campi Mancanti:** Verifica puntuale del fallimento della validazione per i campi obbligatori omessi (`federationId`, `federationCountryId`, `federationNameEn`, `federationContactInfo`, `federationTimezoneId`).
- [x] **Validazione Codice Paese Inesistente:** Segnalazione errore su `federationCountryId` (`exists:countries,id`).
- [x] **Validazione Timezone Inesistente:** Segnalazione errore su `federationTimezoneId` (`exists:timezones,id`).
- [x] **Validazione URL Sito Web Non Valido:** Segnalazione errore su `federationWebsite` (`active_url`).
- [x] **Validazione ID Federazione Duplicato:** Segnalazione errore per collisione su ID già appartenente ad un'altra federazione.

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test dedicati ed esistenti passano in verde (`php artisan test --compact tests/Feature/m003/i0186/FederationModifyTest.php`).
- [x] **Docs:** La scheda tecnica in `/resources/docs/dev/docs/0186-federation-update.md` è aggiornata, completa e verificata.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte.
- [x] **Cleanup:** Nessun `dd()`, `dump()` o log di debug residuo.
- [x] **Commit:** I messaggi dei commit sono chiari e conformi alle convenzioni di progetto.

---

## 🚀 Note per il Deploy

- Nessuna migrazione da eseguire.
- Nessun parametro `.env` aggiuntivo richiesto.
