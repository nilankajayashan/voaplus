<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UpdatePasswordChecker
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
        if (session()->has('password_reset_code')){
            if (session()->get('password_reset_code') != 'verified'){
                return redirect()->route('forgot_password')->with([
                    'warning' => 'Some thing went wrong...! please try again',
                ]);
            }
        }
        return $next($request);
    }
}
