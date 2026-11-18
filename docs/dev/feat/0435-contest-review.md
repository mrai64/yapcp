---
title: 'Feature: Nome Funzione'
---

# Feature: Nome Funzione

> **Branch:** `feat/0435-contest-review`  
> **Stato:** In Corso  
> **priorità:** A  
> **id assegnato:** 2026-11-16.01  
> **Titolo e urgenza:** Quello riportato nel project, senza id  
> **Project/issue link:** [#435](https://github.com/mrai64/yapcp/issues/435)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

Per l'organizzazione che crea i concorsi può gestire con poche differenze
anche la struttura dei circuiti, ovvero concorsi che condividono
lo stesso regolamento e gli stessi temi e sezioni, con una sola
segreteria, ma giurie distinte e indipendenti.
Come l'organizzazione crea una prima scheda del concorso, Così deve poter fare
anche per il circuito. Liberamente, prima il circuito e poi i concorsi,
prima i concorsi e infine il circuito, e modificando i concorsi perché
"stiano nel" circuito. Liberamente.

La definizione del circuito ha molti punti in comune ma non tutti
con i concorsi. Ha un titolo e una organizzazione, ha temi e sezioni
ma la sua giuria (eventuale) non è sui temi e sezioni, i suoi premi
(eventuali ma di solito ci sono) non sono di tema e sezione.

Funzione comoda per i circuiti è che se viene definito prima dei
concorsi, questi "riprendono" i temi e sezioni dal circuito.
E anche la partecipazione, essendo per circuito, produce l'inserimento
di N record (uno per concorso, uno per giuria) al colpo.
E anche la creazione del verbale deve essere indipendente, non legata
alla creazione dei concorsi.

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
