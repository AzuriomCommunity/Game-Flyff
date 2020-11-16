<?php

namespace Azuriom\Plugin\Flyff\Middleware;

use Closure;
use Azuriom\Plugin\Flyff\Models\User;

class CheckCharsShop
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
        
        if (plugins()->isEnabled('shop') && plugins()->isEnabled('flyff') && $request->is('shop*')) {
            if(auth()->check()) {
                $user = User::ofUser(auth()->user());
                if($user->characters()->count() < 1)
                    return redirect()->home()->with('error', 'Please create an in-game char first');
            }
            
        }

        return $next($request);
    }
}