# Feature: FederationMore Add

> **Branch:** `feat/0232-federation-more-add`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-23.02  
> **Titolo e urgenza:** (A) feat: FederationMore / Add blade  
> **Project/issue link:** [#232](https://github.com/mrai64/yapcp/issues/232)
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/yapcp/dev/state-of-art)
- [template](/yapcp/dev/template)

---

## 📝 Logica Tecnica

La componente Livewire Volt gestisce l'inserimento di un nuovo campo dinamico personalizzato (`FederationMore`) legato a una specifica federazione (`Federation`). Tali campi estendono le informazioni utente (es. `user_contact_mores`) in base ai requisiti delle singole federazioni.

### Punti Chiave e Scelte Implementative:

1. **Gestione dei Permessi e Contesto:**
   - Il componente riceve un'istanza del model `Federation` tramite `mount()`.
   - Verifica se l'utente autenticato possiede i privilegi di amministratore (`$isAdmin`).

2. **Validazione della Regola di Validazione (Pre-Validation Check):**
   - Poiché l'amministratore inserisce manualmente una stringa di regole Laravel (es. `required|string|max:255`), un errore di sintassi potrebbe compromettere i moduli dinamici futuri.
   - Prima di eseguire `$this->validate()`, il metodo `addFederationMore()` effettua un test preventivo creando un'istanza fittizia di `Validator` (`Validator::make(['temporary_test' => 'test'], ['temporary_test' => $this->fedMoreValidationRules])`).
   - Se il motore di validazione di Laravel lancia un'eccezione `\InvalidArgumentException` (es. sintassi errata o regola inesistente), l'operazione viene bloccata e viene aggiunto un errore specifico per il campo `fedMoreValidationRules`.

3. **Validazione dei Dati del Form:**
   - I campi del form vengono validati tramite il metodo `rules()`:
     - `fedMoreReferencedId`: obbligatorio, deve esistere nella tabella `federation_mores_referenced_sets` (colonna `id`).
     - `fedMoreFieldName`: obbligatorio, stringa fino a 20 caratteri, univoco nella tabella `federation_mores` (colonna `field_name`).
     - `fedMoreFieldLabel`, `fedMoreValidationRules`, `fedMoreDefaultValue`, `fedMoreSuggest`: stringhe obbligatorie fino a 255 caratteri.

4. **Salvataggio / Ripristino del Record:**
   - Viene utilizzato `FederationMore::withTrashed()->updateOrCreate()` basato sulla chiave composita/logica `['referenced', 'federation_id', 'field_name']`.
   - In questo modo, se un campo precedentemente eliminato (soft-deleted) viene ricreato con lo stesso nome e riferimento, viene aggiornato e ripristinato anziché generare conflitti.

5. **Logging e Tracciamento:**
   - Ogni operazione traccia nei log di debug gli input ricevuti e l'azione svolta dall'utente amministratore con ID e nome (`Auth::user()`).

6. **Feedback e Reindirizzamento:**
   - A completamento positivo, l'utente viene reindirizzato alla rotta `federation-more.listed` relativa alla federazione corrente, con un messaggio di successo in sessione (`flash`).

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
Nessuna modifica al database, le tabelle `federation_mores` e
`federation_mores_referenced_sets` sono già censite e corrette.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
Niente di particolare.