<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <h2>TODO</h2>
    <p>Scheda da sviluppare per aggiungere una persona all'organizzazione.</p>
    <p>Dati richiesti: email, nome, cognome, ruolo nell'organizzazione.</p>
    <p>Acquisiti i dati, si procede a verificare se l'indirizzo email è già presente in piattaforma.</p>
    <p>Se manca: viene creato uno suer e uno usercontact, con invio di notifica all'interessato</p>
    <p>Se presente: inserimento del record in user_roles</p>
</div>
