# Template di Gestione Issue per Milestone M3 - Debito Tecnologico (Documentazione & Permessi Admin)

Questo documento fornisce una suite completa di template in formato Markdown per strutturare ed organizzare le **Issue Generali (Parent)** e le **Sub-Issue** su GitHub, GitLab o Jira per la Milestone M3, relativa alla documentazione delle funzionalità dei modelli `Federation`, `FederationSection` e `FederationMore`.

---

## 📋 Indice dei Template

1. [Struttura dell'Albero delle Issue](#1-struttura-delle-issue)
2. [Template Issue Principale (Parent / Epic)](#2-template-issue-principale-parent--epic)
3. [Template Sub-Issue 01: Consultazione (Read-Only / Pubblico)](#3-sub-issue-01-consultazione-read-only--pubblico)
4. [Template Sub-Issue 02: Creazione & Aggiunta (Admin Only)](#4-sub-issue-02-creazione--aggiunta-admin-only)
5. [Template Sub-Issue 03: Modifica & Aggiornamento (Admin Only)](#5-sub-issue-03-modifica--aggiornamento-admin-only)
6. [Template Sub-Issue 04: Eliminazione & Impatto a Cascata (Admin Only)](#6-sub-issue-04-eliminazione--impatto-a-cascata-admin-only)
7. [Template Sub-Issue 05: Controlli di Accesso & Edge Cases (Security)](#7-sub-issue-05-controlli-di-accesso--edge-cases-security)

---

<a name="1-struttura-delle-issue"></a>
## 1. 🏗️ Struttura dell'Albero delle Issue

Per mantenere la board pulita ed evitare la dispersione delle informazioni, si consiglia la seguente alberatura a due livelli:

```text
Epic / Parent Issue: M3-FED - Documentazione Architetturale e Permessi Modello [NOME_MODELLO]
 ├── Sub-issue #1: [FED-READ] Documentazione API e Interfaccia di Lettura Pubblica (All Users)
 ├── Sub-issue #2: [FED-CREATE] Flusso di Creazione/Aggiunta e Validazione Input (Admin Group)
 ├── Sub-issue #3: [FED-UPDATE] Flusso di Modifica ed Editing Avanzato (Admin Group)
 ├── Sub-issue #4: [FED-DELETE] Politiche di Eliminazione e Cascade Delete (Admin Group)
 └── Sub-issue #5: [FED-SEC] Test Suite Autorizzazioni, Guardie e Gestione Errori (Non-Admin Blocking)
```

---

<a name="2-template-issue-principale-parent--epic"></a>
## 2. 🏛️ Template Issue Principale (Parent / Epic)

**Titolo suggerito:** `[M3][DOC] Refactoring & Documentazione Modello: <NOME_MODELLO> (Federation / FederationSection / FederationMore)`

```markdown
## 🎯 Obiettivo della Macro-Issue
Nell'ambito della **Milestone M3** (Colmatura Debito Tecnologico), questa Issue si occupa di documentare integralmente le API, l'interfaccia utente, i flussi logici e le regole autorizzative relative al modello **`<NOME_MODELLO>`**.

Attualmente la funzionalità è già implementata nel codebase, ma richiede una documentazione tecnica dettagliata per sviluppatori e manutentori, specificando in modo chiaro le restrizioni d'accesso per il gruppo `admin`.

---

## 🔍 Ambito e Regole di Accesso del Modello
- **Modello Oggetto:** `<NOME_MODELLO>` (es. `Federation`, `FederationSection`, `FederationMore`)
- **Permesso di Lettura (Read):** Pubblico / Tutti gli utenti autenticati e anonimi.
- **Permesso di Scrittura (Create / Update / Delete):** Riservato ESCLUSIVAMENTE agli utenti appartenenti al gruppo `admin`.

---

## 📌 Checklist Sub-Issue Collegati
- [ ] #01 - Documentazione Consultazione Read-Only
- [ ] #02 - Documentazione Flusso di Creazione (Group `admin`)
- [ ] #03 - Documentazione Flusso di Modifica (Group `admin`)
- [ ] #04 - Documentazione Flusso di Eliminazione e Cascata (Group `admin`)
- [ ] #05 - Matrice dei Permessi, Guardie di Sicurezza & Test Case Edge Cases

---

## 🛠️ deliverable Attesi
1. File `.md` di documentazione architetturale aggiornato nella cartella `/docs/architecture/` o Wiki di progetto.
2. OpenAPI / Swagger spec aggiornata per tutti gli endpoint legati al modello.
3. Esempi di Request / Response e casi d'errore (HTTP 403 Forbidden per non-admin).

---

## 🏷️ Etichette / Metadata
- **Milestone:** M3 - Tech Debt & Docs
- **Labels:** `documentation`, `tech-debt`, `admin-panel`, `security`
- **Assignee:** @username
```

---

<a name="3-sub-issue-01-consultazione-read-only--pubblico"></a>
## 3. 📖 Sub-Issue 01: Consultazione (Read-Only / Pubblico)

**Titolo suggerito:** `[M3][FED-01] Documentazione Operazioni Read-Only (Pubblico) per <NOME_MODELLO>`

```markdown
### 📝 Descrizione Task
Documentare le modalità di consultazione e lettura dei dati del modello `<NOME_MODELLO>`. Questa funzionalità è accessibile a qualsiasi tipo di utente (pubblico/autenticato).

### 📋 Checklist di Dettaglio
- [ ] Documentare l'endpoint REST/GraphQL di recupero lista (`GET /api/<NOME_MODELLO>s`).
- [ ] Documentare l'endpoint REST/GraphQL del dettaglio singolo (`GET /api/<NOME_MODELLO>s/{id}`).
- [ ] Mappare i parametri di paginazione, ordinamento e filtraggio supportati.
- [ ] Verificare che non vengano esposti campi sensibili o riservati alle sole visualizzazioni admin.
- [ ] Aggiungere esempio di payload JSON valido di risposta.

### 🏁 Criteria di Accettazione (Definition of Done)
- La documentazione riporta tutti gli headers e parametri necessari.
- Gli schemi di risposta in OpenAPI/Swagger corrispondono perfettamente all'output del backend.
```

---

<a name="4-sub-issue-02-creazione--aggiunta-admin-only"></a>
## 4. ➕ Sub-Issue 02: Creazione & Aggiunta (Admin Only)

**Titolo suggerito:** `[M3][FED-02] Documentazione Flusso di Creazione da parte del gruppo Admin per <NOME_MODELLO>`

```markdown
### 📝 Descrizione Task
Documentare il processo e gli endpoint riservati agli utenti del gruppo `admin` per la creazione di nuovi record del modello `<NOME_MODELLO>`.

### 📋 Checklist di Dettaglio
- [ ] Documentare l'endpoint di creazione (`POST /api/admin/<NOME_MODELLO>s`).
- [ ] Specificare la struttura del body della richiesta con tutti i campi obbligatori e opzionali.
- [ ] Se trattasi di modelli figli (`FederationSection` / `FederationMore`), documentare l'obbligatorietà del riferimento (FK) al modello padre `Federation`.
- [ ] Documentare le regole di validazione dei dati (es. unicità, lunghezza stringhe, formato immagini/url).
- [ ] Documentare gli header d'accesso richiesti (Token Bearer / Session Cookie) con privilegio Admin.

### 🏁 Criteria di Accettazione (Definition of Done)
- Un nuovo sviluppatore deve essere in grado di effettuare una chiamata POST corretta leggendo esclusivamente la documentazione prodotta.
- Presenti gli schemi dei codici d'errore HTTP 400 (Bad Request) e HTTP 422 (Unprocessable Entity).
```

---

<a name="5-sub-issue-03-modifica--aggiornamento-admin-only"></a>
## 5. ✏️ Sub-Issue 03: Modifica & Aggiornamento (Admin Only)

**Titolo suggerito:** `[M3][FED-03] Documentazione Flusso di Modifica da parte del gruppo Admin per <NOME_MODELLO>`

```markdown
### 📝 Descrizione Task
Documentare le modalità di aggiornamento parziale e totale dei dati per un record esistente di `<NOME_MODELLO>`, riservato al gruppo `admin`.

### 📋 Checklist di Dettaglio
- [ ] Documentare le differenze tra aggiornamento totale (`PUT /api/admin/<NOME_MODELLO>s/{id}`) e parziale (`PATCH /api/admin/<NOME_MODELLO>s/{id}`).
- [ ] Documentare la gestione dell'aggiornamento dei riferimenti ai modelli figli/padri.
- [ ] Specificare il comportamento in caso di modifiche concorrenti (se gestito tramite Locking/Versioning).
- [ ] Fornire esempi di payload prima e dopo la modifica.

### 🏁 Criteria di Accettazione (Definition of Done)
- Tutti i parametri aggiornabili sono censiti.
- I requisiti di sicurezza per l'autenticazione dell'utente nel gruppo `admin` sono chiaramente specificati.
```

---

<a name="6-sub-issue-04-eliminazione--impatto-a-cascata-admin-only"></a>
## 6. 🗑️ Sub-Issue 04: Eliminazione & Impatto a Cascata (Admin Only)

**Titolo suggerito:** `[M3][FED-04] Documentazione Flusso di Eliminazione e Cascade Delete per <NOME_MODELLO>`

```markdown
### 📝 Descrizione Task
Documentare l'operazione di eliminazione di un record `<NOME_MODELLO>` e definire formalmente il comportamento del sistema sui relativi elementi correlati (modelli figli `FederationSection` e `FederationMore`).

### 📋 Checklist di Dettaglio
- [ ] Documentare l'endpoint di cancellazione (`DELETE /api/admin/<NOME_MODELLO>s/{id}`).
- [ ] Specificare il tipo di cancellazione adottato: **Hard Delete** (rimozione fisica) vs **Soft Delete** (flag/timestamp).
- [ ] Documentare la logica di **Cascade Delete**:
  - Se elimino un `Federation`, cosa succede ai `FederationSection` e `FederationMore` correlati?
  - Viene bloccata l'eliminazione se esistono figli attivi o vengono cancellati contestualmente?
- [ ] Documentare il codice di risposta HTTP standard in caso di successo (HTTP 204 No Content o HTTP 200 OK con payload).

### 🏁 Criteria di Accettazione (Definition of Done)
- La matrice di impatto della cancellazione (Cascade Policy) è chiaramente spiegata sia per il frontend che per il backend.
```

---

<a name="7-sub-issue-05-controlli-di-accesso--edge-cases-security"></a>
## 7. 🛡️ Sub-Issue 05: Controlli di Accesso & Edge Cases (Security)

**Titolo suggerito:** `[M3][FED-05] Documentazione Matrice Permessi, Ruoli Admin e Gestione Errori per <NOME_MODELLO>`

```markdown
### 📝 Descrizione Task
Documentare e codificare formalmente la politica di sicurezza RBAC (Role-Based Access Control) applicata al modello `<NOME_MODELLO>`, specificando la gestione degli errori per tentativi di accesso non autorizzati.

### 📋 Tabella Matrice Autorizzativa da Documentare

| Ruolo / Gruppo | Read (GET) | Create (POST) | Update (PUT/PATCH) | Delete (DELETE) |
| :--- | :---: | :---: | :---: | :---: |
| **Anonymous / Public** | ✅ | ❌ | ❌ | ❌ |
| **Standard User (Logged)** | ✅ | ❌ | ❌ | ❌ |
| **Admin Group** | ✅ | ✅ | ✅ | ✅ |

### 📋 Checklist di Dettaglio
- [ ] Documentare i middleware / guardie d'accesso attivi sugli endpoint di scrittura (`AdminGroupGuard` / `HasRole('admin')`).
- [ ] Mappare le risposte HTTP d'errore relative alla sicurezza:
  - `HTTP 401 Unauthorized`: Utente non autenticato che tenta azioni C/U/D.
  - `HTTP 403 Forbidden`: Utente autenticato MA NON appartenente al gruppo `admin` che tenta azioni C/U/D.
  - `HTTP 404 Not Found`: Risorsa non esistente o nascosta per motivi di sicurezza.
- [ ] Documentare eventuali casi limite (Edge Cases): tentativi di bypass tramite modifica ID nel payload, token scaduti, rimozione di ruoli in corso di sessione.

### 🏁 Criteria di Accettazione (Definition of Done)
- Presenza nel repository della matrice di sicurezza completa e referenziata negli Integration Test.
```

---
*Documento generato per la Milestone M3 - Debito Tecnologico (Model Federation System)*
