# `To Do List`

## Generalità

Spiega per chi vuol capire questa struttura della To Do List, delle cose da fare.

Aggiornamento: ho aperto un ["progetto"](https://github.com/users/mrai64/projects/1) in github.com e man mano le schede qui sotto saranno trasferite in quello.

L'attività è partita mesi fa e adesso sto cercando in una pausa
di riordinare le cose per organizzarle al meglio. Sono un operaio di tastiera
e non ho mai fatto né sono stato formato a fare il project manager.

A fine settembre 2025 sto quindi valutando di organizzare meglio le schede
delle cose da fare, vengo da altri progetti dove avevo creato in una piattaforma
wordpress una pagina Todolist, in cui con l'editor a blocchi spostavo i
paragrafi mettendogli anche un titolo, i paragrafi hanno come intestazione
una valutazione di urgenza alta normale bassa e una data di annotazione,
man mano che vengono terminati i task il blocco viene eliminato.
Qui in md non c'è un editor blocchi che mi consente il trascinamento, si va di
Taglia e incolla.

Decido quindi di riformattare il file usando i livelli # ## ### ####
e tenere aperto il pannello di sinistra Struttura|Outlook per avere una vista
su tutto il documento. Quelle che ora sono punti elenco con casella di spunta
diventano e diventeranno righe di titolo con ### o #### o #####.
Si può anche fare un comando unix che tira fuori le intestazioni

```sh
grep '^#' TDL.md | sort
```

**Avviso**: VSC ha una colonna con "barra laterale primaria", al cui interno
sta un elemento "Struttura". VA USATO.

### Nuove note

**Nuove note**: vanno inserite in [priorità normale](#cd-priorità-normale),
inserendo una lettera, una data e una riga di titolo, es.:  
`### (C) 2025-09-27 Fare la pagina user carica lavori`  
Qui, mutuato da todo.txt adotto la lettera di priorità,
la data di registrazione appunto e la riga di titolo, che inizia con una maiuscola.  
Sotto possono starci appunti e tutto quel che serve, l'editor consente di
nascondere il contenuto lasciando la riga di intestazione.  
Se la cosa è davvero urgente, per risolvere un problema o può essere eseguita subito in pochissimo tempo, va inserita nell'[alta priorità](#ab-alta-priorità)
con lo stesso criterio, es.:  
`### (A) 2025-09-27 Risolvere problema alla pagina di caricamento immagini issue #17`  
`### (B) 2025-09-27 Inserire traduzioni italiano della pagina caricamento immagini`  

**Branch**: La nuova nota può anche coincidere con l'apertura di un branch dedicato
all'attività, che va inserito all'interno del blocco come collegamento al sito github.

### Chiusura delle note

Quando l'attività termina prima della priorità (A) .. (F) viene messa una x,
e dopo la priorità viene inserita la data chiusura attività. La frase andrebbe
sempre messa al passato *Risolvere* > *Risolto*.

Qualora sia stato chiuso e cancellato il branch associato,
il collegamento al branch deve essere trasformato in testo o rimosso.  
`### x (A) 2025-09-27 2025-09-27 Risolto problema alla pagina di caricamento immagini issue #17`  

Prossime attività

## (A)(B) Alta priorità

Vanno considerate di alta priorità (A) le sistemazioni di problemi,
issue resolution, le cose collo di bottiglia che *se non fai questa non vai avanti*,
e anche le cose che si possono fare e finire in pochissimo tempo.

## (C)(D) Priorità normale

Sono le cose che vanno fatte e non rientrano nelle alte priorità

### (C) 2025-09-27 Sostituire il campo circuit_id text con una select - Modulo Contest Principale

Nel modulo principale di definizione del concorso c'è un campo flag
'Circuito' seguito da un campo che richiede il circuit-id. Che può creare
difficoltà e dev'essere migliorato. Va creata una selezione di record che
hanno il flag "is_circuit" === 'Y' (preferito al booleano true/false),
e presentata in ordine alfabetico oppure di `'updated_at' desc`.
È ragionevole che i concorsi vengano inseriti insieme al circuito e quindi
sia stato inserito da poco.

Quando il flag 'is_circuit' vale 'Y' il campo deve diventare readonly. Imparare gestione eventi

### (C) 2025-09-27 Caricare una manciata di concorsi fake

Impostare qualche concorso con almeno un paio di sezioni,
per predisporre l'elenco dei concorsi da mostrare ai partecipanti.

### (D) 2025-09-23 Blocco campi per concorsi in corso - Concorsi Modifica  

Aggiungere una variabile basata sulla data
che discrimini i campi readonly o modificabili/required.

### (D) 2025-09-26 Copia giuria precedente - modulo Concorsi / Giurie / Add  

Nel modulo vengono inseriti i giurati di ogni sezione, ma in caso di giuria unica
o di giurie che guardano più di una sezione, dev'essere agevole cliccare su un pulsante e
fare la copia dei giurati già inseriti.
Pulsante *"riprendi i giurati della sezione precedente"*

### (D) 2025-09-26 Presidente di giuria - modulo Concorsi / Giurie / Add  

Aggiungere la gestione del campo flag "è presidente"
e l'elenco dei giurati deve avere l campo Y/N ordinato desc
per mettere in cima il presidente di giuria. (A quello serve, non altro)

### (D) 2025-09-27 Lista Concorsi: scheda di presentazione

Quando un utente va a visionare l'elenco dei concorsi a disposizione
deve avere una scheda che dettaglia di un concorso tutte le schede
che sono state inserite.

### (D) 2025-07-23 Tenere aggiornato il [diario dello sviluppatore](./index.md)  

Punto che non può essere chiuso fintanto che il progetto è attivo.  

### (D) 2025-09-27 Spostare il diario nel [wiki](https://github.com/mrai64/yapcp/wiki)

Finora il progetto è stato costellato di un commit al giorno,
relativo all'aggiornamento del diario dello sviluppatore. Questo da un lato
rende il progetto vivace, con molti commit, dall'altro continua a creare
versioni che no riguardano il codice ma la logorrea dello sviluppatore.

Dando priorità allo sviluppo di codice piano piano spostare tutto il diario nel wiki.

### (D) 2025-09-27 Revisione il modulo Concorsi (sezioni) Award / Add & modify

Non mi ricordo perché questo punto era stato segnato ma basta controllare
il modulo se si trovano miglioramenti da fare, si faranno.

### (D) 2025-09-27 Modulo Concorsi Principale - chairman

Va indicato e gestito uno user che faccia da Chairman - Segretario del concorso,
indicando nome cognome email e nazionalità (sufficiente l'email
che è unica nella piattaforma) e che questo venga aggiunto anche
nella tabella degli UserRole (chairman of / contest) come si fa già per
i membri delle giurie.

### (D) 2025-09-27 Modulo Concorsi in circuito - pescare dati dal Circuito

Quando un concorso fa parte di un circuito, e si imposta il campo Circuit_id,
dal record del circuito al record del concorso vanno travasati dei dati.Eventualmente solo se il campo di arrivo è ancora vuoto.

### (D) 2025-09-27 Modulo Concorsi Sezioni - verifica sezioni under patronage

Quando un concorso è marcato under_patronage nella lista delle federazioni
sono presenti uno o più codici federazioni. Quest a loro volta hanno una
tabella sezioni patrocinate, serve incrociare il dato della sezione inserita
nel concorso con quelle presenti in federazione.

### (D) 2025-09-27 Modulo Concorsi sezioni - Modifica

### (D) 2025-09-27 Modulo Concorsi sezioni - Rimozione

### (D) 2025-09-27 Modulo Concorsi Giurie

Inserire un avviso che quando il record è marcato "Circuit" NON
vanno inseriti giurati perché le giurie sono dei concorsi che FANNO PARTE
del circuito

OPPURE

Eventualmente una giuria dei chairman dei concorsi o dei presidenti dei circoli
per assegnare il premio di circuito come Blue Ribbon Miglior
Autore ?

### (D) 2025-09-27 Tabella Regole di conformità (delle federazioni)

Quello che è verificabile con automatismi, ovvero:

* dimensioni immagini
* peso in MB
* nome *Senza Titolo*

### (D) 2025-09-27 La cancellazione (soft-delete) di uno user deve cancellare anche altro

In cascata e possibilmente in transazione (tutto o niente) vanno cancellati anche i dati correlati allo users.id nelle altre tabelle. Da analizzare

## (E) Bassa priorità

Sono le cose che non rientrano nelle precedenti ma sono comunque da fare

### (E) 2025-09-27 Modulo principale Concorsi Add - marchio

Manca il caricamento del marchio

### (E) 2025-09-27 Modulo Concorsi principale Modify

* [X] Creare pagina Contest/Modify  
Sulla base della pagina add.blade fare la pagina modify.blade, si possono modificare
i concorsi anche sulla presenza di un circuit id che prima non c'era.

### (E) 2025-09-27 Modulo principale Concorsi Modify - marchio

Manca il caricamento del marchio

### (E) 2025-09-27 Avviso o esclusione del modulo Concorsi Sezioni se il record è is_circuit Y

Il modulo va presentato se nel se il record principale NON è marcato come is_circuit

### (E) 2025-09-27 Modulo Concorsi Award list per is_circuit Y

Se il record è marchiato come is_circuit Y non ci sono sezioni e quindi non vanno accettati valori nel campo codice sezione che va readonly.

### (E) 2025-09-25 Preparare il modulo Concorsi Sezioni / Modify

### (E) 2025-09-25 Preparare il modulo Concorsi Giurie / Modify

### (E) 2025-09-22 Federation Sections - Refactory EXCERPTUM va cambiato con SYNOPSIS

### (E) 2025-09-27 scoprire come usare MAMP al posto di `php artisan serve`

  Si deve puntare alla cartella /public che però deve sparire dall'URL,
  ho provato a spostare sulla radice del progetto l'indirizzo
  base di MAMP, e funziona ma solo fino a un certo punto.

### (E) 2025-09-27 Abilitazione per utente, e per gruppi; non solo ['auth]

Studiare abilitazione e autenticazione,  
  L'obiettivo è avere una tabella di user con i ruoli granulari,
  e inserire nelle loro abilitazioni i codici associati alle
  operazioni e alle gestioni errore. Deve essere registrato nel
  log A B C che utente userA non è abilitato alla funzione
  functionB per cui serve il codice di abilitazione abilC.
  All'utente userA deve arrivare solo il messaggio che deve
  farsi abilitare rivolgendosi all'amministrazione del sistema.
  C'è già un middleware che controlla iscrizione e verifica email,
  va esteso o sostituito.

### (E) 2025-09-27 Revisione marchio

Revisione del marchio con esclusione dei rettangoli, solo numeri sfalsati in altezza
  con un rigo sottostante a suggerire lo scalino e le lettere yaPCP o PCP (o PhoConPla?)

### (E) 2025-09-27 Federazioni (Sezioni) Regole

Le regole delle federazioni possono essere una lista di regole
già codificate in software e nella la section la
regola "c'è", "c'è", "manca". (da definire)

### (E) 2025-09-27 Countries - aggiungere emoji bandiere

A seguire ricostruzione seeder

### (E) 2025-09-27 Countries - ricostruzione seeder

Per comprendere gli emoji delle bandiere

### (E) 2025-09-27 Lista Concorsi in Organization

Mettere una marcatura per distinguere i concorsi in progetto, quelli in corso
e quelli terminati.

### (E) 2025-09-27 Verifica recupero password

## (F) Cose già terminate

Queste sono raggruppate per tabelle e funzioni in ordine alfabetico

* contests concorsi principale
* contest_awards premi
* contest_juries giurati
* contest_sections sezioni e temi
* contest_votes (da fare)
* contest_works (da fare)
* countries paesi nazioni
* federations
* federation_sections
* organizations
* users
* user_contacts
* user_roles
* works (potrebbe anche essere user_works)

### Concorsi

La definizione del concorso e del circuito concorsi passa da più fasi:

1. definire il concorso: organizzatore, nome, calendario, patrocini (idem per i circuiti), quote di partecipazione
2. definire le sezioni del concorso (il circuito non ne ha)
3. definire le giurie del concorso (il circuito non ne ha)
4. definire i premi del concorso (e del circuito),
e delle sezioni del concorso (non ci sono premi di sezione per i circuiti)
5. ricavare da quanto sopra il testo di una bozza di regolamento che sia inviabile agli enti sponsor.

### x (D) 2025-09-27 2025-09-27 Moduli concorsi - Barra di navigazione

Creare una barra di navigazione Principale / Sezioni / Giurie ecc.  
Questa barra si ripete sotto alla prima intestazione della pagina evidenziando l'elemento in cui ci si trova con un font doppio.

### 1. Contest Principale

#### x 2025-09-27 2025-09-27 Concorsi Principale - Quota di partecipazione

Aggiunto un campo `fee_info` le indicazioni per la quota di partecipazione (campo di tipo text)  
In precedenza questa informazione può far parte della pagina del bando e regolamento

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

Tabella che compone il concorso elencando
le sezioni e i temi di cui è composto

#### x 2025-09-27 2025-09-27 Preparato il modulo Concorsi Sezioni / Add  

Questo fa vedere alcune info del concorso,
un elenco delle sezioni già presenti e aggiunge la sezione.

### 3. Contest (section) jury list

Record FACOLTATIVO, non esiste per i circuiti. A meno che
non si chieda una giuria per il miglior autore di circuito.

#### x (D) 2025-09-27 2025-09-27 Creazione Contest Jury Add

Richiede per i giurati nome, cognome, nazione ed email.
L'email è unica in piattaforma, se non risulta presente
vengono inseriti con i dati a disposizione User e UserContact.
La password iniziale in quel caso sarà l'indirizzo email.
Andrà comunque cambiato tramite *modifica password*.
Vanno anche registrati in UserRole coinvolgendo il nuovo users.id
con il concorso e l'associazione 'juror'.

### 4. Contest (section) prize award list

* Tabella che in base al concorso / circuito elenca dei premi,  
ciascuno con un identificativo univoco all'interno del concorso.
* La sezione *section code* all'interno della tabella Premi dev'essere nullable,  
intendendosi che dove manca una sezione è un premio di circuito o concorso
es. premio del giurato, miglior autore, ecc.
* Dev'essere previsto un flag se si tratta di Premio o Menzione,
dove la differenza la fa non il valore del premio ma se lo stesso
vale per la statistica della federazione sponsor.

### 5. Contest (juror) Votes

Tabella che raccoglie i voti dei giurati per le opere che partecipano
al concorso, e consente di stabilire una graduatoria.
Il voto è una qualsiasi forma di valore scalabile, può essere
di espressione numerica (da 1 a 5, da 1 a 10, da 1 a 30),
di espressione alfanumerica ('non ammesso', 'ammesso', 'a premio')
e si possono utilizzare anche simboli emoji purché
gli venga assegnato un valore scalare (🌑 🌓 🌔 🌕) (😖 ☹️ 🤔 🙂 😃 🎖️ 🏆).

### 6. Contest (user) Works

Tabella che raccoglie le opere che gli user mettono in partecipazione,
e che verranno presentate ai giurati in forma anonimizzata, rimuovendo
la possibilità di fare download.

Altre piattaforme, anche se non è molto legale, espongono le opere caricate
dagli autori e "consentono" lo scaricamento, esattamente. Chi ha un minimo
di competenze tecniche può risalire all'autore delle opere, quando e da che
macchina sono state scattate e perfino dove sono state scattate.

### Country Paesi

Si tratta di un elenco statico, abbastanza statico, in cui però ci sono più
elementi e quindi si è scelto di non fare un const array ma una tabella vera.
comprende country_code iso-3166 alpha 3, nome della nazione, emoji della bandiera.

### Federation

Sono presenti le organizzazioni nazionali e internazionali che hanno un proprio
regolamento concorsi ed onorificenze e che per questo controllano l'andamento
dei concorsi oltre a concedere patrocini.

### Federation Section

Ogni federazione adotta un criterio per regolare i temi e le sezioni dei concorsi,
qui vengono elencati codici e descrizioni.

### Federation Rules List

Posto che ci son cose che NON si possono controllare automaticamente
altre sì, anche fosse "solo" la dimensione in pixel, o il numero di immagini
che possono partecipare a una sezione, quello che si può automatizzare va automatizzato.
Ogni regola deve avere una funzione che esegue la verifica
su un oggetto della tabella Works, a cui accede e risponde con uno status di compliance o no.
Il concorrente deve essere AVVISATO quali foto sono candidabili e quali no,
per esempio una foto può essere "tropo vecchia" come anche "già inviata in precedenza".
Queste regole poi vanno associate alle sezioni patrocinabili.

### Organization

Sono nel gruppo delle organizzazioni chi organizza concorsi.

### User

La tabella di accesso alla piattaforma è scollegata dalla piattaforma delle anagrafiche dei
soggetti registrati, che devono essere tutti persone fisiche.
organizzazioni che organizzano concorsi e organizzazioni che patrocinano concorsi vanno rispettivamente nelle tabelle organizations e federations.

### User Contact

Sono le schede anagrafiche degli user

### User Ruoli

Sono le schede di relazione tra user e organizzazioni / concorsi / federazioni
Prevede anche una gestione a calendario, lo stesso user può essere chairman
in un concorso ma non per sempre, possono esserci dei ruoli sovrapponibili
p.es. membro di una organizzazione e chairman di un concorso
e membro di una federazione, e altri incompatibili:
partecipante e chairman dello stesso concorso.

### Works

Sono le opere che in deposito partecipano, hanno partecipato e possono
partecipare ai concorsi.

#### x (B) 2025-09-27 2025-09-27 Pagina per elenco e caricamento delle opere

La pagina è raggiungibile dalla dashboard dell'utente, consente di vedere le miniature delle opere (in uno spazio limitato dello schermo ma con scroll laterale), e consentire (in una pagina dedicata) il caricamento delle opere con i dati associati alla tabella `Works`.

