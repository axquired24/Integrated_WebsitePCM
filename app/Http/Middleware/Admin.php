<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        if ( Auth::check() && Auth::user()->level=='admin' )
        {
            return $next($request);
        }
        Auth::logout();
        return \Redirect::to('login')->with('pesan_error', '<b>Akses diblokir</b> Halaman yang dituju butuh akses Administrator');
        // return view('errors.503');
    }
}
