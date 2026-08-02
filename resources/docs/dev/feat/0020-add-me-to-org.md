# Feature: Aggiungimi a una organizzazione già presente

> **Branch:** `feat/0020-add-me-to-org`  
> **Stato:** In Corso
> **priorità:** A  
> **id assegnato:** 2025-10-08.01  
> **Titolo e urgenza:** (A) feat: User dashboard / Add me to Organization already in  
> **Project/issue link:** [#20](https://github.com/mrai64/yapcp/issues/20)

Dal *suo cruscotto* l'utente passa all'*elenco delle organizzazioni*,
e per ciascuna un link / pulsante "add me to" gli consente di passare per un
pannello di richiesta conferma, e quindi andare ad aggiungersi
come "member", o un altro ruolo tra quelli consentiti, all'Organizzazione.

- [🏠 index](/{{route}}/dev/state-of-art)
- [template](/{{route}}/dev/template)

---

## 📝 Logica Tecnica

Viene creato in link pulsante bottone nella lista delle organizzazioni, questo passa a una richiesta di conferma
compreso il ruolo assunto, 
e in caso di conferma va ad aggiornare o creare un record nel model UserRole.
Nel record le date inizio /scadenza vanno impostate ai dati di default.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
Non sono previste modifiche al database

## 👮‍♂️ Pre Merge check

niente da dichiarare.

> <!-- to avoid index -->
- [x] **Test:** Tutti i test (nuovi ed esistenti) passano in verde (`php artisan test`)?
- [X] **Docs:** Il file in `/resources/docs/dev/` è aggiornato?  
  Sì.
- [X] **Manual:** Il manuale utente riflette le modifiche introdotte?  
  Sì, mancavano e sono stati realizzati. Con l'occasione è stato
  aggiornato gitignore per aggiungerli anche in futuro
- [X] **Cleanup:** Ho rimosso eventuali `dd()` o `dump()` dimenticati?  
  Non sono stati usati dd(), o ds(), o se c'erano sono stati rimossi.
- [X] **Commit:** I messaggi dei commit sono chiari?
  Sì.

## 🚀 Note per il Deploy

> <!-- to avoid index -->
niente in particolare