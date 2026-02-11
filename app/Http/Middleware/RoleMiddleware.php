<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $role): Response
    {

        if (!Auth::check()) {
            return redirect('/login');
        }
        
        if (!in_array(Auth::user()->role, [UserRole::ADMIN, UserRole::AUTHOR])) {
            //abort(403, 'Unauthorized');
            return response()->view('errors.unauthorized');
        }
    
        return $next($request);
    }
}
