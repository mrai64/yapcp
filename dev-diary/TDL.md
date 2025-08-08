# To Do List

Obiettivo generale: realizzare una piattaforma per la gestione dei concorsi fotografici
in uso a 4 gruppi: *organizzatori*, *concorrenti*, *giurati* e *controllori*.

## Prossime cose da fare

- [ ] factory per caricare user
- [ ] factory per caricare elenco paesi
- [ ] tenere aggiornata la lista

## Lista generale di cose fatte e da fare

### sistema - alla base del resto 

- [ ] Definire una gestione dell'internazionalizzazione i18n(text)

### Users - utenti, persone

Pagine e funzioni per gli utenti, a prescindere dal ruolo. Cosa deve fare un utente:

- iscriversi alla piattaforma
  - [ ] route /users/add get
  - [ ] view users/add
  - [ ] route /users/add post
  - [ ] controller users/add
- fare il login
  - ricevere notifiche sui login
- fare logout
- modificare la propria anagrafica
  - [ ] route /users/mod/{id} get
  - [ ] view users/mod
  - [ ] route /users/mod/{id} post
  - [ ] controller users/mod/{id}
- consultare il proprio deposito immagini
- caricare immagini nel proprio deposito
- selezionare un concorso dall'elenco
- inserire il proprio circolo organizzatore
- altro, segue

- [ ] pulsante recupera password /users/pass_recovery get
- [ ] route modifica password /users/pass_recovery post
- [ ] modulo login user /login get
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

## Come si fa a fare?

- Recupero della lezione login logout
- messaggi dal sistema guidati dal browser in italiano e in inglese.

## Cose già fatte

Nota: *Mettere in testa le date più recenti*

- 2025-08-04 TDL aggiornamento con aggiunta di tabelle
- 2025-07-26 TDL (questa), aperta ieri aggiornata oggi.
