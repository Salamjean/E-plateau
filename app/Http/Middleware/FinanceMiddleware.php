<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FinanceMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('finance')->check()){
            return $next($request);
        }else{
            return redirect()->route('finance.login');
        }
    }
}