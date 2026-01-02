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

**Nuove note**: Vista la novità del *progetto*, non vanno più inserite in questo file ma va aperta una
richiesta issue nella [pagina](https://github.com/users/mrai64/projects/1) (privata) github dei progetti.
usare un prefisso fix: per i problemi da sistemare, feat: per le cose da fare
comprese le migliorie. Poche parole per dare un argomento e un \[id: aaaa-mm-gg.nn].
C'è una colonna *open id*, va compilata con lo stessi id *aaaa-mm-gg.nn* dove
nn è un progressivo sempre di 2 cifre che ogni giorno parte da 01. Colonna *assegnata a*, ovviamente a me per ora.
Status Todo o in progress o Done. Done viene assegnato automaticamente quando vene chiusa la richiesta.

**Branch**: La nuova nota può anche coincidere con l'apertura di un branch dedicato
all'attività, farlo in previsione di uno sviluppo lungo e che può intralciare altre attività. Per ora faccio una cosa alla volta e questo toglie l'esigenza...

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

Attività da ribaltare in Project. Viene usato anche uno standard ABCDE:

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
