# Docs: Federation Read (Lista Federazioni)

> **Branch:** `docs/0184-federation-read`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-16.02  
> **Titolo e urgenza:** (A) docs: Federation Read / Lista Federazioni per tutti gli utenti e controlli Admin  
> **Project/issue link:** [#184](https://github.com/mrai64/yapcp/issues/184)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 🌐 Rotta e Controllo Accessi

- **Endpoint / URL:** `<https://yapcp.test/federation/listed>`
- **Nome Rotta:** `route('federation.listed')`
- **Middleware:** `auth`, `verified` (accesso riservato agli utenti autenticati; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (tutti gli utenti autenticati):**
    - Consultazione dell'elenco completo delle federazioni e dei relativi dati informativi.
    - Accesso al link per consultare le sezioni e i temi definiti da ciascuna federazione (`route('federation-section.listed', ['federation' => $federation])`).
    - Link di navigazione per il ritorno alla Dashboard Utente (`route('user.dashboard')`).
  - **Gruppo Amministratori (`isAdmin == true`):**
    - Visualizzazione aggiuntiva nell'header del pulsante **"Add New Federation"** (`route('federation.add')`).
    - Per ciascuna scheda federazione, visualizzazione dei pulsanti di gestione:
      - Link **"Update"** per la modifica (`route('federation.modify', ['federation' => $federation])`).
      - Link **"‼️ Remove ‼️"** per la cancellazione (`route('federation.remove', ['federation' => $federation])`).

---

## 📝 Logica Tecnica

- **Componente Livewire Volt:** Implementato come Single File Component (SFC) anonimo in `resources/views/livewire/federation/listed.blade.php` (`new class extends Component`).
- **Trait di paginazione:** Include `Livewire\WithPagination`.
- **Iniezione Dati (`with()`):** Utilizza il metodo `with()` per passare alla vista:
  - `isAdmin`: Booleano calcolato con `Auth::user()->isAdmin()`.
  - `allFederationsSet`: Query Eloquent con eager loading `Federation::query()->with(['country'])->orderBy('country_id', 'asc')->orderBy('name_en', 'asc')->paginate(10)`.
- **Eager Loading:** Caricamento preventivo della relazione `country` per ottimizzare le prestazioni ed evitare query N+1 nel recupero di bandiera e nome del paese.
- **Empty State:** Se la tabella non contiene record (`$allFederationsSet->isEmpty()`), viene mostrato un messaggio informativo che invita a utilizzare *Federation*Seeker* o ad aggiungere manualmente la prima federazione.
- **Feedback Utente:** Gestione dei messaggi flash di successo (`session('success')`) ed eventuale visualizzazione degli errori di validazione (`$errors->any()`).

---

## 🗄️ Campi visualizzati a schermo e Provenienza Dati

Tutti i dati anagrafici e di contatto provengono dal modello `App\Models\Federation` (tabella `federations`) e dalla relazione `belongsTo` con `App\Models\Country` (tabella `countries`).

| Campo UI | Nome tecnico | Tipo / Destinazione | Fonte dati / Espressione Blade | Note |
| :--- | :--- | :--- | :--- | :--- |
| **Bandiera nazione** | `flag_code` | String (Unicode Emoji) | `$federation->country?->flag_code` | Emoji bandiera dalla tabella `countries` |
| **Nazione / Paese** | `country` | String | `$federation->country?->country` | Nome paese in inglese dalla tabella `countries` |
| **Codice Federazione** | `id` | String PK `char(10)` | `$federation->id` | Chiave primaria (es. `FIAP`, `PSA`, `GPU`, `FAF:AND`) |
| **Nome Internazionale** | `name_en` | String | `$federation->name_en` | Denominazione ufficiale in lingua inglese |
| **Sito Ufficiale** | `website` | String (URL) | `$federation->website` | Sito web o pagina ufficiale (fallback `'N/A'`) |
| **Informazioni di Contatto** | `contact_info` | Text | `$federation->contact_info` | Indirizzo sede, email, recapiti (fallback `'N/A'`) |
| **Fuso Orario** | `timezone_id` | String FK | `$federation->timezone_id` | Identificativo timezone PHP (FK su `timezones.id`, fallback `'N/A'`) |
| **Codice Lingua Locale** | `local_lang` | String `char(6)` | `$federation->local_lang` | Codice lingua ISO (es. `it`, `fr`, `ja`, usato in `lang="..."`) |
| **Nome Locale Federazione** | `name_local` | String | `$federation->name_local` | Nome nella lingua locale / nazionale (fallback `'N/A'`) |
| **Sezioni Federazione** | Link azione | URL (`federation-section.listed`) | `route('federation-section.listed', ['federation' => $federation])` | Link all'elenco sezioni e temi definiti (per tutti) |
| **[Admin] Aggiungi Federazione** | Link header | URL (`federation.add`) | `route('federation.add')` | Visibile solo se `isAdmin == true` |
| **[Admin] Modifica Federazione** | Link azione | URL (`federation.modify`) | `route('federation.modify', ['federation' => $federation])` | Visibile solo se `isAdmin == true` |
| **[Admin] Rimuovi Federazione** | Link azione | URL (`federation.remove`) | `route('federation.remove', ['federation' => $federation])` | Visibile solo se `isAdmin == true` |

---

## 🗄️ Logica di Ordinamento e Convenzione Chiavi

1. **Ordinamento:** I record vengono estratti e ordinati prioritariamente per codice nazione (`country_id ASC`), e successivamente per denominazione internazionale (`name_en ASC`).
2. **Paginazione:** 10 federazioni per pagina con navigazione standard Livewire.
3. **Gestione Chiave Univoca (`id`):** Il codice della federazione funge da chiave primaria (non auto-incrementale). Nel caso in cui due federazioni di paesi diversi condividano lo stesso acronimo (es. *FAF* per Andorra e *FAF* per Argentina), la convenzione stabilita prevede l'aggiunta a **suffisso** del codice nazione ISO a 3 caratteri separato da due punti (es. `FAF:AND` e `FAF:ARG`).

---

## 🗄️ Modifiche al Database

Nessuna modifica strutturale alla base dati.

- [x] Tabella `federations` e modello `App\Models\Federation` già esistenti.
- [x] Tabella `countries` e relazione `belongsTo` (`country_id` -> `countries.id`) già attive.
- [x] Nessuna nuova migrazione richiesta.

---

## 🔎 Test

La funzionalità è coperta dai test Pest nel file dedicato:  
[`tests/Feature/m003/i0200/FederationListedTest.php`](/tests/Feature/m003/i0200/FederationListedTest.php)

- [x] **Guest:** Reindirizzamento a login se non autenticati.
- [x] **Utente Standard:** Accesso consentito HTTP 200, visualizzazione dati, nessuna visibilità delle azioni admin (`Add`, `Update`, `Remove`).
- [x] **Admin:** Accesso consentito HTTP 200, visualizzazione dati e visibilità completa delle azioni admin (`Add`, `Update`, `Remove`).
- [x] **Empty State:** Verifica messaggio esplicativo in assenza di record.
- [x] **Dettagli Campi:** Rendering corretto di ID, bandiera, nome inglese, contatti, sito web, timezone e nome locale.

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test dedicati ed esistenti passano in verde (`php artisan test`).
- [x] **Docs:** La scheda tecnica in `/resources/docs/dev/docs/0184-federation-read.md` è aggiornata, completa e verificata.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte.
- [x] **Cleanup:** Nessun `dd()`, `dump()` o log di debug residuo.
- [x] **Commit:** I messaggi dei commit sono chiari e conformi alle convenzioni di progetto.

---

## 🚀 Note per il Deploy

- Nessuna migrazione da eseguire.
- Nessun parametro `.env` aggiuntivo richiesto.
