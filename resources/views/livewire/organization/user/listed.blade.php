<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <h2>TODO Elenco dei membri dell'organizzazione</h2>
    <p>I record possono essere modificati con variazioni di ruolo</p>
    <p>Le modifiche hanno effetto di aggiornare role_closing e creare
        un nuovo record con lo stesso valore in role_opening.
        Si crea un milionesimo di secondo di sovrapposizione,
        può essere un problema.
    </p>
</div>
