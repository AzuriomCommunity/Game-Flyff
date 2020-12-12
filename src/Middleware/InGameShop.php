<?php

namespace Azuriom\Plugin\Flyff\Middleware;

use Closure;
use Azuriom\Plugin\Flyff\Models\User;

class InGameShop
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->is_game || session()->has('azuriom_is_game')) {
            session()->put('azuriom_is_game', '1');
            if ($request->has('m_idPlayer') && $request->has('m_nServer')) {
                session(['m_idPlayer' => (int) request()->m_idPlayer]);
                session(['m_nServer'=> (int) request()->m_nServer]);
            }

            if (!auth()->check() && $request->is('user/login')) {
                session()->put('url.intended', '/shop');
                return $next($request);
            }
            
            if (!auth()->check() && !$request->is('user/login')) {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
