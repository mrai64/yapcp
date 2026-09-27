<?php

if (! function_exists('_')) {
    function _(...$args)
    {
        throw new \LogicException(
            "Funzione _() non valida usata al posto di __(). Correggere la sintassi nel file."
        );
    }
}
