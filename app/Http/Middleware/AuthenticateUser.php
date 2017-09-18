<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AuthenticateUser
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
        if (!Session::has('user')) {
            return redirect('/login');
        }

        $request->attributes->add(['user' => Session::get('user')]);
        return $next($request);
    }
}
