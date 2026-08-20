# Docs: Federation Policies (permessi d'azione sulle Federazioni))

> **Branch:** `docs/0188-federation-policy`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-15.08  
> **Titolo e urgenza:** (A) docs: documentazione matrice di sicurezza UI e gestione accessi negati per Federation  
> **Project/issue link:** [#188](https://github.com/mrai64/yapcp/issues/188)  
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

##  Matrice dei permessi

| Ruolo / Gruppo | Lista delle Federazioni \_R\__ | Accesso ai Form C\_UD | Sottomissione Form |
| :--- | :---: | :---: | :---: |
| **Utente Generico / Visitatore** | ✅ Consentito | ❌ Nascosto / Negato | ❌ Bloccato |
| **Utente Autenticato (Non Admin)** | ✅ Consentito | ❌ Nascosto / Negato | ❌ Bloccato |
| **Gruppo Admin** | ✅ Consentito | ✅ Abilitato | ✅ Consentito |

## 🌐 Rotta e Controllo Accessi

###  Read - Lista delle Federazioni

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

### Create - Aggiunta federazione

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

### Update - Modifica Federazione

- **Endpoint / URL:** `<https://yapcp.test/federation/modify/{federation}>`
- **Nome Rotta:** `route('federation.modify', ['federation' => $federation])`
- **Middleware:** `auth`, `verified`, `can:update,federation` (accesso riservato esclusivamente agli amministratori autorizzati; policy `update` in `App\Policies\FederationPolicy`; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
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

### Delete - Rimozione Federazione

- **Endpoint / URL:** `<https://yapcp.test/federation/remove/{federation}>`
- **Nome Rotta:** `route('federation.remove', ['federation' => $federation])`
- **Middleware:** `auth`, `verified`, `can:delete,federation` (accesso riservato esclusivamente agli amministratori autorizzati; policy `delete` in `App\Policies\FederationPolicy`; gli utenti non autorizzati ricevono HTTP 403 Forbidden; i guest vengono reindirizzati alla pagina di login).
- **Differenziazione dei ruoli:**
  - **Utente standard (non admin):**
    - Accesso inibito alla pagina (HTTP 403 Forbidden).
  - **Guest (non autenticato):**
    - Reindirizzamento alla pagina di login (`route('login')`).
  - **Gruppo Amministratori (`isAdmin == true` / policy `delete`):**
    - Visualizzazione e richiesta conferma con i dati della federazione selezionata.
      Nel caso si arrivi comunque al link con concorsi attivi non viene presentato il pulsante di conferma ma un avviso.
    - Link di navigazione rapida nell'header:
      - **"Back to User dashboard"** (`route('user.dashboard')`) per tornare alla dashboard utente.
      - **"Federation list"** (`route('federation.listed')`) per tornare all'elenco delle federazioni.

##  Protezione CSRF obbligatoria

È presente in tutti i form di scrittura/modifica/eliminazione.

## Controlli nelle blade per mostrare / nascondere

- resources/views/livewire/federation/listed.blade.php — elemento: pulsante "Add New Federation" e pulsanti link "Update", "Remove"  — condizione Blade: direttiva (@if) presente nel template — visibilità: il pulsante viene visualizzato a condizione che sia ($user->isAdmin()); l'autorizzazione viene gestita lato server/Livewire (vedi: <https://github.com/mrai64/yapcp/blob/64600eabe3d669dfe613e7fb92d8c22c25c7b1dc/resources/views/livewire/federation/listed.blade.php>).

- resources/views/livewire/federation/modify.blade.php — elemento: form di modifica + pulsante "Update" — condizione Blade: nessuna direttiva (@if/@can/@role) presente nel template — visibilità: il controllo UI è reso incondizionatamente; l'autorizzazione deve essere gestita lato server/Livewire (vedi: <https://github.com/mrai64/yapcp/blob/64600eabe3d669dfe613e7fb92d8c22c25c7b1dc/resources/views/livewire/federation/modify.blade.php>).

- resources/views/livewire/federation/remove.blade.php — elemento: form di rimozione + pulsante "Confirm" — condizione Blade: nessuna direttiva (@if/@can/@role) presente nel template — visibilità: il controllo UI è reso incondizionatamente; l'autorizzazione deve essere gestita lato server/Livewire (vedi: <https://github.com/mrai64/yapcp/blob/64600eabe3d669dfe613e7fb92d8c22c25c7b1dc/resources/views/livewire/federation/remove.blade.php>).
