<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; 

class IsDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if(auth()->user()->is_disabled  == 1){
                $attempted_auth_email = auth()->user()->email;
                Auth::logout();
                $request->session()->flush();
                return redirect('login')->with('error',"Permission Denied!!! The Account ($attempted_auth_email) has been disabled or suspended.");
            }
        }
        return $next($request);
    }
}
