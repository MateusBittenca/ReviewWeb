<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        
        // Para requisições JSON (API), retornar resposta JSON
        return null;
    }
    
    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->expectsJson() && !$this->authenticate($request, $guards)) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }
        
        return parent::handle($request, $next, ...$guards);
    }
}
