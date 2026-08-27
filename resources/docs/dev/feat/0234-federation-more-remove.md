# Feature: Federation More modify

> **Branch:** `feat/0234-federation-more-modify`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-23.04  
> **Titolo e urgenza:** (A) feat: FederationMore / Remove blade  
> **Project/issue link:** [#234](https://github.com/mrai64/yapcp/issues/234)  
> **Milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)  

---

## 📝 Logica Tecnica

## 📝 Logica Tecnica

### Componente e Flusso di Rimozione

Il componente di cancellazione (`federation-more.remove`) gestisce la rimozione sicura di un campo personalizzato associato a una federazione.

- **Inizializzazione (`mount`)**:
  - Riceve il modello `FederationMore` tramite *route model binding*.
  - Verifica se l'utente autenticato possiede i permessi di amministratore salvando l'esito in `$isAdmin`.
  - Recupera la relazione con la federazione padre (`$this->fedMore->federation`) per gestire correttamente i link di navigazione e i reindirizzamenti.

- **Azione di cancellazione (`removeFederationMore`)**:
  - Esegue un audit log registrando l'ID e il nome dell'amministratore che ha richiesto la rimozione, unitamente ai dati del record da eliminare.
  - Invoca la soft deletion del record tramite `$this->fedMore->delete()`.
  - Reindirizza l'utente alla vista `federation-more.listed` (passando la federazione di riferimento) e impostando un messaggio di successo in sessione (`with('success', ...)`).

- **Protezioni e UI**:
  - La rotta `/federation-more/remove/{federation_more}` è protetta da middleware `auth`, `verified` e dal gate policy `can:delete,federation_more`.
  - Viene mostrata una tabella riassuntiva di riepilogo del campo da eliminare (`referenced`, `field_label`, `field_name`, `field_validation_rules`, ecc.).
  - Presenta una conferma esplicita finale (*"LAST CALL. Are you SURE to delete that?"*) prima di scatenare la submit form.

---

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Nessuna modifica al database (aggiornamento di record FederationMore esistenti)

---

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Nessuna migrazione da eseguire
- Nessun parametro `.env` aggiuntivo richiesto
- Componente accessibile solo agli utenti con ruolo admin (`Auth::user()->isAdmin()`)
- Avviso visivo in rosso nel template per enfatizzare i rischi di cancellazione errata

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
