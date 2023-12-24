<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccessPermission
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
        if(Auth::user()->hasrole('admin')){
            return $next($request);
        }else{
            return redirect('/login-auth')->with('message','Phiên đăng nhập hết hạn!');
        }
        return redirect('/dashboard');
    }
}
