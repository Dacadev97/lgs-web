<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visit;
use Illuminate\Support\Carbon;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $alreadyVisited = Visit::where('ip_address', $request->ip())
            ->whereDate('created_at', now()->toDateString())
            ->where('url', $request->url())
            ->exists();

        if (! $alreadyVisited) {
            Visit::create([
                'ip_address' => $request->ip(),
                'url' => $request->url(),
            ]);
        }

        return $next($request);
    }
}
