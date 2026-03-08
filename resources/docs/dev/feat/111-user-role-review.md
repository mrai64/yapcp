# Feature: Revisione UserRole

> **Branch:** `feat/111-user-role-review`  
> **Stato:** In Corso  
> **priorità:** B  
> **id assegnato:** 2026-03-07.01  
> **Titolo e urgenza:** (B) feat: UserRole review [id:2026-03-07.01]  
> **Project/issue link:** [#111](https://github.com/mrai64/yapcp/issues/111)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Valutare e intervenire sulla gestione dei ruoli nella piattaforma, o almeno iniziare la revisione relativamente alle attività di Organization e quindi organization' members, per proseguirla con admin, e federation in seguito.  
Creata una tabella di validazione per non assegnare tutti i ruoli a tutti i context.

## 🗄️ Modifiche al Database

*Solo un esempio*  

> <!-- to avoid index -->
- [x] Creata migration `create_user_roles_role_contexts_table`
- [X] Sistemazione Model\UserRolesRolesContext
- [X] Sistemazione factory
- [X] Sistemazione seeder
- [X] Esecuzione seeder
- [X] Registrazione UserRolesRoleContestTableSeeder
- [ ] Lorem ipsum

## 🚀 Note per il Deploy

*Solo un esempio*  

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
- Aggiungere `STRIPE_SECRET` nel file .env

