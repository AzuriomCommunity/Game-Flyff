<?php

namespace Azuriom\Plugin\Flyff\Middleware;

use Closure;
use Azuriom\Models\Setting;

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

        if (!setting('flyff_installed') && setting('flyff.sqlsrv_host')) {
            Setting::updateSettings([
                'flyff_installed' => 1
            ]);

            return $next($request);
        }

        return redirect()->route('flyff.install.index');
    }
}
