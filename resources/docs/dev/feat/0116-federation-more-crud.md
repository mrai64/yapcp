# Feature: FederationMore CRUD for admin only

> **Branch:** `feat/0116-federation-more-crud`  
> **Stato:** In Chiusura
> **priorità:** B  
> **id assegnato:** 2026-04-07.01  
> **Titolo e urgenza:** (B) feat: FederationMore CRUD for admin only [id:2026-04-07.01]  
> **Project/issue link:** [#116](https://github.com/mrai64/yapcp/issues/116)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Generalità

Anche per sperimentare e imparare livewire 4, Il model FederationMore necessita
delle pagine per creare o modificare i record del model. A livello di abilitazione
questi devono essere accessibili solo ai membri del gruppo admin.  
Finora non sono state create perché sono record _molto statici_, ovvero
per ogni federazione / organizzazione nazionale e internazionale che
ai dati anagrafici dei concorrenti o delle opere chiede "dei dati in più".
E, finora, sono sempre stati inseriti direttamente nel DB con un programma
di interfaccia per mysql.
Caso tipico: chiedere ai concorrenti i codice tessera della federazione.
Esempio: per l'Italia la locale FIAF chiede anche il Tax ID italiano detto 'codice fiscale'.  

I campi devono essere inseriti con una nuova federazione, ovvero quando
non ci sono ancora concorsi in archivio per la federazione stessa.  
Si dovrebbe quindi inserire una verifica che in _modifica_ e _cancellazione_ 
non siano presenti record nelle tabelle user_contact_mores e user_work_mores.

## 🖥️ Pannelli e Componenti

Sono stati implementati i seguenti componenti Livewire (namespace `App\Livewire\Admin\FederationMore`):

- ✅ **Index**: Elenco tabellare di tutte le configurazioni di campi extra attivi per federazione.
- ✅ **Create**: Form per la definizione di nuovi parametri (es. Codice Fiscale, Numero Tessera).
- ✅ **Edit**: Modifica delle etichette e delle regole di validazione dei campi esistenti.
- ✅ **Delete**: Procedura di rimozione sicura con controllo dei vincoli di integrità.

Le rotte sono protette tramite middleware `auth` e verificate dalla `FederationMorePolicy`.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata tabella lookup `federation_mores_referenced_tables`
- [x] Creata colonna `federation_mores.referenced_table` (string 40) - Contiene il nome fisico della tabella dati (es. `user_contact_mores`).
- [x] Registrazione `FederationMoresReferencedTableSeeder` nel seeder principale per i valori di lookup (users/works).

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire le migrazioni: `php artisan migrate`.
- Popolare la tabella di lookup: `php artisan db:seed --class=FederationMoresReferencedTableSeeder`.
- Aggiornare la cache delle rotte e delle viste: `php artisan route:cache && php artisan view:cache`.

---

## 🛠️ Manutenzione e Vincoli

### Gestione Integrità Dati
Data la natura critica dei metadati (che collegano i partecipanti ai loro dati specifici di federazione), sono stati implementati i seguenti vincoli logici:

1. **Protezione dalla Cancellazione**: Non è consentito eliminare un record di `FederationMore` se esistono già righe associate nelle tabelle `user_contact_mores` o `user_work_mores`. Questo evita la perdita di informazioni storiche nei concorsi già chiusi.
2. **Immutabilità della Tabella di Riferimento**: Il campo `referenced_table` non è modificabile in fase di `Edit` se il record è già in uso, per prevenire disallineamenti tra i dati degli utenti e quelli delle opere.

### Note di Sviluppo
Il sistema è predisposto per Livewire 3/4. Per aggiungere nuove tabelle di riferimento in futuro, è sufficiente censire il nome della nuova tabella fisica in `federation_mores_referenced_tables`. Il Model `FederationMore` gestisce il controllo di integrità in modo dinamico tramite la colonna `referenced_table`.
