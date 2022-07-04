<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;

class IsLogged
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

        if (!session()->has('auth_user')){
            return redirect()->route('my_account');
        }
        return $next($request);
    }

//$old_date = '08-02-2022';
//$next_due_date = date('d-m-Y', strtotime($old_date. ' +30 days'));
//echo $next_due_date;
}
