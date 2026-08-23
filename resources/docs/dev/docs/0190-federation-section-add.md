#  Docs: FederationSection Add (Censimento di una nuova Sezione o Tema)

> **Branch:** `docs/0190-federation-section-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-15.01  
> **Titolo e urgenza:** (A) docs: documentazione form di inserimento e validazione per Federation (admin group)  
> **Project/issue link:** [#185](https://github.com/mrai64/yapcp/issues/185)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 🌐 Rotta e Controllo Accessi

- **Endpoint / URL:** `<https://yapcp.test/federation-section/add>`
- **Nome Rotta:** `route('federation-section.add')`
- **Middleware:** `auth`, `verified`, `can:create,App\Models\FederationSection` (accesso riservato esclusivamente agli amministratori autorizzati; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
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
      - **"Federation Section List"** (`route('federation-section.listed')`) per tornare all'elenco delle sezioni della federazione.

---

## 📝 Logica Tecnica

L'interfaccia si basa su un componente Livewire (Volt SFC). All'atto del mount viene caricata l'istanza della federazione di riferimento (`Federation $federation`).
I campi vengono inizializzati con valori di default o stringhe vuote. Durante la sottomissione del modulo (`saveNewFederationSection`), i dati vengono validati secondo le regole specificate ed elaborati tramite `FederationSection::updateOrCreate`.
Al completamento del salvataggio, l'utente viene reindirizzato alla rotta `federation-section.listed` con un messaggio flash di successo.

---

## 🗄️ Campi del Modulo e Mappatura Database

Tutti i dati inseriti vengono persistiti nel modello `App\Models\FederationSection` (tabella `federation_sections`).

| Campo UI | Proprietà Wire | Tipo / Regole Validazione | Colonna DB (`federation_sections`) | Note / Descrizione |
| :--- | :--- | :--- | :--- | :--- |
| **Section Id, Code** | `code` | `required\|string\|uppercase\|min:2\|max:10` | `code` (`varchar(10)`) | Codice identificativo della sezione della federazione (es. `CL`, `TRAD`). |
| **Section name** | `name_en` | `required\|string\|min:3\|max:255` | `name_en` (`varchar(255)`) | Nome ufficiale in lingua inglese della sezione. |
| **Section definition, Synopsis** | `synopsis` | `required\|string` | `synopsis` (`text`) | Descrizione / sintesi della sezione tratta dai documenti ufficiali. |
| **Minimum works number for Section - from 0 to 20** | `min_works` | `required\|integer\|min:0\|max:20` | `min_works` (`unsigned int`) | Numero minimo di opere richieste/ammesse (0 per standard, >0 per portfolio). |
| **Maximum works number for Section - from 1 to 20** | `max_works` | `required\|integer\|min:1\|max:20` | `max_works` (`unsigned int`) | Numero massimo di opere ammesse per autore per sezione. |
| **Max size for shortest side - px** | `short_size_max` | `required\|integer\|min:1080\|max:2500` | `short_size_max` (`unsigned int`) | Dimensione massima consentita per il lato corto dell'immagine in pixel. |
| **Max size for longest side - px** | `long_size_max` | `required\|integer\|min:1080\|max:4000` | `long_size_max` (`unsigned int`) | Dimensione massima consentita per il lato lungo dell'immagine in pixel. |
| **Max size for file size - B** | `file_size_max` | `required\|integer\|min:100000\|max:6000000` | `file_size_max` (`unsigned int`) | Dimensione massima consentita per il file espressa in Byte (es. 100KB - 6MB). |
| **Exclusively monochromatic images** | `monochromatic_required` | `boolean:strict` | `monochromatic_required` (`tinyint(1)`) | Flag (On/Off) che definisce l'obbligo di immagini esclusivamente monocromatiche. |
| **Original RAW should be required** | `raw_required` | `boolean:strict` | `raw_required` (`tinyint(1)`) | Flag (On/Off) che definisce l'eventuale richiesta obbligatoria del file RAW originale. |
| **One prize only, per author per section** | `unique_prize` | `boolean:strict` | `unique_prize` (`tinyint(1)`) | Flag (On/Off) che stabilisce il limite di un solo premio per autore per sezione. |

*Nota: Durante il salvataggio vengono impostati di default anche i campi `local_lang` = `'en'`, `local_name` = `$name_en` e `file_formats` = `'jpg'`.*

---

## 🗄️ Convenzione Codice Identificativo e Chiave Primaria

1. **Formato Codice:** Acronimo alfabetico sintetico in lettere maiuscole (es. `BN`, `CL`, `NA`).
2. **Validazione di Univocità:** Non è consentito inserire per ciascuna Federazione due o più sezioni con lo stesso codice, in caso di variazioni estendere la codifica con un suffisso, es. CL per tema libero colore, CL:TRAD per Tema libero colore su fotografia tradizionale

## 🗄️ Modifiche al Database

Nessuna modifica strutturale alla base dati.

- [x] Tabella `federations` e modello `App\Models\Federation` già esistenti.
- [x] Chiave primaria non auto-incrementale `id` di tipo stringa (`char(10)`).
- [x] Vincoli di chiave esterna attivi verso `countries.id` e `timezones.id`.
- [x] Nessuna nuova migrazione richiesta.

---

## 🔎 Test

La funzionalità è coperta dai test Pest nel file dedicato:  
[`tests/Feature/m003/i0190/FederationSectionAddTest.php`](/tests/Feature/m003/i0190/FederationSectionAddTest.php)

- [x] **Accesso Admin:** Accesso consentito HTTP 200 alla pagina di censimento (`route('federation-section.add')`) per utente con ruolo amministratore.
- [x] **Blocco Utente Non Admin:** Accesso inibito con HTTP 403 Forbidden per utenti privi di privilegi amministrativi.
- [x] **Reindirizzamento Guest:** Reindirizzamento a `route('login')` per utenti non autenticati.
- [x] **Inserimento Record Federazione:** Inserimento e validazione dei campi tramite Volt SFC, redirect a `route('federation-section.listed')` e verifica della persistenza su DB (`federation_sections`).
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
