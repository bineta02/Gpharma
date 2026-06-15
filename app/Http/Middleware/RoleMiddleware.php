<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
       if (!Auth::check()) {
        return redirect()->route('login');
       }
       if (!Auth::user()->hasRole($role)){
        abort(403, 'Acces non autorise.');
       }
       return $next($request);
    }
}
