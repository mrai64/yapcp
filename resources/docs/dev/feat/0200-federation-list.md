# (A) feat: Lista Federazioni accessibile a tutti gli utenti

> **Branch:** `feat/0200-federation-list`  
> **Stato:** In Chiusura  
> **priorità:** A  
> **id assegnato:** 2026-08-16.11  
> **Titolo e urgenza:** (A) feat: Federation List is for all not only admin  
> **Project/issue link:** [#200](https://github.com/mrai64/yapcp/issues/200)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Si è resa necessaria la revisione della vista Livewire Volt `resources/views/livewire/federation/listed.blade.php`. Nelle versioni precedenti la consultazione era limitata agli amministratori; con questa modifica, la visualizzazione dell'elenco delle federazioni e delle relative sezioni è aperta a tutti gli utenti autenticati, mantenendo invece le azioni di gestione riservate al ruolo admin.

- **Componente Volt SFC:** Utilizzo di Livewire Volt in forma anonima (`new class extends Component`) con inclusione del trait `WithPagination`.
- **Iniezione Dati (`with()`):** Come da standard Volt per componenti paginati, viene utilizzato il metodo `with()` per fornire alla vista:
  - `isAdmin`: Booleano calcolato tramite `Auth::user()->isAdmin()`.
  - `allFederationsSet`: Query su `Federation::query()` con eager loading della relazione `country`, ordinamento alfabetico/geografico (`country_id asc`, `name_en asc`) e paginazione a 10 elementi (`paginate(10)`).
- **Visibilità Condizionale (Admin vs Utente Standard):**
  - **Tutti gli utenti autenticati:** Possono accedere a `/federation/listed` (`route('federation.listed')`), visualizzare l'elenco delle federazioni, consultare i dettagli (paese, sito web, contatti, timezone, lingua/nome locale) e accedere al link delle sezioni di federazione (`route('federation-section.listed')`).
  - **Utenti Amministratori (`isAdmin == true`):** Visualizzano in aggiunta i pulsanti e link di gestione:
    - *Add New Federation* nell'header (`route('federation.add')`).
    - *Update* per ciascuna federazione (`route('federation.modify')`).
    - *‼️ Remove ‼️* per ciascuna federazione (`route('federation.remove')`).
- **Gestione Empty State & Feedback:** Gestione del messaggio esplicativo quando non sono presenti federazioni a sistema (`$allFederationsSet->isEmpty()`), oltre alla gestione dei messaggi flash di successo e di errore.

---

## 🗄️ Modifiche al Database

Nessuna modifica strutturale al database.

- [x] Tabella `federations` e modello `App\Models\Federation` già esistenti e invariati.
- [x] Nessuna nuova migrazione richiesta.

---

## 🔎 Test

È stata implementata una suite completa di test Pest nel file dedicato:  
[`tests/Feature/m003/i0200/FederationListedTest.php`](/tests/Feature/m003/i0200/FederationListedTest.php)

### Casi di test verificati:

1. **Guest (Non autenticato):**
   - Reindirizzamento alla pagina di login (`route('login')`) al tentativo di accesso a `route('federation.listed')`.

2. **Utente Standard (`User::factory()->create()`):**
   - Accesso consentito alla route `federation.listed` (HTTP 200) e corretto caricamento del componente Volt.
   - Visibilità delle informazioni della federazione (nome, paese, sezioni federazione, link alla dashboard utente).
   - **Nessuna visibilità** dei controlli admin: pulsante *Add New Federation*, link *Update* (`federation.modify`) e link *‼️ Remove ‼️* (`federation.remove`).

3. **Utente Amministratore (`User::factory()->admin()->create()`):**
   - Accesso consentito alla route `federation.listed`.
   - **Piena visibilità dei controlli admin:** pulsante *Add New Federation*, link *Update* e link *‼️ Remove ‼️*.

4. **Stato Vuoto (Empty state):**
   - Visualizzazione del messaggio informativo quando la tabella federazioni è vuota.

5. **Dettagli Federazione:**
   - Corretto rendering dei campi informativi: flag/paese, codice ID, nome inglese, sito web, contatti, timezone, lingua e nome locale.

---

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test dedicati passano in verde (`php artisan test tests/Feature/m003/i0200/FederationListedTest.php`).
- [x] **Docs:** La scheda tecnica in `/resources/docs/dev/feat/0200-federation-list.md` è aggiornata e allineata.
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte.
- [x] **Cleanup:** Nessun `dd()`, `dump()` o log di debug residuo.
- [x] **Commit:** Messaggi di commit chiari e coerenti con le convenzioni del progetto.

---

## 🚀 Note per il Deploy

- Nessuna migrazione da eseguire.
- Nessuna variabile d'ambiente aggiuntiva richiesta nel file `.env`.
- Opzionale: pulizia cache viste e rotte (`php artisan optimize:clear`).
