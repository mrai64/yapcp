# Feature: Federation More +synopsis e listed

> **Branch:** `feat/0353-federation-more`  
> **Stato:** Chiuso  
> **priorità:** B  
> **id assegnato:** 2026-09-19.04  
> **Titolo e urgenza:** (B) feat: FederationMore / Federation "one more field" list  
> **Project/issue link:** [#353](https://github.com/mrai64/yapcp/issues/353)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Viene visualizzata una lista dei campi definiti nel model `FederationMore`
al fine di consentire a un membro del gruppo admin di verificare o
costruire un file YAML utile a caricare o ripristinare dati 
nel model UserContactMore e/o UserWorkMore.
I campi esposti sono quelli della tabella `federation_mores`:

- **federation_id**  presente nella tabella delle federazioni 
- **field_label**    quella che appare alla richiesta dato, ma online
- **referenced**     inteso come tabella a cui farà capo il dato in seguito 
- **field_name**     quello che poi sarà usato
- **field_default_value** il valore predefinito che viene usato in SOSTITUZIONE del dato in tabella
- **field_suggest**  il suggerimento che viene fornito online per la compilazione del campo
  e che, con poche parole, lo descrive
- **field_validation_rules** una stringa che codifica, secondo lo standard del framework Laravel,
  come il dato sarà verificato prima di essere registrato o scartato. Il dato, effettivamente
  tecnico, è spesso intuibile. Possono essere presenti delle espressioni regolari.

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
