# Feature: Revisione UserRole

> **Branch:** `feat/0111-user-role-review`  
> **Stato:** In Chiusura  
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

### Lavoro _fatto male_ nel senso che

Sono stati fatti interventi "in più", volontariamente, rendendo di fatto
questo branch un sostitutivo dello sviluppo e revisione di quanto fatto finora,
compresi:

- ✅ Assegnata quasi a tutte le route una Policy  
  (ok, era nel focus)
- ✅ Nelle policy definiti i ruoli di chi può,
  anche aggiustando il Model User che prevede
  funzioni isQualcosa, tipo _isAdmin_, _isMemberOfOrganization_,
  _isJurorOfContest_, etc.
- 🟨 Ai Model privi di Policy assegnati tutti i file a corredo  
  (ammonizione: se anche possono servire domani, file non usati ma anche no)
- 🟨 Sostituiti molti input da string $var_uuid nei Model $model,  
  (ammonizione perché esula dallo user role)
  da cui anche sfilati _accessi in più_ che dall'id string andavano a pescare
  i Model che arrivano gratis dalla route
- 🟨 in alcuni casi revisionati i moduli per evidenti problemi
  di _N+1 Query_  
  (ammonizione, anche questo esula dallo user role)

La lista è estremamente lunga.

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

