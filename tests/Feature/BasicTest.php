<?php

/**
 * 🇬🇧 Check if webserver is up
 * 🇮🇹 Verifica se il server è funzionante
 *
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    use RefreshDatabase; // Svuota il DB dopo ogni test

    // function name become test output string
    public function test_001_la_home_page_funziona(): void
    {
        // 1. ARRANGE (Prepara)
        // In questo caso non serve preparare nulla, vogliamo solo vedere la home.

        // 2. ACT (Esegui)
        $response = $this->get('/');

        // 3. ASSERT (Verifica)
        $response->assertStatus(200); // Verifica che la pagina non dia errore 404 o 500
    }
}
