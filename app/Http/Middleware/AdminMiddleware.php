<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request for admin Routes
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            if(strcmp( "admin" , Auth::user()->user_type ) != 0 )
                return redirect('home');
            else
                return $next($request);
        }
        else
        {
            return redirect('login');
        }
    }
}
