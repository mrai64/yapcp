---
title: 'Feature: Contest Design / Circuit web links add'
---

> **Branch:** `feat/0440-contest-circuit-url`  
> **Project/issue link:** [#440](https://github.com/mrai64/yapcp/issues/440)  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-11-24.01  
> **Titolo e urgenza:** (A) feat: Organization / Contest Design / Contest - Circuit Add / 3 web links  
> **Milestone link:** [M7](https://github.com/mrai64/yapcp/milestones/7)
> **Autori:** mrai64, Antigravity

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'inserimento dei dati principali del Circuito, che vengono registrati nel model Contest, richiede anche l'aggiornamento di alcuni link.

- **Gestione dei link del circuito:** il componente Volt `resources/views/livewire/organization/design/circuit/modify-url.blade.php` viene aggiornato per presentare i campi come riferiti al circuito:
  - regolamento del circuito (`url_1_rule`);
  - bacheca partecipanti (`url_2_concurrent_list`);
  - risultati del circuito (`url_3_admit_n_award_list`);
  - catalogo, quando pubblicato (`url_4_catalogue`).

  Il componente carica e salva i valori sul modello `Contest`, usando i campi già esistenti. Tutti e quattro i campi restano obbligatori e validati con `required|active_url|string|max:255`. Dopo il salvataggio, la pagina reindirizza alla rotta `organization.design.circuit.modify-url` e mostra un messaggio di conferma.

- **Navigazione e interfaccia:** la schermata usa la navigazione del circuito (`circuit-nav`) e una navigazione Livewire del circuito, anziché quelle del concorso. Sono inoltre aggiornati i testi per distinguere il regolamento e i risultati del circuito da quelli del singolo concorso.

- **Rotta:** la rotta `organization.design.circuit.modify-url` è presente nel confronto e usa il percorso `/organization/design/circuit/modify-url/{contest}`, con middleware `auth` e `verified`. La modifica del componente ne allinea il redirect alla rotta del circuito. Il parametro e la proprietà sono ancora tipizzati come `Contest`, coerentemente con il modello che rappresenta anche i circuiti nell’implementazione corrente.

- **Documentazione utente:** vengono aggiunte le pagine per la modifica del circuito e per i link web, ampliate le schermate illustrate della pagina di creazione e collegata alla navigazione la pagina di creazione del circuito.

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [ ] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [ ] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.

