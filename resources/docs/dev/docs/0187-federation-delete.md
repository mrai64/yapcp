# Docs: Federation Delete (Rimozione Federazione)

> **Branch:** `docs/0187-federation-delete`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-15.07  
> **Titolo e urgenza:** (A) docs: documentazione per il form di rimozione Federation (admin group)  
> **Project/issue link:** [#187](https://github.com/mrai64/yapcp/issues/187)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

---

## 🌐 Rotta e Controllo Accessi

- **Endpoint / URL:** `<https://yapcp.test/federation/remove/{federation}>`
- **Nome Rotta (usata nella view):** `route('federation.remove', ['federation' => $federation])` (la view contiene anche un link verso `route('federation.list')`)
- **Middleware:** `auth`, `verified`, `can:delete,federation`
  - L'accesso alla pagina e all'azione di cancellazione è riservato esclusivamente agli amministratori autorizzati che soddisfano la policy `delete` in `App\Policies\FederationPolicy`.
- **Comportamento per ruoli:**
  - **Guest (non autenticato):** reindirizzamento alla pagina di login (`route('login')`).
  - **Utente non admin:** accesso inibito (HTTP 403 Forbidden) a causa della policy.
  - **Admin (isAdmin == true):** può visualizzare la pagina di conferma rimozione e confermare l'operazione.

---

## 📝 Componente Livewire (Interazione UI)

- **View Livewire SFC:** `resources/views/livewire/federation/remove.blade.php`
  - Implementata come una singola view blade per il componente Livewire (SFC anonimo: `new class extends Component`).
- **Binding e campi visibili (read-only):**
  - Campo nascosto: `id` bindato con `wire:model.fill="id"` (identificatore della federation).
  - Visualizzati in sola lettura: `name` (`wire:model.fill="name"`), `code` (`wire:model.fill="code"`), `website` (`wire:model.fill="website"`), `countryId` (`wire:model.fill="countryId"`), `contact` (`wire:model="contact"`).
  - Il modulo è un avviso di "LAST CALL" con informazioni riepilogative e richiesta di conferma.
- **Form:** `wire:submit="deleteFederation"` e metodo HTTP `DELETE` (CSRF presente). L'azione Livewire associata è `deleteFederation`.

---

## 🗄️ Logica Tecnica e Flusso di Rimozione

Basato sui file forniti (blade, model, policy) e sulle convenzioni del progetto:

- **Inizializzazione (`mount(Federation $federation)` - prevista nel componente Livewire):**
  - Riceve il modello `Federation` via Route Model Binding.
  - Popola le proprietà pubbliche del componente con i valori correnti del record per mostrare i dati in sola lettura.
    - Proprietà tipiche: `id`, `name`, `code`, `website`, `countryId`, `contact`.
- **Azione `deleteFederation()`:**
  - L'azione verifica implicitamente le autorizzazioni tramite il middleware `can:delete,federation` prima dell'accesso alla view; il componente dovrebbe eseguire ulteriore controllo (es. `Gate::authorize('delete', $this->federation)`) per sicurezza server-side.
  - L'operazione di rimozione utilizza il modello `App\Models\Federation` che include `SoftDeletes` — di conseguenza l'operazione prevista è una cancellazione soft (`$federation->delete()`), preservando il record in `deleted_at`.
  - Dopo la cancellazione il componente esegue il redirect a `route('federation.list')` (la view usa questo route) impostando un messaggio flash di sessione `success` con testo del tipo `__('Federation removed successfully')` (o equivalente).
- **Error handling / sicurezza:**
  - Se la policy non permette la cancellazione, restituzione HTTP 403.
  - Eventuali vincoli a livello di dominio (es. impossibilità di cancellare se ci sono contest in corso sponsorizzati dalla federation) vanno implementati e documentati come TODO: la policy contiene commenti che raccomandano controlli aggiuntivi.

---

## 📦 Modello e Policy rilevanti

- **Model:** `App\Models\Federation`
  - Usa `SoftDeletes` — la cancellazione è soft per impostazione predefinita.
  - Chiave primaria `id` (stringa, non incrementale).
  - Campi principali correlati:
    - `id` (PK char(10))
    - `country_id` (FK `countries.id`)
    - `name_en` (nome ufficiale in inglese)
    - `website` (varchar)
    - `contact_info` (text)
    - `timezone_id`
- **Policy:** `App\Policies\FederationPolicy`
  - Metodo `delete(User $user, Federation $federation)` ritorna `$user->isAdmin()` — solo gli admin possono cancellare.
  - La policy include logging e TODO che richiamano l'obbligo di controlli addizionali (es. contest in corso).

---

## 🔁 Mappatura UI -> Modello (campi visualizzati nella view di rimozione)

- UI `id` (hidden) -> Model `id` (PK)
- UI `code` -> Model `id` (stesso contenuto: shortcode/federation identifier)
- UI `name` -> Model `name_en` (nome ufficiale in inglese; la view mostra il nome come campo leggibile)
- UI `website` -> Model `website`
- UI `countryId` -> Model `country_id`
- UI `contact` -> Model `contact_info`

Nota: i nomi dei campi nel blade sono orientati alla leggibilità della view; il componente Livewire dovrebbe mappare internamente questi attributi alle colonne del modello quando necessario.

---

## ✅ Test consigliati / Copertura

Aggiungere o verificare i test funzionali che coprano il flusso di rimozione:

- **Accesso Admin:** utente admin può accedere alla pagina di conferma rimozione (HTTP 200).
- **Blocco Utente Non Admin:** utente non admin riceve HTTP 403.
- **Reindirizzamento Guest:** guest viene reindirizzato a `route('login')`.
- **Conferma Rimozione (Happy Path):** chiamata all'azione `deleteFederation` effettua soft delete del record (campo `deleted_at` popolato), redirect a `route('federation.list')` e flash `success` in sessione.
- **Integrità Vincoli:** test che impediscano la cancellazione se sono presenti vincoli di dominio (es. contest in corso) quando questi controlli sono implementati.

Suggerimento: creare `tests/Feature/m003/i0187/FederationDeleteTest.php` con i casi sopra.

---

## 👮‍♂️ Pre Merge check

- [ ] Tutti i test dedicati passano (aggiungere test di cui sopra).
- [x] `App\Models\Federation` supporta soft deletes (già presente).
- [x] `App\Policies\FederationPolicy::delete` limita la cancellazione agli admin.
- [x] Nessun `dd()`/`dump()` o log di debug residuo nei file coinvolti.

---

## 🚀 Note per il Deploy

- Nessuna migrazione prevista per questa operazione (soft delete già presente).
- Non sono richiesti nuovi parametri `.env`.
- Raccomandato: eseguire un backup prima di operazioni di massa che rimuovono federations in produzione.

---

## 📝 TODO / Miglioramenti futuri

- Implementare controllo nella policy o nel servizio che impedisca la cancellazione di federazioni che sponsorizzano contest in corso o recenti (per evitare perdita di riferimenti).
- Aggiungere test di integrazione che verificano la conservazione delle relazioni dopo soft delete (es. `withTrashed()` quando necessario).


