<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ActiveUser
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
        if ( Auth::check() && Auth::user()->is_active==1 )
        {
            return $next($request);
        }
        // Auth::logout();
        return \Redirect::to('logout');
        // return view('errors.503');
    }
}
