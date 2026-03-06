# Fix: UserRoleSeeder bring an integrity constrain violation [id:2026-03-06.01]

> **Branch:** `fix/107-user-role-seeker-ko`  
> **Stato:** Completato
> **priorità:** A  
> **id assegnato:** 2026-03-06.01  
> **Titolo e urgenza:** (A) fix: UserRoleSeeder bring an integrity constrain violation [id:2026-03-06.01]  
> **Project/issue link:** [#107](https://github.com/mrai64/yapcp/issues/107)

## 📝 Logica Tecnica

Occorre verificare se la segnalazione arriva al primo inserimento record
oppure all'ennesimo, e capire perché.  
Fatto: Modificata la valorizzazione dei codici che quindi se sono impostati
passano ma se sono stringa vuota il campo viene impostato a null.

## 🗄️ Modifiche al Database

- [ ] Nessuna

## 🚀 Note per il Deploy

- Nessuna
