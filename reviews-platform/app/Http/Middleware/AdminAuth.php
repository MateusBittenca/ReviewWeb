<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if user has admin or owner role
        $user = Auth::user();
        if (isset($user->role) && !in_array($user->role, ['admin', 'proprietario'])) {
            abort(403, 'Acesso negado. Apenas administradores e proprietários podem acessar esta área.');
        }

        return $next($request);
    }
}