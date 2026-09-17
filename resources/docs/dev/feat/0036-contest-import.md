# Feature: Nome Funzione

> **Branch:** `feat/0036-contest-import`  
> **Stato:** In Corso / Revisione / Chiuso  
> **priorità:** C  
> **id assegnato:** 2025-10-18.01  
> **Titolo e urgenza:** Quello riportato nel project, solo senza [id...]  
> **Project/issue link:** [#36](https://github.com/mrai64/yapcp/issues/36)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'utente admin attraverso il pannello di amministrazione (Admin Dashboard) può selezionare e avviare un processo di esportazione/backup dei dati relativi ai modelli:

- **Contest**
- **ContestAward**
- **ContestJury**
- **ContestPatronage**
- **ContestSection**
- **Organization**

###  **Processo di esportazione:**

- Il file generato è in formato **YAML** e contiene i campi dei modelli specificati
- Il file viene salvato nella sezione **private dello storage** (non condiviso con terzi)
- L'esportazione può essere avviata manualmente tramite pulsante nel Dashboard Admin
- L'azione è registrata nei **log di sistema**
- Il file esportato contiene anche le informazioni su **chi ha effettuato la richiesta**

### **Alternativa con scheduler (Cron):**

- La stessa funzione può essere eseguita automaticamente via Cron
- In caso di esecuzione programmata, inviare notifiche al gruppo admin
- Notificare quando l'operazione inizia e quando si conclude

## 🗄️ Modifiche al Database

Nessuna modifica necessaria al database.

## 👮‍♂️ Pre Merge check

> <!-- to avoid index in Larecipe -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [x] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?
- [x] **Manual:** Il manuale utente riflette le modifiche introdotte?
- [x] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?
- [x] **Commit:** I messaggi dei commit sono chiari?

## 🚀 Note per il Deploy

Niente di particolare, nessuna migrazione o azione speciale richiesta al deploy.
