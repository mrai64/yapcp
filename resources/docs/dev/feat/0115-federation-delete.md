# Feature: Cancellazione a cascata di Federazione

> **Branch:** `feat/0115-federation-delete`  
> **Stato:** Completato
> **Priorità:** A  
> **ID Assegnato:** 2026-03-23.02  
> **Titolo e Urgenza:** (A) feat: Federation CRUD / delete propagation  
> **Project/Issue Link:** [#115](https://github.com/mrai64/yapcp/issues/115)
> **Milestone Link:** [M3](https://github.com/mrai64/yapcp/milestones/3)

## 📚 Documentazione Correlata

- [🏠 Index](/dev/index)
- [Federation Create](/dev/docs/0185-federation-add)
- [Federation Read](/dev/docs/0184-federation-read)
- [Federation Update](/dev/docs/0186-federation-update)

---

## 📝 Logica Tecnica

### Approccio tramite Job

La cancellazione di una federazione utilizza un **Job asincrono** anziché una eliminazione diretta. Questo per i seguenti motivi:

- **Prevenzione del blocco**: Una federazione può avere una grande quantità di materiale collegato nelle tabelle correlate
- **Stabilità della piattaforma**: Senza un Job, l'uso di `onDelete(cascade)` potrebbe bloccare la piattaforma durante l'eliminazione
- **Performance**: La cancellazione asincrona non impacta le operazioni del sistema in tempo reale
- **Scalabilità futura**: Lo stesso pattern sarà applicato anche per gli aggiornamenti

### Vincoli Foreign Key

Tutte le foreign key sono state sistematizzate con:
- `onUpdate(restrict)` - Impedisce l'aggiornamento di record correlati
- `onDelete(restrict)` - Impedisce l'eliminazione di record correlati

Questo garantisce l'integrità referenziale e evita eliminazioni a cascata non controllate.

## 🗄️ Modifiche al Database

Le seguenti migration sono state create e aggiornate per gestire i vincoli FK:

### Creazione Vincoli

- [x] Migration `mod_fk_to_federation_mores_table` - Ricrea il legame FK con `onUpdate(restrict)` e `onDelete(restrict)`
- [x] Migration `mod_fk_to_federation_sections_table` - Ricrea il legame FK con `onUpdate(restrict)` e `onDelete(restrict)`
- [x] Migration `mod_fk_to_user_contact_mores_table` - Ricrea il legame FK con `onUpdate(restrict)` e `onDelete(restrict)`
- [x] Migration `mod_fk_to_user_roles_table` - Ricrea il legame FK con `onUpdate(restrict)` e `onDelete(restrict)`
- [x] Migration `mod_fk_to_user_work_mores_table` - Ricrea il legame FK con `onUpdate(restrict)` e `onDelete(restrict)`

### Allineamento per migrate:fresh

- [x] Aggiornamento migration `mod_fk_to_federation_mores_table`
- [x] Aggiornamento migration `mod_fk_to_federation_sections_table`
- [x] Aggiornamento migration `mod_fk_to_user_contact_mores_table`
- [x] Aggiornamento migration `mod_fk_to_user_roles_table`
- [x] Aggiornamento migration `mod_fk_to_user_work_mores_table`

### Tabelle Interessate

```
federation
├── federation_sections (onDelete: restrict)
├── federation_mores (onDelete: restrict)
└── user_contact_mores (onDelete: restrict via FK indiretti)
    └── user_roles (onDelete: restrict)
    └── user_work_mores (onDelete: restrict)
```

## 🔧 Implementazione

### Job di Cancellazione

- **Nome:** `DeleteFederationJob` (o analogo)
- **Ubicazione:** `app/Jobs/`
- **Processo:**
  1. Preleva la federazione da eliminare
  2. Elimina i record correlati nelle tabelle slave (sections, mores)
  3. Elimina la federazione stessa
  4. Registra l'operazione nei log

### API Endpoint

- **DELETE** `/api/federations/{id}` - Avvia il Job di cancellazione asincrona
- **Response:** `202 Accepted` - Job messo in coda
- **Status tracking:** Disponibile tramite job queue

## 👮‍♂️ Pre Merge Check

Tutti i seguenti controlli sono stati completati:

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato e completo
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte
- [x] **Cleanup:** Rimossi eventuali `dd()` o `dump()` dimenticati
- [x] **Commit:** I messaggi dei commit sono chiari e descrittivi
- [x] **Migrations:** Tutte le migration sono state testate con `migrate:fresh`
- [x] **Database Integrity:** I vincoli FK sono stati verificati

## 🚀 Note per il Deploy

### Pre-Deploy

1. **Backup Database** - Eseguire un backup completo prima di procedere
   ```bash
   php artisan backup:run
   ```

2. **Esegui Migrations**
   - Ambiente di produzione: `php artisan migrate`
   - Ambiente di sviluppo: `php artisan migrate:fresh` (con seed se necessario)
   ```bash
   php artisan migrate
   ```

3. **Verifica Integrità Database**
   ```bash
   php artisan db:check-constraints
   ```

### Post-Deploy

4. **Esegui Suite di Test**
   ```bash
   php artisan test
   ```

5. **Verifica Job Queue**
   - Assicurarsi che il queue worker sia in esecuzione: `php artisan queue:work`
   - Monitorare i job in fallimento

6. **Monitoraggio**
   - Verificare i log per eventuali errori di eliminazione
   - Monitorare le performance del database dopo le operazioni di delete

### Variabili d'Ambiente

Nessuna nuova variabile d'ambiente richiesta per questa feature.

---

## 📊 Stato Feature

| Aspetto | Status |
|---------|--------|
| Sviluppo | ✅ Completato |
| Test | ✅ Passati |
| Documentazione | ✅ Completa |
| Code Review | ⏳ In Attesa |
| Deploy Staging | ⏳ In Attesa |
| Deploy Production | ⏳ In Attesa |

---

**Ultima Aggiornamento:** 18 Agosto 2026  
**Autore:** mrai64
