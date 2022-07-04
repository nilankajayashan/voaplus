<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthStream
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

        if (session()->has('auth_user')){
            $user = User::find(session()->get('auth_user')['id']);
            $browser_token = $_COOKIE['browser_token'];
            $token_list= explode("|",$user->browser_token);
            $token_state = in_array($browser_token, $token_list);
            if (!$token_state){
                return redirect()->route('login');
            }

        }else{
            return redirect()->route('login');
        }
        return $next($request);
    }
}
