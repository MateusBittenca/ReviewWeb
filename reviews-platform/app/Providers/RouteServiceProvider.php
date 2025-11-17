<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            // Rotas web padrão
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
                
            // Rotas de API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
                
            // Rotas AJAX com autenticação web
            Route::middleware('web')
                ->group(base_path('routes/ajax.php'));
        });
    }
}




