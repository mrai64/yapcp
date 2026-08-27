# Feature: Federation More modify

> **Branch:** `feat/0233-federation-more-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-23.03  
> **Titolo e urgenza:** (A) feat: FederationMore / Modify blade  
> **Project/issue link:** [#233](https://github.com/mrai64/yapcp/issues/233)  
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 📝 Logica Tecnica

Il componente `modify.blade.php` è un Livewire Volt component che gestisce la modifica di campi aggiuntivi richiesti dalle federazioni (FederationMore). 

**Scopo:** Permettere ai soli amministratori di modificare i metadati di un campo "more" già esistente (label, regole di validazione, valore di default, suggerimento), mantenendo immutato il `field_name` (chiave univoca).

**Scelta tecnologica:** Utilizziamo Livewire Volt per:
- Validazione in tempo reale con wire:model
- Test delle regole di validazione Laravel prima di salvare (`Validator::make()` su un valore temporaneo)
- Feedback immediato all'utente tramite `$this->validate()`
- Redirect post-salvataggio con session flash message

**Flusso:**
1. Mount carica i dati attuali di FederationMore
2. Form binds i campi agli state properties tramite `wire:model`
3. Submit chiama `modifyFederationMore()` che:
   - Valida prima la sintassi delle regole di validazione Laravel
   - Esegue la validazione completa del form
   - Usa `updateOrCreate()` con chiave univoca (referenced, federation_id, field_name)
   - Redirige alla lista con messaggio di successo

---

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Nessuna modifica al database (aggiornamento di record FederationMore esistenti)
- [x] Colonna `field_name` è immutabile (non in validazione, preservata in updateOrCreate)

---

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna migrazione da eseguire
- Nessun parametro `.env` aggiuntivo richiesto
- Componente accessibile solo agli utenti con ruolo admin (`Auth::user()->isAdmin()`)
- Avviso visivo in rosso nel template per enfatizzare i rischi di modifica errata

---

## ⚠️ Considerazioni di Sicurezza

- **Admin-only:** Accesso limitato a `isAdmin()`
- **Validazione doppia:** Regole di validazione testate prima del salvataggio
- **Field name protected:** Non modificabile tramite form (immutabile nella logica)
- **Log audit:** Loggati ID e nome utente admin che effettuano modifiche

---

## 📋 Checklist Pre-Merge

- [x] **Test:** Tutti i test passano
- [x] **Docs:** File `/resources/docs/dev/feat/0233-federation-more-modify.md` aggiornato
- [x] **Manual:** Documentazione utente non richiesta (sezione admin ristretta)
- [x] **Cleanup:** Rimossi `dd()` e `dump()`
- [x] **Commit:** Messaggi chiari
