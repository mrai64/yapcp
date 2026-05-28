# Feature: FederationMore CRUD for admin only

> **Branch:** `feat/0116-federation-more-crud`  
> **Stato:** In Corso
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
Caso tipico: chiedere ai concorrenti i codice tessera della federazione.
Esempio: per l'Italia la locale FIAF chiede anche il Tax ID italiano detto 'codice fiscale'.  

I campi devono essere inseriti con una nuova federazione, ovvero quando
non ci sono ancora concorsi in archivio per la federazione stessa.  
Si dovrebbe quindi inserire una verifica che in _modifica_ e _cancellazione_ 
non siano presenti record nelle tabelle user_contact_mores e user_work_mores.

## 📝 Logica Tecnica

Creare pagine per:

- Creare
- Modificare
- Cancellare

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `create_xxx_table`
- [ ] Aggiunto campo `status` a `users`
- [ ] Lorem ipsum

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
- Aggiungere `STRIPE_SECRET` nel file .env
