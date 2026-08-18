# Feature: Federation Delete Policy

> **Branch:** `feat/0114-federation-delete-policy`  
> **Stato:** Revisione
> **priorità:** A  
> **id assegnato:** 2026-03-23.01  
> **Titolo e urgenza:** (A) feat: Federation CRUD / delete, remove only under certain conditions  
> **Project/issue link:** [#114](https://github.com/mrai64/yapcp/issues/114)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Obiettivo: permettere la cancellazione (delete) di una federazione solo quando sono soddisfatte condizioni di sicurezza e integrità dei dati. La UI mostrerà il link di cancellazione solo quando il conteggio dei concorsi "attivi" per quella federazione è 0 e l'utente che visualizza la lista è un admin, ma la regola DEV'ESSERE applicata anche lato server (policy / controller / servizio) perché la UI da sola non è sufficiente.

Regole principali (sintesi):

- R1 (UI): nella lista federazioni, il pulsante/link "Elimina" è mostrato soltanto ad utenti admin e soltanto se il numero di concorsi attivi associati alla federazione è 0.
- R2 (Server): l'endpoint/azione che esegue la cancellazione deve verificare le stesse condizioni server-side e rifiutare la cancellazione con 403 Forbidden (o 422) se non soddisfatte.
- R3 (Definizione "attivo"): i concorsi attivi sono definiti esplicitamente (vedi sotto). Usare una query Eloquent chiara e indicizzata per il conteggio.
- R4 (Delete strategy): esplicitare se si effettua soft-delete (deleted_at) o hard-delete; il progetto al momento usa SoftDeletes sui model di Federations: preferire soft-delete salvo diversa necessità operativa.
- R5 (Logging/Audit): ogni azione di cancellazione (tentata o avvenuta) deve essere loggata per audit (user id, federation id, outcome, timestamp).


### Definizione operativa di "concorsi attivi"

Si richiede di definire (scelta raccomandata):

- Un contest è "attivo" se:
  - ha stati che indicano pubblicazione o svolgimento; esempio (scegliere quelli reali utilizzati nel codice): `status IN ('published', 'running')` oppure usiamo campi temporali: `day_1_opening <= now() AND day_8_closing >= now()`.
  - NON contare concorsi che siano soft-deleted (`deleted_at IS NOT NULL`).

Esempio Eloquent per il conteggio consigliato (inside Federation query):

```php
// Esempio illustrativo - adattare ai nomi reali dei campi
$federations = Federation::withCount([
    'contests as active_contests_count' => function ($q) {
        $q->whereIn('status', ['published', 'running'])
          ->whereNull('deleted_at');
    }
])->get();
```

Nota: usare indici su contests(federation_id, status, deleted_at) se il dataset cresce.


### Soft delete vs Hard delete

- Attuale: il Model Federation usa SoftDeletes. Raccomandazione: mantenere soft-delete per sicurezza.
- Se si richiede hard-delete, aggiungere una migration con foreign key cascade o procedure per rimuovere dati collegati e file esterni; documentare gli effetti collaterali.
- Per soft-delete: definire politica di ripristino e se lo slug/nome diventa riutilizzabile.


### Policy / Authorization (server-side)

- Implementare una FederationPolicy con metodo `delete(User $user, Federation $federation): bool` che:
  - Verifica che l'utente sia admin (es. $user->isAdmin()).
  - Verifica active contests count === 0.
  - Eventualmente disabilita la cancellazione se sono presenti record "in uso" in tabelle correlate (user roles with federation_id, federation_mores in use, ecc.).

Esempio (scheletrico):

```php
public function delete(User $user, Federation $federation): bool
{
    if (! $user->isAdmin()) {
        return false;
    }

    $active = $federation->contests()
        ->whereIn('status', ['published', 'running'])
        ->whereNull('deleted_at')
        ->exists();

    return ! $active;
}
```

Quando la policy rifiuta, l'azione controller deve ritornare 403 Forbidden con un messaggio leggibile.


### Controller / Livewire

- Nella action che esegue delete (o nel componente Livewire Remove), chiamare `Gate::authorize('delete', $federation)` o `$this->authorize('delete', $federation)` e gestire l'eccezione AuthorizationException con un feedback per l'utente.
- Non fare assunzioni basate solo sulla vista: un utente potrebbe inviare la richiesta DELETE direttamente.


### UX / Messaggi

- Mostrare il conteggio di concorsi attivi accanto alla federazione nella lista (es: "Concorsi attivi: 2").
- Quando la cancellazione è disabilitata, mostrare un tooltip: "Non eliminabile: ci sono X concorsi attivi".
- Conferma modale prima della cancellazione con riepilogo delle conseguenze.


## ✅ Acceptance criteria (proposti)

- AC1: Un utente admin vede il link/azione "Elimina" per una federazione solo se active_contests_count == 0.
- AC2: Un utente non-admin non vede il link "Elimina" in alcun caso.
- AC3: L'endpoint di cancellazione rifiuta la richiesta con 403 quando active_contests_count > 0.
- AC4: Se active_contests_count == 0 e l'utente è admin, la cancellazione procede (soft-delete) e viene registrato un log/audit.
- AC5: I test automatici coprono policy, controller e UI (feature tests) per i casi principali.


## 🧪 Tests suggeriti (da implementare)

1) Unit / Policy
- FederationPolicyTest::test_admin_allowed_when_no_active_contests
- FederationPolicyTest::test_admin_denied_when_active_contests
- FederationPolicyTest::test_non_admin_denied_always

2) Feature / Controller
- FederationDeleteFeatureTest::test_delete_endpoint_returns_403_when_active_contests
- FederationDeleteFeatureTest::test_delete_endpoint_deletes_and_logs_when_allowed

3) Browser / Livewire (optional but raccomandato)
- FederationListTest::test_delete_button_shown_only_for_admin_and_no_active_contests

4) Edge cases
- Race condition: concorso creato tra il render e la richiesta di delete — il server-side deve proteggere (test per tentata delete fallita e federazione non rimossa).
- Soft-deleted contests: non contare come attivi.


Per comodità, ho creato una bozza di test file PHPUnit in `tests/Feature/FederationDeletePolicyTest.php` (vedi commit). I test sono descrittivi e contengono TODO dove dipendono da factory/model shape che potrebbe richiedere aggiustamenti locali.


## 🗄️ Modifiche al Database

> <!-- to avoid index -->
Nessuna modifica prevista. Se decidete di aggiungere indici per performance, si aggiungerà una migration.


## 👮‍♂️ Pre Merge check

- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [X] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [X] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?


## 🚀 Note per il Deploy

> <!-- to avoid index -->
Niente da segnalare


---

Co-autore: GitHub Copilot <copilot@github.com>
