<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlockedOrganisations
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
        if (auth()->check())
        {
            if (auth()->user()->status == 3) {
                $message = 'Ваш аккаунт заблокирован.';
                auth()->logout();
                return redirect()->route('auth.login')->withErrors(['email' => $message]);
            }
        }
        return $next($request);
    }
}
