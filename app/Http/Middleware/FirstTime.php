<?php

namespace App\Http\Middleware;

use Auth;

use Closure;

class FirstTime
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
        $user=Auth::user();

        if(!$user->is_first_time)
        {
            return redirect('/');
        }

        return $next($request);
    }
}
