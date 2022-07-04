<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class IsVerified
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
        try {
            if (session()->has('reg_user')) {
                $user = User::find(session()->get('reg_user')['id']);
                if ($user->verification != 'verified') {
                    return redirect()->route('verification');
                }

            }elseif (session()->has('auth_user')) {
                $user = User::find(session()->get('auth_user')['id']);

                if ($user->verification != 'verified') {
                    return redirect()->route('verification');
                }

            }
             else{
                return redirect()->route('index');
            }
            return $next($request);
        }catch (Exception $e){
            //clear all cookie and sessions here
            return redirect()->route('index');
        }

    }
}
