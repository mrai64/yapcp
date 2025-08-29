# `To Do List`

Tenere aggiornato il [diario dello sviluppatore](./index.md)

Convertire i componenti in cartelle di componenti  
Modelli in cartella unica

## Prossime attività

- [ ] Creare la tabella country, solo colonne id, timestamp e code
- [ ] country.code->unique()
- [ ] Attivare gli avvisi di registrazione per email ai nuovi utenti
- [ ] Attivare gli avvisi di login per email agli utenti
- [ ] scoprire come usare MAMP al posto di artisan serve.
  Si deve puntare alla cartella /public che però deve sparire dall'url

- [ ] Studiare abilitazione e autenticazione,
  l'obiettivo è avere una tabella di user con i ruoli granulari, e inserire nelle loro abilitazioni i codici associati alle operazioni e alle gestioni errore. Deve essere registrato nel log A B C che utente userA non è abilitato alla funzione functionB per cui serve il codice di abilitazione abilC. All'utente userA deve arrivare solo il messaggio che deve farsi abilitare rivolgendosi all'amministrazione del sistema.

## Elenco cose da fare nell'ordine in cui farle

- [ ] Timezone, fare la tabella o ?
  le alternative sono: 
  - una tabella dedicata all'elenco, con Model Factory e Seeder dei dati reali
  - fare un file json che viene caricato in memoria e sta a disposizione in una istanza unica del Model\Timezone

- [ ] Country: codice paese a 2 o 3 lettere, nome inglese del paese, prefisso telefonico,
area geografica (Africa/Europe/Americas/Asia ecc.)
  le alternative come per timezone sono:
  - una tabella dedicata all'elenco, con Model Factory e Seeder dei dati reali
  - fare un file json che viene caricato in memoria e sta a disposizione in una istanza unica del Model\Country


## Elenco delle cose già fatte

Sono quelle dell'elenco qui sopra ma con un ordine un po' diverso.

- Ripristinati TDL, index, dev-diaries
- Ricostruito il marchio yaPCP in svg e inserirlo al posto di quello standard di laravel, una copia nella cartella [di agosto](./2025-08/)
- modificata la pagina welcome - cambio marchio
- Ripristinata la configurazione email in `.env`

### Federation

- Creata tabella Federation (non completa), e caricata con dati fake
- Creata pagina component per elencare le federazioni (non completa)
- pagina elenco delle federazioni, con link per aggiungere
- pagina modifica con rientro all'elenco
- pagina aggiungi con rientro all'elenco
- pagina di confermazione cancellazione con rientro all'elenco
- travasato in una cartella le 4 pagine per leggere,
  aggiungere, modificare e cancellare (softdelete)
  le Federation;
  - ShowFederationList > Federation\Listed (no List, è riservato)
  - AddFederation > Federation\Add (no Create)
  - ModifyFederation > Federation\Modify (no Update)
  - DeleteFederation > Federation\Remove (no Delete, è classe riservata)

Tabella Federation

- [x] Creato migration
- [x] Creato model
- [x] Creato factory
- [x] Creato seeder
- [x] Convertire i timestamps in datetime
- [x] Aggiungere il campo country_code, quando sarà creata la tabella Country.  
Il country_code fa riferimento alla sede legale,
e si userà il codice ansi a 3 lettere, per esempio delle olimpiadi.
- [x] Seeder con dati reali

(c**R**ud) Componente show-federation-list

- [x] Creato component ShowFederationList (ops: ShowFederation**s**List)
- [x] Creata view show-federation-list
- [x] Pulsante Modify in show-federation-list
  Questo ha più senso perché sono stati caricati
  un tot di record e vale la pena usarli con dati seri.
- [x] Pulsante Add
  Questo dirotta nel componente AddFederation
- [ ] Paginazione della lista
  Anche questa piuttosto inutile, però se
  metto dentro parecchi membri della FIAP,... ci sta.
- [x] Pulsante Delete
  Probabilmente il più inutile pulsante Delete perché
  dovrebbe chiudere una federazione nazionale o internazionale
  e finora questo non è mai capitato.  
  Non serve componente, si chiama un metodo del Model e via,
  si va alla lista che sarà aggiornata.

(**C**rud) Componente AddFederation

- [x] Creare il componente AddFederation
- [x] Creare la view add-federation  
  Quasi tutto come modify-federation ma togliendo il campo id

(cr**U**d) Componente modify-federation

- [x] Creare classe componente ModifyFederation
- [x] Creare view modify-federation
  Lasciare che il campo id stia in input hidden
  e ricordarsi l'elemento @csrf
- [x] Creare route per chiamare /federation/modify/{id}

(cru**D**) Componente delete-federation

- [x] Convertire AddFederation in Federation/Add  
- [x] Convertire ShowFederation(s)List in Federation/List  
- [x] Convertire ModifyFederation in Federation/Mod

### Organization

- Creata tabella Organizations, molto simile a Federation;
  Sono quelli che *fanno* i concorsi
  - [x] Migration
    usare uuid al posto di id
  - [x] Factory
  - [x] Seeder
  - [x] Organization\Listed
  - [x] Organization\Add
  - [x] Organization\Modify
  - [x] Organization\Remove ()

### Federation/Section

- [x] Creare la tabella FederationSections, l'elenco delle sezioni
  e temi che sono normati nei regolamenti delle federazioni.  
  Nei bandi dei concorsi le sezioni saranno abbinate a uno o più di questi
  record, i quali a loro volta saranno abbinati a una serie di regole
  che sono verifiche attuabili in automatico. Se per esempio
  la section FIAF.BN è associata alla regola Max:4 per le opere da
  presentare, l'autore partecipante potrà avere a disposizione
  4 slot per il concorso da riempire con le sue opere. Se la section
  è associata alla regola MaxLength:2500, i pixel lato lungo saranno
  confrontati e verificati in automatico. Quello che si può controllare
  si controllerà.

  Mentre il component laravel si presta alla suddivisione in cartelle,
  i Model e i seeders litigano, per ora si usa una struttura più lineare.

### Language

- [x] provare a usare un lang diverso da *en*, per esempio *it*.
  - [x] installato language
  - [x] duplicata cartella en in it
  - [x] SOSPESA traduzione cartella
  - [x] aggiungere le chiavi mancanti
  - [x] cambiare lang

- [x] `__()` come funziona la cosa?  
  Come aggiungere termini all'elenco e come funziona per lang diversi da en

- [x] creato componente app.php
