#  Docs: FederationSection Modify (Correzione di una Sezione o Tema)

> **Branch:** `docs/0192-federation-section-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-16.03  
> **Titolo e urgenza:** (A) docs: documentazione form di modifica ed editing per FederationSection  
> **Project/issue link:** [#192](https://github.com/mrai64/yapcp/issues/192)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 🌐 Rotta e Controllo Accessi

- **Rotta Livewire/Volt:** `federation-section.modify` (collegata al componente Volt/Livewire 4 `modify.blade.php`).
- **URL Pattern:** `/federation-section/{federation_section}/modify`
- **Middleware & Autorizzazioni:** Richiede utente autenticato ed autorizzato con ruolo **Administrator** (`auth`, `role:admin`).
  - Accesso inibito con errore **HTTP 403 Forbidden** per utenti sprovvisti di privilegi amministrativi.
  - Reindirizzamento automatico alla rotta `login` per utenti non autenticati (guest).


---

## 📝 Logica Tecnica

- **Componente:** Livewire Volt SFC (`modify.blade.php`).
- **Inizializzazione (`mount`):** Riceve l'istanza del modello `FederationSection $federation_section` tramite Route Model Binding. Valorizza lo stato reattivo iniziale del componente con i dati correnti memorizzati su DB (`federation`, `code`, `name_en`, `synopsis`, limiti numerici e flag booleani).
- **Regole di Validazione (`rules`):**
  - `code`: `required|string|uppercase|min:2|max:10` (visualizzato in sola lettura nella vista).
  - `name_en`: `required|string|min:3|max:255`
  - `synopsis`: `required|string`
  - `min_works`: `required|integer|min:0|max:20`
  - `max_works`: `required|integer|min:1|max:20`
  - `short_size_max`: `required|integer|min:1080|max:2500` (espresso in px)
  - `long_size_max`: `required|integer|min:1080|max:4000` (espresso in px)
  - `file_size_max`: `required|integer|min:100000|max:6000000` (espresso in Bytes)
  - `monochromatic_required`, `raw_required`, `unique_prize`: `boolean`
- **Azione di Salvataggio (`modifyFederationSection`):** Esegue la validazione dei dati inviati, aggiorna il record del modello `FederationSection` impostando anche `local_lang => 'en'`, `local_name => name_en` e `file_formats => 'jpg'`. Effettua il redirect alla rotta `federation-section.listed` passando il parametro `federation` e inviando un messaggio di successo (`with('success', ...)`).


---

## 🗄️ Campi del Modulo e Mappatura Database

## 🗄️ Campi del Modulo e Mappatura Database

| Campo Form (Blade/Volt) | Colonna Database (`federation_sections`) | Tipo DB / Cast | Regole di Validazione & Note |
| :--- | :--- | :--- | :--- |
| `$code` | `code` | `string` | Codice univoco visualizzato in sola lettura (`required\|string\|uppercase\|min:2\|max:10`) |
| `$name_en` | `name_en` / `name_local` | `string` | `required\|string\|min:3\|max:255` |
| `$synopsis` | `synopsis` | `string` (text) | `required\|string` |
| `$min_works` | `min_works` | `int` | `required\|integer\|min:0\|max:20` |
| `$max_works` | `max_works` | `int` | `required\|integer\|min:1\|max:20` |
| `$short_size_max` | `short_size_max` | `int` | `required\|integer\|min:1080\|max:2500` (px) |
| `$long_size_max` | `long_size_max` | `int` | `required\|integer\|min:1080\|max:4000` (px) |
| `$file_size_max` | `file_size_max` | `int` | `required\|integer\|min:100000\|max:6000000` (Bytes) |
| `$monochromatic_required` | `monochromatic_required` | `int` (boolean) | `boolean` (0 = falso, 1 = true) |
| `$raw_required` | `raw_required` | `int` (boolean) | `boolean` (0 = falso, 1 = true) |
| `$unique_prize` | `unique_prize` | `int` (boolean) | `boolean` (0 = falso, 1 = true) |
| *Auto-set* | `local_lang` | `string` | Impostato a `'en'` durante l'update |
| *Auto-set* | `file_formats` | `string` | Impostato a `'jpg'` durante l'update |

---

## 🗄️ Modifiche al Database


- Nessuna nuova migrazione richiesta: le colonne utilizzate sono già definite e gestite nella tabella `federation_sections`.

---

## 🔎 Test

La funzionalità è coperta dai test Pest nel file dedicato:  
[`tests/Feature/m003/i0192/FederationSectionModifyTest.php`](/tests/Feature/m003/i0192/FederationSectionModifyTest.php)

- [x] **Accesso Admin:** Accesso consentito HTTP 200 alla pagina di censimento (`route('federation-section.add')`) per utente con ruolo amministratore.
- [x] **Blocco Utente Non Admin:** Accesso inibito con HTTP 403 Forbidden per utenti privi di privilegi amministrativi.
- [x] **Reindirizzamento Guest:** Reindirizzamento a `route('login')` per utenti non autenticati.
- [x] **Inserimento Record Federazione:** Inserimento e validazione dei campi tramite Volt SFC, redirect a `route('federation-section.listed')` e verifica della persistenza su DB (`federation_sections`).
- [x] **Validazione Errori Campi Mancanti:** Verifica puntuale del fallimento della validazione con segnalazione degli errori per i campi obbligatori omessi (`federationId`, `federationCountryId`, `federationNameEn`, `federationContactInfo`, `federationTimezoneId`).

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test dedicati ed esistenti passano in verde (`php artisan test`).
- [x] **Docs:** La scheda tecnica in `/resources/docs/dev/docs/0192-federation-section-update.md` è aggiornata, completa e verificata.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte.
- [x] **Cleanup:** Nessun `dd()`, `dump()` o log di debug residuo.
- [x] **Commit:** I messaggi dei commit sono chiari e conformi alle convenzioni di progetto.

---

## 🚀 Note per il Deploy

- Nessuna migrazione da eseguire.
- Nessun parametro `.env` aggiuntivo richiesto.
