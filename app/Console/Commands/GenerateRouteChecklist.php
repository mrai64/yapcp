<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class GenerateRouteChecklist extends Command
{
    // Il comando da digitare nel terminale
    protected $signature = 'route:checklist {--file=ROUTE_CHECKLIST.md}';

    protected $description = 'Genera una checklist in Markdown per il controllo accessi delle route';

    public function handle()
    {
        $fileName = $this->option('file');
        // $routes = Route::getRoutes();
        $routes = collect(Route::getRoutes())->sortBy(fn ($route) => $route->uri());

        $markdown = "# 🛡️ Checklist Controllo Accessi (" . now()->format('d-m-Y H:i') . ")\n\n";
        $markdown .= "> Automatically generated doc.  \n";
        $markdown .= "> Questo file è generato automaticamente. Usalo per tracciare la messa in sicurezza delle rotte.\n\n";

        $markdown .= "\n";
        $markdown .= "| ✅ | Uri | Name | Metodi | Middleware | Gruppo |\n";
        $markdown .= "| :--- | :--- | :--- | :--- | :--- | :--- |\n";

        foreach ($routes as $route) {
            // Filtro per escludere rotte di debug o pacchetti vendor
            if ($this->isVendorRoute($route)) {
                continue;
            }

            $name = $route->getName() ?? 'Nessun Nome';
            $uri = $route->uri();
            $methods = implode(', ', $route->methods());
            $middleware = implode(', ', $route->gatherMiddleware());
            // $action = $route->getActionName();

            $markdown .= "| [ ] | `/{$uri}` | `{$name}` | `{$methods}` | `{$middleware}` |";
            // $markdown .= "## Route: `{$name}`\n";
            // $markdown .= "| Proprietà | Dettaglio |\n";
            // $markdown .= "| :--- | :--- |\n";
            // $markdown .= "| **URI** | `/{$uri}` |\n";
            // $markdown .= "| **Metodo** | `{$methods}` |\n";
            // $markdown .= "| **Controller** | `{$action}` |\n";
            // $markdown .= "| **Middleware** | `{$middleware}` |\n\n";

            // $markdown .= "### Verifiche di Sicurezza\n";
            // $markdown .= "- [ ] **Target Accesso:** `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` `[ ] Altro` \n";
            $markdown .= " `[ ] Guest` `[ ] Registered` `[ ] Organization` `[ ] Jury` `[ ] Admin` |\n";
        }

        File::put(base_path($fileName), $markdown);

        $this->info("✅ Checklist generata con successo in: {$fileName}");
    }

    /**
     * Filtra le rotte che non appartengono direttamente al progetto.
     */
    protected function isVendorRoute($route)
    {
        $uri = $route->uri();
        $action = $route->getActionName();

        return str_starts_with($uri, '_') ||
               str_contains($uri, 'telescope') ||
               str_contains($uri, 'horizon') ||
               str_contains($uri, 'docs') ||
               str_contains($uri, 'livewire') ||
               str_contains($action, 'Closure') || // Esclude le rotte definite senza controller (opzionale)
               str_contains($action, 'Spatie');    // Esempio per escludere pacchetti specifici
    }
}
