# Feature: Admin - Backup Modelli User, UserContact, UserContactMore

> **Branch:** `feat/0318-user-backup`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-13.01  
> **Titolo e urgenza:** (A) feat: Admin DashBoard / Backup modelli User, UserContact, UserContactMore  
> **Project/issue link:** [#318](https://github.com/mrai64/yapcp/issues/318)  
> **Milestone link:** [M4](https://github.com/mrai64/yapcp/milestones/4)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'utente admin attraverso il pannello di amministrazione (Admin Dashboard) può selezionare e avviare un processo di esportazione/backup dei dati relativi ai modelli:

- **User**
- **UserContact**
- **UserContactMore**

###  **Processo di esportazione:**

- Il file generato è in formato **YAML** e contiene tutti i campi dei modelli specificati
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
