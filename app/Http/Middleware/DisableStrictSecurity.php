<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableStrictSecurity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo aplicar en entorno 'server'
        if (app()->environment('production')) {
            // Deshabilitar verificación estricta de Host
            $request->server->set('HTTP_HOST', $request->getHost());
            
            // Asegurar que las cookies de sesión funcionen
            config(['session.secure' => false]);
            config(['session.same_site' => 'lax']);
        }
        
        return $next($request);
    }
}
