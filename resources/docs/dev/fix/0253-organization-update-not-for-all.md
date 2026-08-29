# Fix: Esposizione Condizionale Link Elenco Organizzazioni

> **Branch:** `fix/0253-update-not-for-all`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-29.01  
> **Titolo e urgenza:** (A) fix: Organization / Organization list expose update link for all  
> **Project/issue link:** [#253](https://github.com/mrai64/yapcp/issues/253)  
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [📁 Dettaglio dei File Modificati](#-dettaglio-dei-file-modificati)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

### Panoramica del problema
Nel componente di elenco delle organizzazioni ([`resources/views/livewire/organization/listed.blade.php`](file:///Users/massimorainato/Sites/yapcp/resources/views/livewire/organization/listed.blade.php)), i link di interazione (`Update`, `Org Dashboards`, `Remove`, `Add me to`) erano esposti indiscriminatamente a tutti gli utenti senza verificare se l'utente fosse un amministratore di sistema o facesse effettivamente parte dell'organizzazione.

Inoltre, il pulsante **"Add me to"** veniva mostrato anche agli utenti che facevano già parte dell'organizzazione.

---

### Matrice di Visibilità e Permessi Implementata

| Azione / Link | Target URL / Route | Visibilità / Condizione | Note |
| :--- | :--- | :--- | :--- |
| **`Org Dashboards`** | `organization.dashboard` | Admin **oppure** Membro attivo dell'organizzazione | `auth()->user()?->isAdmin() \|\| in_array($organization->id, $userOrgIds)` |
| **`Update`** | `organization.modify` | Admin **oppure** Membro attivo dell'organizzazione | `auth()->user()?->isAdmin() \|\| in_array($organization->id, $userOrgIds)` |
| **`Remove`** | `organization.remove` | **Solo Admin** | `auth()->user()?->isAdmin()` |
| **`Add me to`** | `organization.user.add` | Utenti autenticati **NON** ancora membri | `!in_array($organization->id, $userOrgIds)` |

> **Nota:** Le organizzazioni di sistema/interne (con nome che non supera `'/'`) restano escluse per i non-admin.

---

### Ottimizzazione delle Prestazioni (Prevenzione N+1 Query)
Per evitare di eseguire una query di controllo per ciascuna organizzazione presente nella tabella paginata:
1. Nel metodo `with()` del componente Volt `listed.blade.php`, se l'utente autenticato non è un amministratore, viene estratto in una singola query preventiva l'array degli ID delle organizzazioni a cui appartiene con ruolo attivo:
   ```php
   $userOrgIds = $user && !$user->isAdmin()
       ? $user->activeUserRoles()->whereNotNull('organization_id')->pluck('organization_id')->toArray()
       : [];
   ```
2. L'array `$userOrgIds` viene passato alla vista Blade, consentendo verifiche istantanee in memoria tramite `in_array($organization->id, $userOrgIds)`.

---

### Nuove Relazioni Many-to-Many Eloquent
Per supportare la relazione diretta tra utenti e organizzazioni attraverso la tabella pivot `user_roles`:
- **[`app/Models/User.php`](file:///Users/massimorainato/Sites/yapcp/app/Models/User.php):**
  ```php
  public function organizations(): BelongsToMany
  {
      return $this->belongsToMany(Organization::class, 'user_roles', 'user_id', 'organization_id')
          ->using(UserRole::class)
          ->withPivot(['role', 'role_opening', 'role_closing'])
          ->wherePivot('role_opening', '<=', now())
          ->wherePivot('role_closing', '>=', now());
  }
  ```
- **[`app/Models/Organization.php`](file:///Users/massimorainato/Sites/yapcp/app/Models/Organization.php):**
  ```php
  public function users(): BelongsToMany
  {
      return $this->belongsToMany(User::class, 'user_roles', 'organization_id', 'user_id')
          ->using(UserRole::class)
          ->withPivot(['role', 'role_opening', 'role_closing'])
          ->wherePivot('role_opening', '<=', now())
          ->wherePivot('role_closing', '>=', now());
  }
  ```

---

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Nessuna nuova migration richiesta.
- [x] Sfruttata la struttura esistente della tabella pivot `user_roles` con filtro temporale sui campi pivot `role_opening` e `role_closing`.

---

## 📁 Dettaglio dei File Modificati

| File | Modifica apportata |
| :--- | :--- |
| [`resources/views/livewire/organization/listed.blade.php`](file:///Users/massimorainato/Sites/yapcp/resources/views/livewire/organization/listed.blade.php) | Calcolo di `$userOrgIds` in `with()` ed esposizione condizionale di `Add me to`, `Remove`, `Org Dashboards` e `Update`. |
| [`app/Models/User.php`](file:///Users/massimorainato/Sites/yapcp/app/Models/User.php) | Aggiunta relazione `organizations(): BelongsToMany` su pivot `user_roles`. |
| [`app/Models/Organization.php`](file:///Users/massimorainato/Sites/yapcp/app/Models/Organization.php) | Aggiunta relazione `users(): BelongsToMany` su pivot `user_roles`. |
| [`dev-diary/2026-08/2026-08-29_IT.md`](file:///Users/massimorainato/Sites/yapcp/dev-diary/2026-08/2026-08-29_IT.md) | Aggiornamento del diario di sviluppo con annotazioni relative al fix. |

---

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test esistenti passano in verde (`php artisan test`).
- [x] **Docs:** Creata la scheda tecnica in `/resources/docs/dev/fix/0253-organization-update-not-for-all.md`.
- [x] **Manual:** Verificata la visualizzazione corretta dei link con utente guest, utente membro, utente non membro e admin.
- [x] **Cleanup:** Nessun `dd()` o codice di debug residuo.
- [x] **Commit:** Messaggi chiari e conformi agli standard di progetto.

---

## 🚀 Note per il Deploy

> <!-- to avoid index in Larecipe -->
- Nessuna operazione di migrazione database necessaria.
- Svuotare la cache delle viste in ambiente di staging/produzione:
  ```bash
  php artisan view:clear
  ```
