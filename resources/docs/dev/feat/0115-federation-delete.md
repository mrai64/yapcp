# Feature: Cancellazione a cascata di Federazione

> **Branch:** `feat/0115-federation-delete`  
> **Stato:** In Corso
> **priorità:** A  
> **id assegnato:** 2026-03-23.02  
> **Titolo e urgenza:** (A) feat: Federation CRUD / delete propagation  
> **Project/issue link:** [#115](https://github.com/mrai64/yapcp/issues/115)
> **milestone link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

- [🏠 index](/{{route}}/dev/index)
- [Federation Create](/{{route}}/dev/docs/0185-federation-add)
- [Federation Read](/{{route}}/dev/docs/0184-federation-read)
- [Federation Update](/{{route}}/dev/docs/0186-federation-update)

---

## 📝 Logica Tecnica

Uso un Job perché se una federazione viene ritirata dalla piattaforma potrebbe avere molto
materiale collegato nelle tabelle correlate, e questo con il legame sql ondelete(cascade)
può bloccare la piattaforma stessa. Andrà fatto un gemello per le update.  
Inoltre è stata sistemata per tutte le creazioni di fk nelle migration inserendo
per tutte onUpdate(restrict) onDelete(restrict), e creando 5 modifiche 

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `mod_fk_to_federation_mores_table` per cancellare e ricreare il legame
- [x] Creata migration `mod_fk_to_federation_sections_table` per cancellare e ricreare il legame
- [x] Creata migration `mod_fk_to_user_contact_mores_table` per cancellare e ricreare il legame
- [x] Creata migration `mod_fk_to_user_roles_table` per cancellare e ricreare il legame
- [x] Creata migration `mod_fk_to_user_work_mores_table` per cancellare e ricreare il legame
- [x] Aggiornata migration `mod_fk_to_federation_mores_table` per allinearlo in caso di migrate:fresh
- [x] Aggiornata migration `mod_fk_to_federation_sections_table` per allinearlo in caso di migrate:fresh
- [x] Aggiornata migration `mod_fk_to_user_contact_mores_table` per allinearlo in caso di migrate:fresh
- [x] Aggiornata migration `mod_fk_to_user_roles_table` per allinearlo in caso di migrate:fresh
- [x] Aggiornata migration `mod_fk_to_user_work_mores_table` per allinearlo in caso di migrate:fresh

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire `php artisan migrate` o in caso di ambiente d sviluppo `php artisan migrate:fresh`
- Eseguire i test per verificare
- Aggiungere `STRIPE_SECRET` nel file .env
