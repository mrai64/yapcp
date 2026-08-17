# Docs: Federation Add (Censimento Nuova Federazione)

> **Branch:** `docs/0185-federation-create`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-15.01  
> **Titolo e urgenza:** (A) docs: documentazione form di inserimento e validazione per Federation (admin group)  
> **Project/issue link:** [#185](https://github.com/mrai64/yapcp/issues/185)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 🌐 Rotta e Controllo Accessi

- **Endpoint / URL:** `<https://yapcp.test/federation/add>`
- **Nome Rotta:** `route('federation.add')`
- **Middleware:** `auth`, `verified`, `can:create,App\Models\Federation` (accesso riservato esclusivamente agli amministratori autorizzati; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (non admin):**
    - Accesso inibito alla pagina (HTTP 403 Forbidden).
  - **Guest (non autenticato):**
    - Reindirizzamento alla pagina di login (`route('login')`).
  - **Gruppo Amministratori (`isAdmin == true` / policy `create`):**
    - Visualizzazione del modulo completo per il censimento di una nuova federazione.
    - Link di navigazione rapida nell'header:
      - **"Back to dashboard"** (`route('user.dashboard')`) per tornare alla dashboard utente.
      - **"Federation list"** (`route('federation.listed')`) per tornare all'elenco delle federazioni.

---

## 📝 Logica Tecnica

- **Componente Livewire Volt:** Implementato come Single File Component (SFC) anonimo in `resources/views/livewire/federation/add.blade.php` (`new class extends Component`).
- **Inizializzazione dello Stato (`mount()`):** Inizializza tutte le proprietà pubbliche del componente come stringhe vuote per garantire il corretto binding bidirezionale con i controlli input:
  - `$federationId`, `$federationCountryId`, `$federationNameEn`, `$federationWebsite`, `$federationContactInfo`, `$federationLocalLang`, `$federationNameLocal`, `$federationTimezoneId`.
- **Regole di Validazione (`rules()`):**
  - `federationId`: `required|string|uppercase|min:2|max:10|unique:federations,id` (univocità garantita sulla tabella `federations`).
  - `federationCountryId`: `required|string|uppercase|min:3|exists:countries,id` (esistenza verificata nella tabella `countries`).
  - `federationNameEn`: `required|string|min:3|max:255` (denominazione ufficiale internazionale).
  - `federationWebsite`: `string|active_url|max:255` (URL attivo e valido).
  - `federationContactInfo`: `required|string|max:2000` (indirizzo postale, contatti e riferimenti HQ).
  - `federationLocalLang`: `string|max:6` (codice ISO lingua locale).
  - `federationNameLocal`: `string|min:3|max:255` (denominazione in lingua locale).
  - `federationTimezoneId`: `required|exists:timezones,id` (fuso orario valido da tabella `timezones`).
- **Metodo di Salvataggio (`addFederation()`):**
  - Esegue la validazione dei dati con `$validated = $this->validate()`.
  - Inserisce o aggiorna il record nel database tramite `Federation::updateOrCreate(...)` utilizzando `id` come chiave di ricerca.
  - Esegue il redirect alla lista federazioni (`route('federation.listed')`) impostando il messaggio flash di sessione `success` con `__("New federations was added successfully")`.
- **Feedback Utente ed Error Handling:**
  - Messaggio flash di successo (`session('success')`).
  - Elenco riepilogativo di tutti gli errori di validazione riscontrati (`$errors->any()`).
  - Errori puntuali posizionati sotto ogni singolo campo (`<x-input-error>`).
- **Componenti Blade Riutilizzabili:**
  - `<x-select-country-app>` per la selezione guidata del paese con ricerca e visualizzazione bandiera/nome.
  - `<x-select-timezone-app>` per la selezione del fuso orario di riferimento.
  - `<x-yapcp.header-link>` per i collegamenti standard nell'header.
  - `<x-input-label>`, `<x-text-input>`, `<x-input-error>`, `<x-button>`, `<x-footer-app>`.

---

## 🗄️ Campi del Modulo e Mappatura Database

Tutti i dati inseriti vengono persistiti nel modello `App\Models\Federation` (tabella `federations`).

| Campo UI | Proprietà Wire | Tipo / Regole Validazione | Colonna DB (`federations`) | Note / Descrizione |
| :--- | :--- | :--- | :--- | :--- |
| **Federation ID** | `federationId` | `required\|string\|uppercase\|min:2\|max:10\|unique:federations,id` | `id` (`char(10)` PK) | Codice acronimo univoco in maiuscolo (es. `FIAP`, `PSA`, `FAF:AND`) |
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
3. **Validazione di Univocità:** La regola `unique:federations,id` impedisce la duplicazione di codici identificativi già censiti nel sistema.

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
[`tests/Feature/m003/i0185/FederationAddTest.php`](/tests/Feature/m003/i0185/FederationAddTest.php)

- [x] **Accesso Admin:** Accesso consentito HTTP 200 alla pagina di censimento (`route('federation.add')`) per utente con ruolo amministratore.
- [x] **Blocco Utente Non Admin:** Accesso inibito con HTTP 403 Forbidden per utenti privi di privilegi amministrativi.
- [x] **Reindirizzamento Guest:** Reindirizzamento a `route('login')` per utenti non autenticati.
- [x] **Inserimento Record Federazione:** Inserimento e validazione dei campi tramite Volt SFC, redirect a `route('federation.listed')` e verifica della persistenza su DB (`federations`).
- [x] **Validazione Errori Campi Mancanti:** Verifica puntuale del fallimento della validazione con segnalazione degli errori per i campi obbligatori omessi (`federationId`, `federationCountryId`, `federationNameEn`, `federationContactInfo`, `federationTimezoneId`).

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test dedicati ed esistenti passano in verde (`php artisan test`).
- [x] **Docs:** La scheda tecnica in `/resources/docs/dev/docs/0185-federation-add.md` è aggiornata, completa e verificata.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte.
- [x] **Cleanup:** Nessun `dd()`, `dump()` o log di debug residuo.
- [x] **Commit:** I messaggi dei commit sono chiari e conformi alle convenzioni di progetto.

---

## 🚀 Note per il Deploy

- Nessuna migrazione da eseguire.
- Nessun parametro `.env` aggiuntivo richiesto.
