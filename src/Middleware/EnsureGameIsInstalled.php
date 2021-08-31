<?php

namespace Azuriom\Plugin\Flyff\Middleware;

use Closure;

class EnsureGameIsInstalled
{
    public function handle($request, Closure $next)
    {
        if (setting('flyff_installed')) {
            return $next($request); // Already installed
        }
        
        if ($request->routeIs('flyff.install.*') || $request->is('_debugbar/*')) {
            return $next($request);
        }

        return redirect()->route('flyff.install.index');
    }
}
