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

        if ($request->is('flyff/install/*', '_debugbar/*')) {
            return $next($request);
        }

        return response()->view('flyff::install.index');
    }
}
