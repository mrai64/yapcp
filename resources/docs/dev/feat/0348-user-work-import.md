# Feature: Importatore file Yaml editato

> **Branch:** `feat/0348-user-work-import`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-09-17.02  
> **Titolo e urgenza:** (A) feat: Admin / UserWork - create restore for single User  
> **Project/issue link:** [#348](https://github.com/mrai64/yapcp/issues/348)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'importatore elabora file YAML strutturati (`User`, `UserContact`, `UserWork`, `UserWorkMore`) eseguendo un'operazione di **Upsert** sincrona/asincrona tramite `UserWorkAndRelatedImportYamlJob`.

### Caratteristiche Principali

- **Risoluzione Relazioni & Mapping**: Collega `User` e `UserContact` tramite `email`. Permette l'uso di ID temporanei (es. `foto1`) per le opere non ancora create, convertendoli in `UUIDv7` mantenendo i riferimenti verso `UserWorkMore`.
- **Soft Delete & Restore**: Se `deleted_at: restore`, il Job ripristina il record invece di ricrearlo.
- **Gestione Media**:
  - Scarica l'immagine da `url_path`, ne calcola le dimensioni (`width`, `height`, `file_size`, `is_landscape`) e genera una miniatura a 300px.
  - Riorganizza i percorsi storage in base al `country_id` dell'utente.
- **Validazione Dinamica**: Valida `UserWorkMore` confrontando i campi con le regole salvate a DB nella tabella `federation_mores`.
- **Reporting**: Genera un file `{nomefile}_report.txt` nella stessa cartella dello YAML contenente l'esito o l'elenco degli errori bloccanti.

1. Importazione da file formato YAML dei dati delle tabelle

- users,
- user_contacts,
- user_works,
- user_work_mores

1. Upsert Utenti ( model User & UserContact)

- matching tramite id / email
- per nuovi utenti generazione uuidv7
- possibile ripristino record soft-deleted con `deleted_at: restore`
- per nuovi utenti con country_id != ITA spostamento della cartella
  nella cartella del country_id corretto

1. Elaborazione opere (model UserWork)

- Per nuovi utenti matching con `user_id: (email)`
- Tramite un campo `url_path: (url)` consentire il caricamento
  dell'immagine con valorizzazione dei dati e creazione della miniatura
  300px
- per matching con dati delle federazioni uso di id
  personalizzati diversi da uuid (es. 'foto1', 'foto2')

1. Elaborazione dati delle federazioni sulle opere

- matching con userWork tramite id uuid oppure personalizzato - non uuid
- verifica `federation_id` e `field_name` in model FederationMore
- verifica del dato `field_value` tramite regola fornita dal model FederationMore

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
