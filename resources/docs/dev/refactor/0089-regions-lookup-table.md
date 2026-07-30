# Feature: 🇮🇹 Allineamento nome tabella regions

> **Branch:** `refactor/89-regions-lookup-table`  
> **Stato:** Concluso  
> **priorità:** B  
> **id assegnato:** 2025-12-24.01  
> **Titolo e urgenza:** (B) refactor: regions lookup table become timezone_regions lookup table  
> **Project/issue link:** [#89](https://github.com/mrai64/yapcp/issues/89)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Le tabelle di lookup vengono identificate con il nome della tabella
di riferimento, il nome del campo di riferimento e il suffisso Set.

| tabella main     | campo            | tabella lookup                    |
| ---              | ---              | ---                               |
| contests         | vote_rule        | contests_vote_rule_sets           |
| user_roles       | role             | user_roles_role_sets              |
| user_roles       | context          | user_roles_context_sets           |
| federation_mores | referenced_table | federation_mores_referenced_table |

Quando il nome del campo crea una lunghezza eccessiva la regola non viene rispettata.  
La tabella mantiene la s plurale inglese, a differenza
delle tabelle padre-figlio in cui la s della tabella padre viene persa.
(Nota: In effetti non sembra molto importante, la scelta è rivedibile)

## 🗄️ Modifiche al Database

>  <!-- to avoid index -->
- [x] Rinominata migration `create_regions_table` in `create_timezone_region_sets_table`
- [x] Rinominata tabella all'interno della migration
- [x] Rinominata factory e cambiata tabella all'interno
- [x] Rinominata seeder e cambiata tabella all'interno
- [x] Aggiornato migration della tabella timezones per collegare a tabella rinominata  
  Attenzione: il campo collegato dovrebbe ora chiamarsi timezone_region_set_id però  
  si chiama ancora `region_id`
- [x] Creato model TimezoneRegionSet, controller e altro
- [x] travasato non copiato da model Region a model TimezoneRegionSet

## 🚀 Note per il Deploy

>  <!-- to avoid index -->
- Eseguire `php artisan migrate`
- Eseguire `php artisan db:seed`
- Verificare funzionamento blade nella
 funzione di utente / modifica dati personali per la
 scelta della nazione di residenza
