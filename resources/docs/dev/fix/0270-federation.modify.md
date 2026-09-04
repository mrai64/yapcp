# Feature: Federation Modify - Authorization Check

> **Branch:** `fix/0270-federation-modify`  
> **Stato:** Completato
> **priorità:** A  
> **id assegnato:** 2025-09-04.01  
> **Titolo e urgenza:** (A) fix: Federation / Modify - admin can't access to modify page
> **Project/issue link:** [#270](https://github.com/mrai64/yapcp/issues/270)
> **Milestone link:** [M1](https://github.com/mrai64/yapcp/milestones/1)


---

## 📝 Logica Tecnica

La modifica implementa il controllo di autorizzazione per l'operazione di aggiornamento delle federazioni. Il problema risiedeva nel fatto che era possibile modificare una federazione anche senza le opportune autorizzazioni.

**Soluzione adottata:**

> <!-- to avoid index in Larecipe -->
- Aggiunto controllo di autorizzazione nella **FederationPolicy** tramite il metodo `update()` che verifica se l'utente è admin
- Aggiunto controllo nel **Livewire component** `federation/modify.blade.php` per verificare le autorizzazioni prima di consentire la modifica
- I log informativi permettono il tracking delle operazioni per scopi di debug e audit

**Perché questa soluzione:**

- Segue il pattern Laravel di Policy-based authorization
- Centralizza la logica di autorizzazione in un'unica posizione (Policy)
- Previene accessi non autorizzati tramite doppio controllo (Policy + Livewire)
- Mantiene traccia delle operazioni tramite logging

## 🗄️ Modifiche al Database

> <!-- to avoid index in Larecipe -->
- [x] Nessuna migrazione necessaria - modifica logica solo

## 🔧 File Modificati

### 1. `app/Policies/FederationPolicy.php`

> <!-- to avoid index in Larecipe -->
- Implementato metodo `update()` con controllo `isAdmin()`
- Aggiunto logging per audit trail
- TODO commentato documenta il requisito futuro: "Modify federation can cause mistake on running contest - add some check that there is no running contest"

### 2. `resources/views/livewire/federation/modify.blade.php`

> <!-- to avoid index in Larecipe -->
- Aggiornata la view Livewire per il form di modifica
- Assicura che solo utenti autorizzati possano visualizzare/modificare i dati della federazione
- Implementate validazioni lato client

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna migrazione database necessaria
- Verificare che gli utenti admin possano ancora modificare le federazioni
- Monitorare i log in `storage/logs/` per verificare le autorizzazioni negate

## ✅ Checklist Pre-Deploy

> <!-- to avoid index in Larecipe -->
- [x] FederationPolicy implementata con autorizzazioni
- [x] Logging aggiunto per tracking
- [x] Blade template aggiornato
- [x] Test di autorizzazione eseguiti
- [x] Documentazione aggiornata nei docs

## 📌 Considerazioni Future

Il TODO nella Policy suggerisce una validazione ulteriore: prima di consentire la modifica,
verificare che non ci siano contest in esecuzione sponsorizzati dalla federazione.
Questo controllo dovrebbe essere implementato nel metodo `update()` della Policy,
ma crea problemi di accesso in quanto non si capisce la differenza tra non autorizzato e non modificabile.

```php
// TODO: Add check - Verify no running contests sponsored by this federation
if ($this->hasRunningContests($federation)) {
    return false;
}
