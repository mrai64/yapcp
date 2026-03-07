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

Valutare e intervenire sulla gestione dei ruoli nella piattaforma, o almeno iniziare la revisione relativament ealle attività di Organization e quindi organization' members, per proseguirla con admin, e federation in seguito.

## 🗄️ Modifiche al Database

*Solo un esempio*  

> <!-- to avoid index -->
- [x] Creata migration `create_xxx_table`
- [ ] Aggiunto campo `status` a `users`
- [ ] Lorem ipsum

## 🚀 Note per il Deploy

*Solo un esempio*  

> <!-- to avoid index -->
- Eseguire `php artisan migrate`
- Aggiungere `STRIPE_SECRET` nel file .env

---

## Day by day

### 7 marzo 2026

la tabella è una *pivot table*, ovvero mette insieme più
tabelle.
Le tabelle di riferimento sono 5:

- user_contacts
- organizations
- contests
- federations
- user_roles_role_sets

[Definizione della tabella user_roles](/database/migrations/2026_02_04_000003_create_user_roles_table.php)

- id
- user_id
- role
- organization_id
- contest_id
- federation_id
- role_opening
- role_closing

In alternativa ci può essere una colonna context che vale
`organizations`, `contests`, `federations`, e un campo con l'id
della tabella relativa.

- id
- user_id
- role
- context
- context_id
- role_opening
- role_closing

Validazioni

1. Per la validazione del record uno e solo uno
tra i campi organization_id, contest_id, federation_id deve essere valorizzato.  

1. Ci sono dei "può/non può", esempio:

- 'members' può organization_id
- 'members' non può contest_id
- 'members' può federation_id
