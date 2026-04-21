<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogContext
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Aggiunge il contesto a TUTTI i log generati durante questa richiesta
        Log::shareContext([
            'session_id' => $request->session()->getId() ?? 'nosession',
            'user_id'    => auth()->id() ?? '00000000-0000-0000-0000-000000000000', // null uuid
        ]);
        //
        if (!Session::has('browser_logged')) {
            Log::info("New session started", [
                'user_agent' => $request->header('User-Agent'),
                'ip' => $request->ip(),
                'referer' => $request->header('referer')
            ]);
            // Segniamo in sessione che abbiamo già fatto il primo log
            Session::put('browser_logged', true);
        }
        //
        return $next($request);
    }
}
