# `To Do List`

## Generalità

Spiega per chi vuol capire questa struttura della To Do List, delle cose da fare.

**Aggiornamento: ho aperto un ["progetto"](https://github.com/users/mrai64/projects/1) in github.com e man mano le schede qui sotto saranno trasferite in quello. Dà un po' fastidio che vengano "tutti" etichettati come "problemi|issue". Se è già presente un issue per i punti sotto e un link all'issue manca, va inserito il link e/o aggiornata la scheda in issue.**

L'attività è partita mesi fa e adesso sto cercando in una pausa
di riordinare le cose per organizzarle al meglio. Sono un operaio di tastiera
e non ho mai fatto né sono stato formato a fare il project manager.

A fine settembre 2025 sto quindi valutando di organizzare meglio le schede
delle cose da fare, vengo da altri progetti dove avevo creato in una piattaforma
wordpress una pagina Todolist, in cui con l'editor a blocchi spostavo i
paragrafi mettendogli anche un titolo, i paragrafi hanno come intestazione
una valutazione di urgenza alta normale bassa e una data di annotazione,
man mano che vengono terminati i task il blocco viene eliminato.
Qui in md non c'è un editor blocchi che mi consente il trascinamento, si va di Taglia e incolla.

Decido quindi di riformattare il file usando i livelli # ## ### ####
e tenere aperto il pannello di sinistra Struttura|Outlook per avere una vista
su tutto il documento. Quelle che ora sono punti elenco con casella di spunta
diventano e diventeranno righe di titolo con ### o #### o #####.
Si può anche fare un comando unix che tira fuori le intestazioni

```sh
grep '^#' ./dev-diary/TDL.md | sort | bbedit
```

**Avviso**: VSC ha una colonna con "barra laterale primaria", al cui interno
sta un elemento "Struttura". VA USATO.

### Nuove note

**Nuove note**: non vanno più inserite in questo file ma va aperta una
richiesta nella [pagina](https://github.com/users/mrai64/projects/1) (privata) github dei progetti.
usare un prefisso fix: per i problemi da sistemare, feat: per le cose da fare
comprese le migliorie. Poche parole per dare un argomento e un \[id: aaaa-mm-gg.nn].
C'è una colonna open id, va compilata con lo stessi id aaaa-mm-gg.nn dove
nn è un progressivo che ogni giorno parte da 01. Colonna assegnata a, ovviamente a me per ora.
Status Todo o in progress o Done. Done viene assegnato automaticamente quando vene chiusa la richiesta.

**Branch**: La nuova nota può anche coincidere con l'apertura di un branch dedicato
all'attività, farlo in previsione di uno sviluppo lungo e che può intralciare altre attività.

## Indice generale

Può costituire l'indice del /docs. Quelle "terminate" in realtà funzionano,
ma possono essere tutte revisionate. Quelle che non sono ancora
terminate possono essere già funzionanti (e aggiornare l'elenco) oppure da fare.  
Per quelle da fare si procede man mano che il percorso del concorso avanza,
per scrivere e testare il funzionamento delle cose. Non sono previsti cicli
di test automatici perché non ho imparato a farli e gestirli.  
Php, laravel e livewire sono usati per avvantaggiarmi ma li sto imparando facendo.
alcune funzioni realizzate potrebbero avere delle parti di laravel e livewire
che le agevolano ma le devo imparare.

Attività da ribaltare in Project.

* Documentazione utente
  * [ ] Iscrizione alla piattaforma 
  * [ ] Autoassegnazione di ruoli in federazioni e Organizzazioni
  * [ ] Caricamento opere a deposito 
  * [ ] iscrizione opere a concorso
* utenti - quelli che fanno cose
  * ✅ iscrizione alla piattaforma
  * ✅ modifica password
  * ✅ caricamento opere
  * ✅ assegnazione ruolo in organizzazione
  * ✅ assegnazione ruolo in federazione
  * ✅ assegnazione ruolo in concorso
  * ✅ iscrizione a concorso
  * ✅ Vista concorsi aperti
  * ✅ Vista opere partecipanti a...
  * [ ] Vista risultati ottenuti
  * ✅ caricamento lavori in concorso
* federazioni - definiscono e controllano i concorsi a cui danno patrocinio
  * ✅ Definizione scheda principale - nome, web
  * ✅ Definizione delle sezioni a concorso
* organizzazioni - creano e gestiscono concorsi
  * ✅ Creazione scheda principale
  * [ ] Lista ruoli utenti in organizzazione
  * ✅ Creazione concorsi in capo a organizzazioni
  * [ ] Lista concorsi in corso
  * ✅ Lista concorrenti con assegnazione quota versata
* concorsi
  * ✅ definizione scheda principale - nome, calendario, referenti, sito web
  * ✅ definizione delle sezioni a concorso
  * ✅ definizione delle giurie dei concorsi
  * ✅ definizione dei premi dei concorsi
  * [ ] predisposizione verbale "automatico" per copia incolla su carta intestata
  * [ ] predisposizione elenchi per ammessi e premiati / catalogo web
  * [ ] predisposizione elenchi per scarico immagini uso catalogo
  * [ ] Circuiti - definizione scheda principale - nome, calendario, web
  * [ ] Circuiti - definizione sezioni
  * NO Circuiti - definizione giurie
  * [ ] Circuiti - definizione premi
  * [ ] Sezione Portfolio - aggiungere un campo sequenza a fianco della sezione
  * [ ] Ghigliottina per concorrenti non ammessi a concorso
* Giurie
  * ✅ Caricamento delle giurie in concorso (vedi Concorsi > definizione delle giurie)
  * ✅ Registrazione dei giurati come user in piattaforma
  * ✅ Regolare accesso giurati con calendario da..a del concorso
  * [ ] Elenco opere in concorso per la sezione ... - miniature
  * ✅ Visione delle opere doppiamente anonima
  * [ ] Gestione delle votazioni per giuria
  * [ ] Riepilogo votazioni generale
  * [ ] Assegnazione premi
  * [ ] Convalida dei risultati da parte della giuria
* Manutentori
  * [ ] Funzione backup archivi
  * [ ] Funzione cancellazioni archivi
  * [ ] Funzione cancellazione opere non più presenti in archivio
  * [ ] Funzione comunicazioni broadcast agli organizzatori per manutenzione programmate o anomalie

Attività da ribaltare in Project.

## (A)(B) Alta priorità

Vanno considerate di alta priorità (A) le sistemazioni di problemi,
issue resolution, le cose collo di bottiglia che *se non fai questa non vai avanti*,
e con (B) le cose che non sono (A) e si possono fare e finire in pochissimo tempo.

### (B) 2025-07-23 Tenere aggiornato il [diario dello sviluppatore](./index.md)  

Punto che non può essere chiuso fintanto che il progetto è attivo.  

## (C)(D) Priorità normale

Sono le cose che vanno fatte e non rientrano nelle alte priorità

## (E) Bassa priorità

Sono le cose che non rientrano nelle precedenti ma sono comunque da fare

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

### (E) 2025-09-27 Lista Concorsi in Organization

Mettere una marcatura per distinguere i concorsi in progetto, quelli in corso
e quelli terminati.

### (E) 2025-09-27 Verifica recupero password

