# Fix: UserRoleSeeder bring an integrity constrain violation [id:2026-03-06.01]

> **Branch:** `fix/107-user-role-seeker-ko`  
> **Stato:** Completato  
> **priorità:** A  
> **id assegnato:** 2026-03-06.01  
> **Titolo e urgenza:** (A) fix: UserRoleSeeder bring an integrity constrain violation [id:2026-03-06.01]  
> **Project/issue link:** [#107](https://github.com/mrai64/yapcp/issues/107)


- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Occorre verificare se la segnalazione arriva al primo inserimento record
oppure all'ennesimo, e capire perché.  
Verifica: Con echo.  
Fatto: Modificata la valorizzazione dei codici per le colonne
organization, contest, federation: se sono impostati
passano, ma se sono/restano stringa vuota, il campo viene impostato a null. Inoltre se tutti i campi fossero alla fine null viene impostato un federation id.

## 🗄️ Modifiche al Database

>  <!-- to avoid index -->  
- [ ] Nessuna

## 🚀 Note per il Deploy

>  <!-- to avoid index -->  
- Nessuna
