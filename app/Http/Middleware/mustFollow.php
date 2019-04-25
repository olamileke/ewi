<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use Session;

class mustFollow
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
        if(Auth::user()->followings->count() < 3)
        {
            Session::flash('info','Follow at least three other poets');

            return redirect()->back();
        }

        return $next($request);
    }
}
