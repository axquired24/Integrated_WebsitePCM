<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Staff
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
        $validAuth  = Auth::user()->level=='admin' || Auth::user()->level=='staff';
        if ( Auth::check() && $validAuth )
        {
            return $next($request);
        }
        Auth::logout();
        return \Redirect::to('login')->with('pesan_error', '<b>Akses diblokir</b> Halaman yang dituju butuh akses Staff');
        // return view('errors.503');
    }
}
