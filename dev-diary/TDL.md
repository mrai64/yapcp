# To Do List

Obiettivo generale: realizzare una piattaforma per la gestione dei concorsi fotografici
in uso a 4 gruppi: *organizzatori*, *concorrenti*, *giurati* e *controllori*.

## Prossime cose da fare

- [ ] tenere aggiornata la lista
- [ ] tenere aggiornato (./index.md)
- [ ] ripulire web.php perché ci sono controller e ci sono funzioni in linea,
  molto meglio che tutto sia nei controller

## Lista generale di cose fatte e da fare

### sistema - alla base del resto

- [ ] i18n __() Visto che la funzione potrebbe esserci già, dove sta?
  Come si può impostare il codice perché sia usabile ovunque?
  
### Users - utenti, persone

- [ ] aggiungere alla tabella Users il cognome i dati di residenza e telefono internazionale,
  attualmente ci sono solo user id name e password
- [ ] modificare la pagina di iscrizione, creare la pagina di modifica dei dati personali.

Pagine e funzioni per gli utenti, a prescindere dal ruolo. Cosa deve fare un utente:

- iscriversi alla piattaforma
  - [X] route /users/add get
  - [X] view users/add
  - [X] route /users/add post
  - [X] controller users/add
- fare il login
  - [X] route /login
  - [X] modulo login user /login get
  - [X] route /logout
  - [X] link-pulsante login
  - [X] modulo-pulsante logout
  - [ ] ricevere notifiche sui login
  - [ ] route /users/recovery_pass
  - [ ] modulo recupera password
  - [ ] route get /users/recovery/{hash} verifica
  - [ ] router post /users/recovery modulo modifica password

- fare logout
  - [X] controller /logout

- modificare la propria anagrafica
  - [X] route /users/mod/{id} get
  - [X] view users/mod
  - [ ] route /users/mod/{id} post
  - [ ] controller users/mod/{id}
- consultare il proprio deposito immagini
- caricare immagini nel proprio deposito
- selezionare un concorso dall'elenco
- inserire il proprio circolo organizzatore
- altro, segue

- [ ] modulo scelta del ruolo se ne ha più di uno
- [ ] link logout user /logout

### UserRoles - i ruoli degli utenti

Una persona presente in piattaforma può essere (anche al passato)
inserita come concorrente di un concorso, organizzatore di un concorso
giurato di un concorso, controllore di un concorso.  
Questi ruoli determinano anche l'abilitazione a vedere solo il proprio
oppure anche altro.

- [ ] definire il model, e un enum degli stati

### Organizzatori di concorsi

Si tratta di una anagrafica, che comprende il nome dell'ente
organizzatore, uno o più persone referenti (una deve essere
inserita in piattaforma con ruolo organizzatore )

### Concorsi

Il concorso ha una serie di caratteristiche che diventano

- Le anagrafiche dei concorsi
  - Chi organizza
  - Nome del concorso
  - modalità di partecipazione (quanti soldi e come inviarli)
  - calendario delle date
  - link alla pagina del bando e regolamento
  - link alla pagina di iscrizione
  - link alla pagina delle comunicazioni risultati
  - link alla pagina dei cataloghi

### Concorsi - elenco temi e sezioni

- elenco dei premi extra-sezioni
- elenco dei temi e sezioni
  - elenco dei giurati
  - elenco dei premi

### un due, un due, un due

- risolvere l'uso di singolare plurale
  - model User Country
  - table users countries plurale
  - controller UserController CountryController
  - factory UserFactory CountryFactory
  - seeder UserSeeder CountrySeeder

- elenco iso 3 lettere 2 lettere, caricare con seeder

## Come si fa a fare?

- Recupero della lezione login logout
- messaggi dal sistema guidati dal browser in italiano e in inglese.

## Cose già fatte

Nota: *Mettere in testa le date più recenti*

- 2025-08-04 TDL aggiornamento con aggiunta di tabelle
- 2025-07-26 TDL (questa), aperta ieri aggiornata oggi.
