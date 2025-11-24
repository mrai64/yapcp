# Documentazione yaPCP

ultimo aggiornamento 2025-11-21

contenuto: descrizione (quasi prolissa) delle tabelle che
costituiscono l'ossatura di yaPCP.

Recap per un eventuale rifacimento da zero (tipico di chi non vuole arrivare in fondo)

1. *countries*  
  tabella ausiliaria con l'elenco delle nazioni e le rispettive bandiere  
  viene usata nella tabella user_contacts,
  nella tabella federations,
  nella tabella organizations,
  nella tabella contests

1. *timezones*  
  tabella ausiliaria con il set completo
  di valori accettati da php per le timezones  
  viene usata nella tabella user_contacts,
  nella tabella federations,
  nella tabella organizations,
  nella tabella contests
1. *federation_members_role_values*  
  tabella ausiliaria per limitare i dati del campo  
  federation_members.role  
  nota: la tabella federation_sections_code_values
  *potrebbe esistere* come tabella ausiliaria, però
  non esiste perché non esiste uno standard condiviso
  tra tutte le federazioni, esiste *open M*
  contemporaneamente a *open BW*, e le definizioni si
  sovrappongono oppure M è un set che include BW
1. *organization_members_role_values*  
  Tabella ausiliaria che contiene e limita o valori
  che può assumere un campo della tabella organization_members  
  viene usata nella tabella organization_members  
1. **users**  
  *tabella base* di laravel, votata al solo accesso
  alla piattaforma per tutte e tutti
  relazioni  
  1:1 con user_contacts  
  D.: *Perché "lasciare com'è" questa tabella?*  
  R.: Perché in caso di aggiornamenti laravel questa
  tabella potrebbe "tornare all'origine", ma mentre lo scrivo
  non ci credo nemmeno io, e perché i dati sensibili devono
  avere un trattamento a parte. La versione standard di tutte
  le tabelle in laravel nasce con id primary key
  unsigned bigint autoincrement. Ma poi voglio evitare che
  questa pk sia identificabile accedendo ai dati di terzi
  con un banale +1 sulla chiave id. con la creazione di user
  devo creare contemporaneamente o prima che sia completato
  il giro di notifiche un record di user_contacts.
1. **user_contacts**  
  tabella che "allarga users" ma resta separata, e
  contiene nome cognome, indirizzo postale,
  email (allineata con quella di users),
  cellulare, e altri dati utili alla comunicazione della
  piattaforma con tutti. scelgo che la chiave di questa tabella
  sia una primary key in formato uuid, e non uuid7 per distribuire
  codici veramente casuali in sequenza. *Nota*: la pk
  di user_contacts e di users potrebbe essere identica.
  In questo caso, visto che viene creata per prima
  la chiave in users, si potrebbe applicare un trigger
  sql come anche intervenire nella users::create
  gestendo uno user_contacts::create() e uno user_contqcts::update()
  relazioni (non poche)  
  1:1 con users  
  1:N con user_works  
  1:N con federation_members  
  1:N con organization_members  
  1:N con contest_participants  
  1:N con contest_juries  
1. **user_works**  
  Questa è la tabella dei lavori dei partecipanti.  
  relazioni  
  N:1 con user_contacts  
  N:M con contest_works  
  1:N con user_validated__works  
  1:N con contest_waiting_works  
1. **user_validated_works**  
  Questa tabella contiene i lavori che per
  qualche sezione o tema sono giò stati controllati sia automaticamente
  che manualmente da organization_members  
  relazioni  
  N:1 con user_works perché un lavoro può essere visto valido
  nella sezione BN o in quella colore o in quella paesaggio,
  tuttavia questo dovrebbe per iniziare essere uno spazio
  in cui si certifica che l'immagine è conforme alla regola
  "devono mancare sigle o segni di riconoscimento"
1. **federations**  (TODO valutare federation_contacts come user_contacts)  
  Questa tabella elenca chi decide come si fanno
  i concorsi fatti bene, le definizioni per le sezioni
  ed i temi, i tempi del calendario, cosa fare e non
  fare prima, durante e a concorso concluso.  
  Questa tabella di fatto è una anagrafica federazioni
  e la chiave è una sigla, e nel caso ci siano federazioni le cui sigle ooincidano, non creo una
  federazione a e una b, oppure una fede 1 e fede 2 ma
  aggiungo come suffisso il carattere due punti e la
  sigla della nazione oppure metto per tutte le
  federazioni un id composto dal codice
  federazione + ':' + codice countries.id  
  es: FIAF:ITA oppure ITA:FIAF ARG:FAF federazione
  argentina fotografia e AND:FAF Federazione di    fotografia di Andorra.  
  relazioni  
  1:N federation_sections  
  1:N federation_members
  1:N contests  
1. **federation_members** (TODO valutare se accorparla un user_roles)  
  Questa tabella contiene un elenco di user_contacts
  che hanno un ruolo in federazione, e quale.
  Questi record hanno una data di inizio e
  una data di termine. Nota: la federation non ha
  un entry in login, sono solo i federation_members e
  gli amministratori di sistema che possono intervenire
  sui dati delle federazioni per aggiornarli.  
  Qualora una federazione sia anche organizzatrice di
  concorso avrà una entry come organization, e un
  set di organization_members che si occupano dei concorsi.
  relazioni  
  N:M con user_contacts  
  N:1 con federations  
  1:1 con federation_members_role_values  
  *Nota:* insieme alla tabella organization_members e contest_managers
  si possono riunire in una sola tabella user_roles, aggiungendo una
  colonna di tipo che indica se il ruolo dell'utente si applica a
  una organizzazione, federazione o concorso.
1. **federation_sections**  
  Questa tabella contiene le sigle, le definizioni
  e una lista di parametri per regole a verifica
  automatica p.es. sul numero di opere, sulle dimensioni
  in pixel o in byte, ecc.  
  A seguire queste possono ribaltare come config
  base sulla tabella contest_sections.  
1. **federation_add_fields**  (TODO Tabella ancora non esistente)
  Si tratta della tabella dei dati che le federazioni chiedono
  aggiuntivi a quelli base e specifici dell'organizzazione

1. **organizations**  
  Questa tabella contiene le schede di chi crea concorsi, liberamente,
  oppure seguendo le indicazioni di una o più federazioni per definire e
  strutturare il concorso  
  relazioni
  1:N contests
  1:N organization_members
1. **organization_members** (TODO può confluire in user_roles)  
  Questa tabella, gemella della tabella federation_members, contiene un elenco
  di user_contacts e il ruolo che svolgono
  in organizations. essere in questa tabella
  abilita all'accesso all'organization dashboard  
  relazioni  
  1:1 con organization_members_role_values  
1. **contests**  
  Questa tabella comincia la definizione dei concorsi, indicando
  dati base come il nome del concorso, l'organizzazione che lo
  promuove, il calendario delle 8 date, informazioni sulle
  quote di partecipazione, link al bando e scheda iscrizione  
  relazioni  
  1:1 countries per il campo contry_id