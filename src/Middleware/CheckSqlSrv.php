<?php

namespace Azuriom\Plugin\Flyff\Middleware;

use Closure;

class CheckSqlSrv
{
    public function handle($request, Closure $next)
    {
        if (!setting()->has('flyff.sqlsrv_host') && plugins()->isEnabled('flyff')) {
            if ($request->is('admin/flyff/settings') || $request->is('admin/plugins*')) {
                return $next($request);
            }

            if ($request->is('admin') || $request->is('admin/flyff*')) {
                return redirect()->route('flyff.admin.settings')->with('error', 'Your default connection is not sqlsrv, please configure it.');
            }
        }

        return $next($request);
    }
}
