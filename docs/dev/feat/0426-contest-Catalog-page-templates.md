---
title: 'Feature: Templat eper ContestCatalogPage'
---

> **Branch:** `feat/0426-contest-Catalog-page-templates`  
> **Stato:** In Corso  
> **priorità:** B  
> **id assegnato:** 2026-11-13.01  
> **Titolo e urgenza:** B) feat: ContestCatalogPage / template per catalogo  
> **Project/issue link:** [#426](https://github.com/mrai64/yapcp/issues/426)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

La costruzione dei cataloghi passa per la definizione di template che corrispondano a una versione sobria e minimalista basata sull'interfaccia della piattaforma. Ogni pagina del tempplate deve avere una corrispondenza con le pagine definite come record nel model ContestCatalogPagesLayoutSet (aka ContestCatalogPagesLayoutTypeSet). E quindi: Cover, WinnerWork, AdmitWork, BookPage, Empty, e altre. 
I concorsi possono poi adottare altre pagine purché corrispondano come nome file a quelli del template.


## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

oppure

> <!-- to avoid index in Larecipe -->
- [x] Creata migration `create_xxx_table`
- [ ] Lorem ipsum

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [ ] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [ ] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [ ] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.

oppure

> <!-- to avoid index in Larecipe -->
- Eseguire `php artisan migrate`
- Lorem ipsum
