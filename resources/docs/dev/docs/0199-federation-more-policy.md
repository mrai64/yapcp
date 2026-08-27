# Docs: FederationMore Policies (permessi d'azione sui Campi aggiuntivi delle Federazioni)

> **Branch:** `docs/0199-federation-more-policy`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-16.10  
> **Titolo e urgenza:** (A) docs: documentazione matrice di sicurezza UI e gestione accessi negati per FederationMore  
> **Project/issue link:** [#199](https://github.com/mrai64/yapcp/issues/199)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

Questa scheda tecnica descrive l'entità **FederationMore**, il modello di riferimento, la gestione delle rotte e i componenti Livewire Volt associati per la gestione dei campi aggiuntivi personalizzati richiesti dalle federazioni.

---

## 1. Panoramica del Modello (`App\Models\FederationMore`)

L'entità `FederationMore` gestisce i campi "custom" (One More Field) che le federazioni possono richiedere in aggiunta ai dati standard (es. tessere FIAP, PSA, IAAP).

### Proprietà del Modello e Schema DB

- **Tabella di riferimento**: `federation_mores`
- **Soft Deletes**: Abilitato (`use SoftDeletes;`)
- **Factory**: Abilitato (`use HasFactory;`)

| Campo | Tipo | Descrizione / Cast |
| :--- | :--- | :--- |
| `id` | `bigint unsigned` | PK standard autoincrementale. |
| `federation_id` | `string` | FK verso la tabella `federations.id`. |
| `referenced` | `string` | FK verso `federation_mores_referenced_sets.id` (tabella di destinazione del dato). |
| `field_name` | `string` | Nome univoco del campo in codice/software (es. camelCase, max 20 caratteri). |
| `field_label` | `string` | Etichetta visibile del campo nei form frontend (max 255 caratteri). |
| `field_validation_rules` | `string` | Regole di validazione Laravel applicate al campo (max 255 caratteri). |
| `field_default_value` | `string` | Valore di default utilizzato se non fornito (max 255 caratteri). |
| `field_suggest` | `string` | Testo esplicativo o suggerimento per la compilazione (max 255 caratteri). |
| `created_at` | `datetime` | Data e ora di creazione del record. |
| `updated_at` | `datetime` | Data e ora di ultimo aggiornamento del record. |
| `deleted_at` | `datetime` | Data e ora di soft delete (nullable). |

---

## 2. Relazioni Eloquent

- **`federation()`**: `BelongsTo` ➔ `App\Models\Federation`
  - Chiave esterna: `federation_id`, Chiave primaria locale: `id`.
- **`userMores()`**: `HasMany` ➔ `App\Models\UserContactMore`
  - Chiave esterna: `federation_id`, Chiave locale: `federation_id`.
- **`federationMoresReferenced()`**: `BelongsTo` ➔ `App\Models\FederationMoresReferencedSet`
  - Chiave esterna: `referenced`, Chiave proprietaria: `id`.

---

## 3. Metodi Principali del Modello

- **`isInUse(): bool`**
  Verifica dinamica se il campo personalizzato è attualmente presente ed in uso all'interno delle tabelle di riferimento registrate in `FederationMoresReferencedSet`.

---

## 4. Architettura Rotte (`routes/web.php`)

Tutte le rotte legate all'entità `FederationMore` utilizzano **Livewire Volt SFC (Single File Components)** e richiedono l'autenticazione ed l'account verificato (`middleware(['auth', 'verified'])`). Le operazioni di scrittura (Add, Modify, Delete) sono protette tramite Policy con il Gate `can:action,federation_more`.

| Azione | Metodo / URL | Componente Volt | Middleware / Authorization | Nome Rotta |
| :--- | :--- | :--- | :--- | :--- |
| **Listed** | `GET /federation-more/listed/{federation}` | `federation-more.listed` | `['auth', 'verified']` | `federation-more.listed` |
| **Add** | `GET /federation-more/add/{federation}` | `federation-more.add` | `['auth', 'verified', 'can:create,App\Models\FederationMore']` | `federation-more.add` |
| **Modify** | `GET /federation-more/modify/{federation_more}` | `federation-more.modify` | `['auth', 'verified', 'can:update,federation_more']` | `federation-more.modify` |
| **Remove** | `GET /federation-more/remove/{federation_more}` | `federation-more.remove` | `['auth', 'verified', 'can:delete,federation_more']` | `federation-more.remove` |

---

## 5. Componenti Volt (SFC) e Logica Operativa

### A. Listing Component (`federation-more.listed`)

- **Scopo**: Elenca tutti i campi aggiuntivi registrati per una determinata federazione.
- **Logica**:
  - Recupera i dati ordinando per `referenced` e `field_label`.
  - Mostra i dettagli tecnici per ciascun campo (`field_name`, `field_validation_rules`, `field_default_value`, `field_suggest`).
  - Se l'utente è amministratore (`isAdmin`), vengono mostrati i link diretti alle azioni di modifica ed eliminazione.

### B. Add Component (`federation-more.add`)

- **Scopo**: Creazione di un nuovo campo personalizzato per la federazione.
- **Validazione & Regole**:
  - `fedMoreReferencedId`: `required|string|exists:federation_mores_referenced_sets,id`
  - `fedMoreFieldName`: `required|string|max:20|unique:federation_mores,field_name`
  - `fedMoreFieldLabel`: `required|string|max:255`
  - `fedMoreValidationRules`: `required|string|max:255` (viene verificata preliminarmente con `Validator::make` per assicurare che la sintassi della regola Laravel sia valida).
  - `fedMoreDefaultValue`: `required|string|max:255`
  - `fedMoreSuggest`: `required|string|max:255`
- **Operazione DB**: Utilizza `FederationMore::withTrashed()->updateOrCreate(...)` per evitare duplicazioni e consentire il ripristino di record eliminati tramite soft delete.

### C. Modify Component (`federation-more.modify`)

- **Scopo**: Modifica delle impostazioni di un campo esistente (`field_label`, `field_validation_rules`, `field_default_value`, `field_suggest`, `referenced`).
- **Vincoli**: Il nome interno del campo (`field_name`) **non è modificabile** dopo la creazione per garantire la stabilità e l'integrità del software.

### D. Remove Component (`federation-more.remove`)

- **Scopo**: Conferma ed esecuzione della cancellazione di un campo (`SoftDelete`).
- **Operazione**: Richiama il metodo `$fedMore->delete()` trasmettendo un avviso di sicurezza prima della cancellazione definitiva.
