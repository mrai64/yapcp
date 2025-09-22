# `To Do List`

Tenere aggiornato il [diario dello sviluppatore](./index.md)  
Tenere aggiornato il [diario dello sviluppatore](./index.md)  
Tenere aggiornato il [diario dello sviluppatore](./index.md)  

## Prossime attività

* [ ] Preparare il modulo Concorsi Sezioni / Add  

## Generale - a seguire

* [ ] Preparare il modulo Concorsi Sezioni / Modify  
* [ ] Preparare il modulo Concorsi Giurie / Add  
* [ ] Preparare il modulo Concorsi Giurie / Modify
* [ ] Concorsi Modifica  
Aggiungere una variabile basata sulla data
che discrimini i campi readonly o modificabili/required.
* [ ] Creare una barra di navigazione Principale / Sezioni / Giurie ecc.
* [ ] Refactory EXCERPTUM va cambiato con SYNOPSIS in FederationSections

### Organizzatori

* [ ] nella dashboard delle organizzazioni sistemare
i concorsi dividendoli tra "quelli in progetto", "quelli in corso"
e "quelli conclusi". Evitare il semaforo verde arancio rosso.
* [ ] User Roles / Add e Modify  
Cambiare il campo di Role in un select, no testo libero.

### Concorsi

Completare il giro dei concorsi. Oltre al pannello principale
ci deve essere un pannello Vista che riassume tutti i campi
definiti in una sola scheda, per quanto lunga.  
La definizione del concorso e del circuito concorsi passa da più fasi:

1. definire il concorso: organizzatore, nome, calendario, patrocini (idem per i circuiti), quote di partecipazione
2. definire le sezioni del concorso (il circuito non ne ha)
3. definire le giurie del concorso (il circuito non ne ha)
4. definire i premi del concorso (del circuito), e delle sezioni del concorso (non ci sono premi di sezione per i circuiti)
5. ricavare da quanto sopra il testo di una bozza di regolamento che sia inviabile agli enti sponsor.

* [ ] Concorsi principale / add  
manca il caricamento del marchio
* [ ] Concorsi principale / modify  
manca il caricamento del marchio
* [ ] concorsi/ sezioni / add  
Il modulo va presentato se nel se il record principale NON è marcato come is_circuit
* [ ] concorsi / premi / add  
Da fare, possono esserci premi legati alle sezioni e altri senza sezione quindi di concorso
* [ ] concorsi / giurie / add  
Da fare. Richiedere per i giurati nome cognome nazione ed email,  se non sono censiti come user fare un inserimento automatico usando l'indirizzo email come password iniziale, andrà comunque cambiato tramite modifica password. Vanno anche registrati in UserRole.

### User

* [ ] controllare che recupera password sia funzionante

### Paesi

* [ ] Aggiornamento dell'elenco paesi con gli emoji delle bandiere nazionali
* [ ] Ricostruzione del seeder per i paesi con gli emoji delle bandiere

### 1. Contest - principale

* [x] Aggiungere le indicazioni per la quota di partecipazione (campo di tipo text)  
In precedenza questa informazione può far parte della pagina del bando e regolamento
* [X] Creare pagina Contest/Modify  
Sulla base della pagina add.blade fare la pagina modify.blade, si possono modificare
i concorsi anche sulla presenza di un circuit id che prima non c'era.
* [ ] TODO Aggiungere alla pagina un flag di readonly quando la data di sistema sia superiore
alla data di apertura del concorso e consentire solo la cancellazione del concorso
o nemmeno quella. Da far fare a un admin di yaPCP.
* [ ] TODO Quando si aggiunge un campo circuit_id andare al record e pescare
alcuni campi con cui impostare i dati del concorso.
* [ ] Quando viene impostato Y il flag is_circuit, il campo circuit_id diventa readonly e
viene impostato al valore di id in salvataggio dati.

I link per il pagamento saranno parte della pagina che contiene la scheda di iscrizione.
Chi non è inserito nella piattaforma, iscrivendosi
al concorso entra a farvi parte, ottenendo dei vantaggi
che può anche decidere di non sfruttare.  
In futuro ci sarà un contratto con le organizzazioni che propongono
concorsi con una bassa fee per concorrente, indipendente dal numero di sezioni.
Ci sarà un contratto con una bassa fee annuale con i concorrenti se manterranno le opere in linea
per almeno una cinquina di concorsi traendo vantaggio dalla facilità di iscrizione.
Non metto limiti al numero di opere archiviabili, ma al tempo di archiviazione
penso di max 4 anni.

### 2. Contest section

* [x] tabella che compone il concorso elencando
le sezioni e i temi di cui è composto
* [ ] le regole delle federazioni possono essere una lista di regole
e nella la section la regola "c'è", "c'è", "manca".

### 3. Contest jury list

* record FACOLTATIVO (non esiste per i circuiti)
* [ ] tabella che in base al concorso / circuito elenca dei premi,  
ciascuno con un identificativo univoco all'interno del concorso.
* [ ] la sezione all'interno della tabella premi dev'essere nullable,  
intendendosi che dove manca una sezione è un premio di circuito/ concorso
es. premio del giurato, miglior autore, ecc.

### 4. Contest section prize award list

* [ ] Dev'essere previsto un flag se si tratta di Premio o Menzione
* [ ] Il campo relativo al concorso e circuito sarà obbligatorio, mentre
il campo relativo al codice sezione tema sarà facoltativo, nel caso manchi
il premio si intende "di circuito e/o di concorso"

### Federation Rules List

* [ ] definire le rules che le federazioni prevedono,  
ovvero che per i concorsi a immagini digitali c'è un
minimo (0) e un massimo (4) di lavori partecipanti,
che il lato lungo dev'essere max(2500) pixel, in formato jpg, tif,
e cose così. Ogni regola deve avere una funzione che esegue la verifica
su un oggetto work, a cui accede e risponde con uno status di compliance o no.

## Generale

* [x] Attivare gli avvisi di registrazione per email ai nuovi utenti
* [x] Attivare gli avvisi di login per email agli utenti
* [ ] scoprire come usare MAMP al posto di `php artisan serve`.  
  Si deve puntare alla cartella /public che però deve sparire dall'URL,
  ho provato a spostare sulla radice del progetto l'indirizzo
  base di MAMP, e funziona ma solo fino a un certo punto.

* [ ] Studiare abilitazione e autenticazione,  
  L'obiettivo è avere una tabella di user con i ruoli granulari,
  e inserire nelle loro abilitazioni i codici associati alle
  operazioni e alle gestioni errore. Deve essere registrato nel
  log A B C che utente userA non è abilitato alla funzione
  functionB per cui serve il codice di abilitazione abilC.
  All'utente userA deve arrivare solo il messaggio che deve
  farsi abilitare rivolgendosi all'amministrazione del sistema.
  C'è già un middleware che controlla iscrizione e verifica email,
  va esteso o sostituito.

## Altre cose da fare

* [ ] Revisione del marchio con esclusione dei rettangoli, solo numeri sfalsati in altezza
  con un rigo sottostante a suggerire lo scalino e le lettere yaPCP o PCP (o PhoConPla?)

