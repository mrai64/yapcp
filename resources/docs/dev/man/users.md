# Gestione Utenti

In questa sezione vengono descritte le procedure per la gestione del ciclo di vita dell'utente all'interno della piattaforma.

---

## Architettura

L'utente ha un primo punto ingresso fornito da email e password, esegue la registrazione e gl viene notificato nella sua casella di posta elettronica di convalidare l'indirizzo email.  
A seguire, dopo l'accesso in piattaforma arriva a uno spazio cruscotto in cui può svolgere le funzioni di base di un utente, che sono: modificare la sua scheda anagrafica completandola con informazioni essenziali quali nazionalità, e residenza, prendere visione dell'elenco di organizzazioni e federazioni e dichiararsi membro di una organizzazione o federazione e con quale ruolo. Allo stesso tempo ha accesso a uno spazio in cui caricare delle fotografie da usare in seguito per partecipare a concorsi. Le opere caricate vengono verificate automaticamente e manualmente per la partecipazione ai concorsi da parte degli organizzatori concorsi. L'utente può anche censire nuove organizzazioni di cui diventa automaticamente membro.

---

## Registrazione Utente

I campi richiesti sono:

Il sistema è uno di quelli predefiniti di Laravel Breeze e andrà sostituito con un sistema più articolato che consenta la registrazione con le piattaforme di autenticazione Microsoft, Google, Facebook ecc.

### Dati gestiti

* **Cognome, Nome**: Obbligatori
* **Email**: obbligatoria

## Modifica Anagrafica Utente

Questa funzione permette all'utente (o a un amministratore) di aggiornare le informazioni personali salvate nel database.

### 🛠 Dati Gestiti

I campi inclusi nel processo di aggiornamento sono:

* **Nome e Cognome**: Obbligatori.
* **Email**: Se modificata, viene attivato il processo di ri-verifica.
* **Data di Nascita**: Opzionale.

### 🚀 Implementazione Tecnica

**Endpoint:** `PUT /api/v1/profile/update`  
**Controller:** `App\Http\Controllers\UserController@update`  
**Request:** `App\Http\Requests\UpdateProfileRequest`

#### Regole di Validazione

Le principali regole applicate sono:

| Campo | Regola | Note |
| :--- | :--- | :--- |
| `name` | `required|string|max:255` | |
| `email` | `required|email|unique:users` | Esclude l'ID dell'utente corrente |
| `birth_date` | `nullable|date|before:today` | |

:::tip NOTA SULLA SICUREZZA
Il sistema verifica automaticamente tramite il middleware `auth:sanctum` che l'utente stia modificando solo il proprio profilo, a meno che non possieda il ruolo `admin`.
:::

### 🔄 Flusso di Lavoro (Workflow)

1. Il frontend invia la richiesta con i nuovi dati.
2. Il sistema valida i dati tramite il **FormRequest**.
3. Se l'email è cambiata, il flag `email_verified_at` viene impostato a `null`.
4. Viene scatenato l'evento `ProfileUpdated`, che logga l'azione per scopi di audit.

:::warning ATTENZIONE
Se l'utente cambia l'indirizzo email, verrà disconnesso alla sessione successiva se non conferma il nuovo indirizzo tramite il link inviato via mail.
:::
