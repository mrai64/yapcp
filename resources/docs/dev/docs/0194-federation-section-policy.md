# Docs: FederationSection Policies (permessi d'azione sulle Sezioni delle Federazioni)

> **Branch:** `docs/0194-federation-section-policy`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-15.08  
> **Titolo e urgenza:** (A) docs: documentazione matrice di sicurezza UI e gestione accessi negati per FederationSection  
> **Project/issue link:** [#194](https://github.com/mrai64/yapcp/issues/194)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 🔐 Matrice dei permessi

| Ruolo / Gruppo | Lista delle Sezioni \_R\__ | Accesso ai Form C\_UD | Sottomissione Form |
| :--- | :---: | :---: | :---: |
| **Utente Generico / Visitatore** | ❌ Nascosto / Negato | ❌ Nascosto / Negato | ❌ Bloccato |
| **Utente Autenticato (Non Admin)** | ✅ Consentito | ❌ Nascosto / Negato | ❌ Bloccato |
| **Gruppo Admin** | ✅ Consentito | ✅ Abilitato | ✅ Consentito |

## 🌐 Rotta e Controllo Accessi

### 📖 Read - Lista delle Sezioni Federazione

- **Endpoint / URL:** `<https://yapcp.test/federation-section/listed/{federation}>`
- **Nome Rotta:** `route('federation-section.listed', ['federation' => $federation])`
- **Middleware:** `auth`, `verified` (accesso riservato agli utenti autenticati; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (tutti gli utenti autenticati):**
    - Consultazione dell'elenco delle sezioni e temi definiti per la federazione selezionata (`code`, `name_en`, `synopsis`, limiti numerici, flag per monocromatico/RAW/premi).
    - Link di navigazione per il ritorno alla Dashboard Utente (`route('user.dashboard')`) e alla lista federazioni (`route('federation.listed')`).
    - I pulsanti di azione/gestione (Add, Update, Remove) **non vengono visualizzati**.
  - **Gruppo Amministratori (`isAdmin == true`):**
    - Visualizzazione aggiuntiva nell'header del pulsante **"Add a Federation Section"** (`route('federation-section.add', ['federation' => $federation])`).
    - Per ciascuna scheda sezione, visualizzazione dei pulsanti di gestione:
      - Link **"Update"** per la modifica (`route('federation-section.modify', ['federation_section' => $section])`).
      - Link **"‼️ Remove"** per la cancellazione (`route('federation-section.delete', ['federation_section' => $section])`).

### ➕ Create - Aggiunta Sezione Federazione

- **Endpoint / URL:** `<https://yapcp.test/federation-section/add/{federation}>`
- **Nome Rotta:** `route('federation-section.add', ['federation' => $federation])`
- **Middleware:** `auth`, `verified`, `can:create,App\Models\FederationSection` (accesso riservato esclusivamente agli amministratori autorizzati; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (non admin):**
    - Accesso inibito alla pagina (HTTP 403 Forbidden).
  - **Guest (non autenticato):**
    - Reindirizzamento alla pagina di login (`route('login')`).
  - **Gruppo Amministratori (`isAdmin == true` / policy `create`):**
    - Visualizzazione del modulo completo per il censimento di una nuova sezione/tema per la federazione.
    - Link di navigazione rapida nell'header:
      - **"Back to User dashboard"** (`route('user.dashboard')`).
      - **"Federation list"** (`route('federation.listed')`).
      - **"Federation Section list"** (`route('federation-section.listed', ['federation' => $federation])`).

### ✏️ Update - Modifica Sezione Federazione

- **Endpoint / URL:** `<https://yapcp.test/federation-section/modify/{federation_section}>`
- **Nome Rotta:** `route('federation-section.modify', ['federation_section' => $federation_section])`
- **Middleware:** `auth`, `verified`, `can:update,App\Models\FederationSection` (accesso riservato esclusivamente agli amministratori autorizzati; policy `update` in `App\Policies\FederationSectionPolicy`; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (non admin):**
    - Accesso inibito alla pagina (HTTP 403 Forbidden).
  - **Guest (non autenticato):**
    - Reindirizzamento alla pagina di login (`route('login')`).
  - **Gruppo Amministratori (`isAdmin == true` / policy `update`):**
    - Visualizzazione del modulo pre-popolato con i dati della sezione selezionata. Il campo `code` viene mostrato in sola lettura.
    - Link di navigazione rapida nell'header:
      - **"Back to User dashboard"** (`route('user.dashboard')`).
      - **"Federation list"** (`route('federation.listed')`).
      - **"Federation Section list"** (`route('federation-section.listed', ['federation' => $federation])`).

### 🗑️ Delete - Rimozione Sezione Federazione

- **Endpoint / URL:** `<https://yapcp.test/federation-section/remove/{federation_section}>`
- **Nome Rotta:** `route('federation-section.delete', ['federation_section' => $federation_section])`
- **Middleware:** `auth`, `verified`, `can:delete,App\Models\FederationSection` (accesso riservato esclusivamente agli amministratori autorizzati; policy `delete` in `App\Policies\FederationSectionPolicy`; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (non admin):**
    - Accesso inibito alla pagina (HTTP 403 Forbidden).
  - **Guest (non autenticato):**
    - Reindirizzamento alla pagina di login (`route('login')`).
  - **Gruppo Amministratori (`isAdmin == true` / policy `delete`):**
    - Visualizzazione della schermata di conferma con riepilogo in sola lettura dei dati della sezione da eliminare.
    - Esecuzione di cancellazione logica (*SoftDeletes*) su sottomissione del form.
    - Link di navigazione rapida nell'header per tornare alle viste principali.

## 🛡️ Protezione CSRF obbligatoria

È presente la direttiva `@csrf` in tutti i form di scrittura/modifica/eliminazione (`federation-section.add`, `federation-section.modify`, `federation-section.delete`).

## 👁️ Controlli nelle blade per mostrare / nascondere

- `resources/views/livewire/federation-section/listed.blade.php`:
  - **Pulsante "Add a Federation Section"** (header): racchiuso nel controllo Blade `@if ($this->isAdmin)` per mostrare il link solo agli amministratori autenticati.
  - **Link di gestione "Update" e "‼️ Remove"**: racchiusi nel controllo Blade `@if ($this->isAdmin)` all'interno del ciclo `@foreach ($sectionSet as $section)`.
  - La proprietà `$this->isAdmin` viene inizializzata nel metodo `mount()` tramite `Auth::user()->isAdmin()`.
