<?php

namespace App\Http\Middleware;

use Closure;

use Session;

use Auth;

use App\User;

class TagRestriction
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
        if($request->route('name') != Auth::user()->getNameSlug())
        {
            Session::flash('info', 'You do not have permission');

            return redirect()->back();
        }

        return $next($request);
    }
}
