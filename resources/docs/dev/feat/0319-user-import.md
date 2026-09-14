# Feature: Admin - Importazione Modelli User, UserContact, UserContactMore

> **Branch:** `feat/0319-user-import`  
> **Stato:** Chiuso  
> **priorità:** A  
> **id assegnato:** 2026-09-13.02  
> **Titolo e urgenza:** (A) feat: Admin Dashboard / Import modelli user, userContact, userContactMore  
> **Project/issue link:** [#319](https://github.com/mrai64/yapcp/issues/319)  
> **Milestone link:** [M5](https://github.com/mrai64/yapcp/milestones/5)

- [📝 Logica Tecnica](#-logica-tecnica)
- [🗄️ Modifiche al Database](#️-modifiche-al-database)
- [👮‍♂️ Pre Merge check](#️-pre-merge-check)
- [🚀 Note per il Deploy](#-note-per-il-deploy)

---

## 📝 Logica Tecnica

L'utente admin attraverso il pannello di amministrazione (Admin Dashboard) può
selezionare e avviare il ripristino / importazone dei dati per i seguenti modelli correlati:

- **User** (modello principale, identificato da id uuid)
- **UserContact** (Dati di contatto, relazione 1:1 con User tramite la chiave id)
- **UserContactMore** (Dati aggiuntivi per federazioni, relazione 1:N collegata a user_id)

###  **Processo di importazione:**

- **Upload e Validazione file**
  - Formati supportati: .yaml, .yml, .txt.  
  - Dimensione massima consentita: 512 KB.  
  - Gestito da componente Livewire Volt SFC con attributo accept corretto e regola di validazione `extensions:yaml,yml,txt|max:512`.  
- Archiviazione temporanea:
  - Salva il file nel disk public nella cartella imports/ (storage/app/public/imports/) mantenendo il nome originale con prefisso timestamp ({timestamp}_{filename}).  
- Esecuzione Job (ImportUserAndRelatedJob):
  - Il Job viene eseguito in modalità sincronizzata (dispatchSync).  
  - Effettua il parsing YAML dei dati tramite la libreria Symfony\Component\Yaml\Yaml.  
  - Applica le modifiche nel database tramite transazioni atomiche (DB::transaction) e metodi withTrashed()->updateOrCreate() per gestire sia nuovi inserimenti che aggiornamenti (upsert).  
  - Gestisce correttamente la relazione 1:N per UserContactMore raggruppando le entità tramite groupBy('user_id').
- Reportistica e Tracciamento Log:
  - Traccia le varie fasi di esecuzione nei log di sistema (Log::info).  
  - Genera un file di report nella stessa cartella del file caricato (storage/app/public/imports/{filename}_report.txt) contenente i dettagli del richiedente, timestamp di esecuzione ed eventuale elenco errori o esito positivo ("All works fine").  

### **Alternativa con scheduler (Cron):**

La logica di importazione è incapsulata all'interno della classe Job,
rendendola riutilizzabile da comandi artisan programmabili tramite
il task scheduler di Laravel.

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
