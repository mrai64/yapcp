# welcome.aboard / DoD

## Funzionalità implementata

La piattaforma ha un indirizzo base / gestito da Route::view()
che porta a una pagina
di benvenuto, e nelle successive visite questo non viene ripetuto.  
Oltre al testo, se il visitatore non è registrato viene presentato il
link per il login o la registrazione, se il visitatore ha già
fatto login vengono presentati solo il link al manuale utente
e l link alla dashboard utente.

### Decision Matrix

| Stato Utente | Azione del Sistema | Target URL |
| ----         | ----               | ----       |
| Guest        | Mostra messaggio con link login / registrate | N\A |
| Loggato      | Scelta tra dashboard e manuale | /user/dashboard, /docs |

## Test superati

La funzione prevede che a richiamo dell'url / il browser
risponda con una pagina rilevando lo status html 200.

## Codice pulito

Il [componente volt](/resources/views/welcome.blade.php)
testa lo stato di autenticazione (`Auth::check()` )

## Middleware applicati

Essendo destinata a utenti registrati e non, manca di vincoli
middleware di autenticazione presenti in altre route.  
Applicato un limitatore di accessi, nominato welcome-aboard,
che è stato inserito in AppServiceProvider.

## Documentazione

[tecnica](/resources/docs/dev/welcome.aboard.md)  
[utente](/resources/docs/1.0/welcome.aboard.md)  
