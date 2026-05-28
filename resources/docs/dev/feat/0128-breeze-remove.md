# Feature: Rimozione Breeze e Migrazione a Jetstream

> **Branch:** `feat/0128-breeze-remove`  
> **Stato:** In Chiusura  
> **Priorità:** A  
> **id assegnato:** 2026-05-14.01  
> **Titolo e urgenza:** (A) feat: Breeze removal and Jetstream integration [id:2026-05-14.01]  
> **Project/issue link:** [#128](https://github.com/mrai64/yapcp/issues/128)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

L'obiettivo principale del branch è la sostituzione del pacchetto `laravel/breeze` (e delle relative implementazioni Volt/Livewire personalizzate) con `laravel/jetstream`. Questa scelta è stata dettata dalla necessità di una gestione più robusta dell'autenticazione, includendo funzionalità "out-of-the-box" come l'autenticazione a due fattori (2FA), la gestione delle sessioni browser e la gestione del profilo utente.

### Interventi principali

- ✅ **Rimozione di Breeze e Volt**: Pulizia dei componenti di autenticazione precedenti.
- ✅ **Integrazione Jetstream/Fortify**: Configurazione del nuovo stack per la gestione dell'auth.
- ✅ **Ripristino Logica UUID**: Adattamento dei modelli e dei controller di Jetstream per supportare l'ID di tipo UUID (string 36) preesistente nel progetto.
- ✅ **Mappatura Rotte**: Gestione della convivenza tra le rotte di Jetstream e quelle custom del progetto. In particolare, è stata creata una rotta `profile.show` come alias o duplicato di `user-contact.show` per garantire la compatibilità con i menu di navigazione standard di Jetstream.
- ✅ **Allineamento User-Contacts**: Risolto il disallineamento email tra la tabella `users` e `user_contacts` emerso durante i test di recupero password.

## 🗄️ Modifiche al Database

La migrazione ha comportato modifiche sostanziali alla tabella `users` tramite l'esecuzione delle migration fornite da Jetstream e Fortify.

### Nuove Colonne in `users`
- `two_factor_secret`: Per la memorizzazione del segreto 2FA.
- `two_factor_recovery_codes`: Codici di recupero per la 2FA.
- `two_factor_confirmed_at`: Timestamp di conferma attivazione 2FA.
- `profile_photo_path`: Percorso per la gestione dell'immagine del profilo (gestita nativamente da Jetstream).
- `current_team_id`: Colonna inserita dal setup standard (da valutare se rimuovere o utilizzare in futuro).

### Correzioni Strutturali
- ✅ Ripristino dell'uso di `dateTime()` o `timestamps()` corretti per coerenza con il resto del DB.
- ✅ Verifica dell'indice UUID come Primary Key.

## 🚀 Note per il Deploy

Dato che l'installazione di Jetstream può sovrascrivere file core e alterare la struttura del DB:

1. **Backup Preventivo**: Eseguire un dump del database prima del merge.
2. **Migration**: Eseguire `php artisan migrate`. In caso di ambiente di dev compromesso, procedere con `php artisan migrate:fresh --seed` per ricostruire la base dati coerente.
3. **Config Clear**: Eseguire `php artisan config:clear` e `php artisan route:clear` per registrare le nuove rotte dinamiche di Fortify/Jetstream.
4. **Test di Regressione**:
    - Verificare il flusso di Registrazione.
    - Verificare il Login.
    - Verificare il Recupero Password (che impatta sia `users` che `user_contacts`).

---

## ⚠️ Ammonizioni e Debito Tecnico

- 🟨 **Team**: Jetstream ha introdotto la logica dei "Team" che al momento non è centrale per yapcp. Le colonne relative sono presenti ma non utilizzate attivamente.
- 🟨 **UI Integration**: Alcuni elementi della UI preesistente sono stati "spianati" dai template di Jetstream e sono stati reintegrati manualmente. Verificare la coerenza stilistica (Tailwind).
```
