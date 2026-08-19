# Feature: Contest Patronage (confronto feat/0208-contest-patronage vs feat/0114-federation-delete-policy)

> **Branch:** `feat/0208-contest-patronage` (confrontato con `feat/0114-federation-delete-policy`)  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-08-18-01  
> **Titolo e urgenza:** (A) feat: ContestPatronage replace contest.federation_list  
> **Project/issue link:** [#208](https://github.com/mrai64/yapcp/issues/208)

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Scopo: sostituire l'uso di un campo testo libero `contests.federation_list` con una rappresentazione relazionale (tabella `contest_patronages`) per poter:

- rappresentare più federazioni che patrocinano uno stesso concorso (N:M),
- associare un solo codice di patrocinio per ogni coppia (federation, contest),
- abilitare relazioni Eloquent chiare (Contest -> ContestPatronages -> Federation) e query dirette da Federation verso i suoi contest.

Perché:

- I campi di testo libero sono inefficaci per query, indici e integrità referenziale.
- Serve garantire integrità referenziale (fk con onUpdate/onDelete restrittivi) e indici univoci per evitare duplicazioni.
- Implementazione Eloquent:
  - Nuovo model ContestPatronages con relazioni belongsTo() verso Contest e Federation.
  - Contest aggiunge relazione contestPatronage(): HasMany.
  - Federation aggiunge contestPatronages(): HasMany e contests(): BelongsToMany tramite la tabella `contest_patronages` (withPivot('patronage_code') e timestamps).
  - Federation.activeContests(): BelongsToMany con filtro sulle date di apertura/chiusura per trovare i concorsi attivi.

Test:

- Aggiunto test Feature FederationActiveContestTest che fissa la data con Carbon::setTestNow(), crea una federation, vari contest (aperti/chiusi/futuri) e associa le righe in `contest_patronages`; verifica che activeContests() ritorni il conteggio atteso.

Note progettuali:

- La colonna originale `contests.federation_list` non è rimossa in questa PR: la cancellazione è rimandata ad altra issue perché richiede aggiornamenti alle view/blade e alla UX del form di progettazione del concorso.
- Le relazioni sono progettate con comportamento restrittivo sulle cancellazioni (onDelete('restrict')) per evitare cancellazioni accidentali: la cancellazione di una federazione dovrà essere orchestrata (job) per rimuovere prima i derivati.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
- [x] Creata migration `create_contest_patronages_table` (database/migrations/2026_02_22_220039_create_contest_patronages_table.php)
- [ ] Rimozione della colonna `federation_list` da `contests` (posticipata)

Dettagli migration `contest_patronages`:

- Colonne:
  - `id` (uuid/char)
  - `contest_id` CHAR(36) ASCII (index, comment: fk for contests id)
  - `federation_id` VARCHAR(10) ASCII (index, comment: fk federations id)
  - `patronage_code` VARCHAR(20) ASCII (codice opzionale/set di riferimento)
  - `created_at` useCurrent, `updated_at` useCurrentOnUpdate, (soft deletes non espliciti nella migration ma il model usa SoftDeletes)
- Indici/Unique:
  - unique(['contest_id', 'federation_id'], 'con_fed_idx')
  - unique(['federation_id', 'patronage_code'], 'fed_cod_idx')
- Foreign keys:
  - `contest_id` references `contests.id` ON UPDATE RESTRICT ON DELETE RESTRICT
  - `federation_id` references `federations.id` ON UPDATE RESTRICT ON DELETE RESTRICT
- Commento tabella: "list of federation sponsor code"

Aggiornamenti ai models:

- app/Models/ContestPatronages.php
  - nuovo model con relazioni contest(): BelongsTo e federation(): BelongsTo
- app/Models/Contest.php
  - aggiunta relazione contestPatronage(): HasMany
  - docblock aggiornato per riflettere la relazione contestPatronage e i conteggi
- app/Models/Federation.php
  - aggiunta contestPatronages(): HasMany
  - aggiunta contests(): BelongsToMany via table `contest_patronages` con withPivot('patronage_code') e withTimestamps()
  - aggiunta activeContests() che applica filtro sulle date (whereDate day_1_opening <= today e whereDate day_8_closing >= today)

Seeder:

- database/seeders/UserSeeder.php aggiornato per aggiungere un utente noto (<maria.rossi@athesis77.it>) oltre ai 25 utenti generati.

Test:

- tests/Feature/m003/i0208/FederationActiveContestTest.php aggiunto per coprire il comportamento activeContests().

## 👮‍♂️ Pre Merge check

- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte? No perché la modifica no interessa UX utente
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

> <!-- to avoid index -->
- Eseguire in ambiente di sviluppo/CI:
  - php artisan migrate (se il DB è in uno stato coerente)
  - Se si parte da DB di sviluppo incoerente, eseguire migrate:fresh (attenzione: distrugge i dati) e poi db:seed
    - Nel diario di sviluppo viene segnalata la *cancellazione della cartella foto utenti* 
      e l'esecuzione di migrate:fresh + db:seed per i test locali.
- Verificare:
  - che i riferimenti a `contests.federation_list` nelle view/blade o nei controller siano aggiornati o gestiti (per ora la colonna resta in place, ma la UI potrebbe essere aggiornata successivamente)
  - se sono già presenti concorsi valutare se sia da fare una migrazione manuale o automatica, e la fattibilità;
  - permessi e restrizioni sulle FK; la strategia onDelete('restrict') richiederà un job/flow per rimuovere federazioni in produzione
- ENV:
  - Nessuna nuova variabile d'ambiente specifica; seguire le note generali del deploy del progetto.
- Rollback:
  - Per rollback delle modifiche DB è necessario prevedere una migration inversa che droppa `contest_patronages` e rimuove eventuali usi nelle relazioni; attenzione ai dati: migrare indietro potrebbe perdere mapping patronage -> contest.

---

## Checklist rapido (per reviewer / deployer)

- [x] Migration `create_contest_patronages_table` presente e coerente
- [x] Models aggiornati: Contest, Federation, ContestPatronages
- [x] Test automatici aggiunti e passati localmente (FederationActiveContestTest)
- [x] Seeder aggiornato (aggiunta utente di test)
- [ ] Aggiornare le view e i form per rimuovere l'uso di `federation_list` quando si decide la rimozione della colonna
- [ ] Predisporre job/orchestrazione per cancellazione Federations (per rispettare restrizioni FK)

---

## Link utili

- Diff confronto: <https://github.com/mrai64/yapcp/compare/feat/0114-federation-delete-policy...feat/0208-contest-patronage>
- Migration creata: database/migrations/2026_02_22_220039_create_contest_patronages_table.php
- Test aggiunto: tests/Feature/m003/i0208/FederationActiveContestTest.php
