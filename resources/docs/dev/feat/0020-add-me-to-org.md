# Feature: Aggiungimi a una organizzazione già presente

> **Branch:** `feat/0020-add-me-to-org`  
> **Stato:** Chiuso
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

> <!-- to avoid index -->
Dal cruscotto utente si accede all'elenco delle organizzazioni già registrate.
Per ciascuna organizzazione

- Aggiornata la vista blade livewire.organization.listed.blade.php  
  aggiungendo un link per aggiungere l'utente all'organizzazione
- Aggiornata la vista blade livewire.organization.user.add.blade.php  
  precedentemente era solo un segnaposto, è stata realizzata
  con la funzione di chiedere qual è il ruolo che utente svolge in organizzazione
- Modelli coinvolti in scrittura: UserRole
- Altri modelli coinvolti in lettura: Organization, UserContact,
  UserRolesRoleContext, UserRolesContextSet
- i valori di role_opening e role_closing vengono impostati
  rispettivamente a now() e a '9999-12-31 23:59:59'
- Eventuali record con la stessa chiave user / organization
  vengono modificati nei valori role_opening e/o role_closing per
  non sovrapporsi a quello inserito che ha la precedenza.

## 🗄️ Modifiche al Database

> <!-- to avoid index -->
Non sono state fatte modifiche al database.

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
Niente in particolare
