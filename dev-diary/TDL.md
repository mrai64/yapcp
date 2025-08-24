# To Do List

## Prossime attività

- [ ] provare a usare un lang diverso da *en*, per esempio *it*.
  - [x] installato language
  - [x] duplicata cartella en

  - [x] IN CORSO traduzione cartella
  
  - [ ] cambiare lang

- [ ] Creare la tabella country, solo colonne id, timestamp e code
- [ ] country.code->unique()
- [ ] Attivare gli avvisi di registrazione per email ai nuovi utenti
- [ ] Attivare gli avvisi di login per email agli utenti
- [ ] scoprire come usare MAMP al posto di artisan serve.

E sempre tenere aggiornato il [diario dello sviluppatore](./index.md)

## Elenco cose da fare nell'ordine in cui farle

- [ ] `__()` come funziona la cosa?

  Come aggiungere termini all'elenco e come funziona per lang diversi da en

- [ ] Timezone, fare la tabella o fare il json di configurazione
- [ ] Country: codice paese a 2 o 3 lettere, nome inglese del paese, prefisso telefonico,
area geografica (Africa/Europe/Americas/Asia ecc.)

- [x] creato componente app.php

Tabella Federation

- [x] Creato migration
- [x] Creato model
- [x] Creato factory
- [x] Creato seeder
- [ ] Convertire i timestamps in datetime
- [ ] Aggiungere il campo country_code, quando sarà creata la tabella Country.  
Il contry_code fa riferimento alla sede legale,
e si userà il codice ansi a 3 lettere, per esempio delle olimpiadi.
- [ ] Seeder con dati reali

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
- [ ] Pulsante Delete
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

- [ ] Convertire AddFederation in Federation/Add  
- [ ] Convertire ShowFederation(s)List in Federation/List  
- [ ] Convertire ModifyFederation in Federation/Mod

## Elenco delle cose già fatte

Sono quelle dell'elenco qui sopra ma con un ordine un po' diverso.

- Ripristinati TDL, index, dev-diaries
- Ricostruito il marchio yaPCP in svg e inserirlo al posto di quello standard di laravel, una copia nella cartella [di agosto](./2025-08/)
- modificata la pagina welcome - cambio marchio
- Ripristinata la configurazione email in `.env`
- Creata tabella Federation (non completa), e caricata con dati fake
- Creata pagina component per elencare le federazioni (non completa)
