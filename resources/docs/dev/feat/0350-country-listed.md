# Feature: Admin Country List

> **Branch:** `feat/0350-country-listed`  
> **Stato:** In Corso  
> **priorità:** B  
> **id assegnato:** 2026-09-19.01  
> **Titolo e urgenza:** (B) feat: Country / Country code list  
> **Project/issue link:** [#350](https://github.com/mrai64/yapcp/issues/350)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Viene esposta la *lookup tabel* dei paesi e nazioni, perché
può servire indicare il codice paese corretto se si associa
alla per esempio SWI alla Svizzera quando invece è CHE
Confederation Helvetique.
Esposti: id, country, flag_code, l'unicode corrispondente alla bandiera

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
